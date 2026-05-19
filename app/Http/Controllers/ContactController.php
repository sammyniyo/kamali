<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function show(Request $request): View
    {
        $nonce = Str::random(48);
        $request->session()->put('contact_form_nonce', $nonce);

        return view('pages.contact', [
            'contactFormOpenedAt' => time(),
            'contactFormNonce' => $nonce,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        // Honeypot: bots often fill every field; humans never see this one.
        if (trim((string) $request->input('company_website', '')) !== '') {
            return $this->spamRedirect();
        }

        $expectedNonce = $request->session()->get('contact_form_nonce');
        $givenNonce = (string) $request->input('contact_form_nonce', '');
        if (! is_string($expectedNonce) || $expectedNonce === '' || ! hash_equals($expectedNonce, $givenNonce)) {
            return $this->spamRedirect();
        }

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:40'],
            'subject' => ['required', 'string', 'max:200'],
            'message' => ['required', 'string', 'min:25', 'max:8000'],
            'form_opened_at' => ['required', 'integer'],
        ]);

        $validator->after(function ($validator) use ($request): void {
            $opened = (int) $request->input('form_opened_at');
            if ($opened <= 0) {
                $validator->errors()->add('form_opened_at', 'invalid');

                return;
            }
            $elapsed = time() - $opened;
            if ($elapsed < 5) {
                $validator->errors()->add('message', 'Please wait a few seconds before sending — this helps us block automated submissions.');
            }
            if ($elapsed > 7200) {
                $validator->errors()->add('form_opened_at', 'This form expired. Refresh the page and try again.');
            }

            $message = (string) $request->input('message', '');
            $linkCount = preg_match_all('#https?://#i', $message);
            if ($linkCount > 5) {
                $validator->errors()->add('message', 'Please limit links in your message (maximum five).');
            }
        });

        if ($validator->fails()) {
            return redirect()->route('contact')
                ->withErrors($validator)
                ->withInput($request->except(['company_website', 'contact_form_nonce']));
        }

        $email = strtolower(trim((string) $request->input('email')));
        $messageBody = trim((string) $request->input('message'));
        $dedupeKey = 'contact_form:'.hash('sha256', $request->ip().'|'.$email.'|'.$messageBody);
        if (Cache::has($dedupeKey)) {
            return redirect()->route('contact')->with('contact_status', 'Thanks — we already received that message and will get back to you shortly.');
        }

        ContactMessage::query()->create([
            'name' => trim((string) $request->input('name')),
            'email' => $email,
            'phone' => $request->filled('phone') ? trim((string) $request->input('phone')) : null,
            'subject' => trim((string) $request->input('subject')),
            'message' => $messageBody,
        ]);

        Cache::put($dedupeKey, true, now()->addMinutes(2));

        $request->session()->forget('contact_form_nonce');

        return redirect()->route('contact')->with('contact_status', 'Thanks — your message was sent. We typically reply within 1–2 business days.');
    }

    /**
     * Same redirect as a real success so bots cannot probe the honeypot.
     */
    private function spamRedirect(): RedirectResponse
    {
        return redirect()->route('contact')->with('contact_status', 'Thanks — your message was sent. We typically reply within 1–2 business days.');
    }
}

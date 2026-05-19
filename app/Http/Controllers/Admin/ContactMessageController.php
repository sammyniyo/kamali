<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function index()
    {
        $q = request('q');
        $messages = ContactMessage::query()
            ->when($q, fn ($qq) => $qq->where(function ($w) use ($q) {
                $w->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%")
                    ->orWhere('subject', 'like', "%{$q}%")
                    ->orWhere('message', 'like', "%{$q}%");
            }))
            ->latest()
            ->paginate(30)
            ->withQueryString();
        return view('admin.messages.index', compact('messages'));
    }

    public function show(ContactMessage $contactMessage)
    {
        return view('admin.messages.show', ['message' => $contactMessage]);
    }

    public function markRead(ContactMessage $contactMessage)
    {
        $contactMessage->update(['read_at' => now()]);
        return back()->with('status', 'Marked as read.');
    }

    public function markUnread(ContactMessage $contactMessage)
    {
        $contactMessage->update(['read_at' => null]);
        return back()->with('status', 'Marked as unread.');
    }

    public function destroy(ContactMessage $contactMessage)
    {
        $contactMessage->delete();
        return redirect()->route('admin.messages.index')->with('status', 'Message deleted.');
    }
}

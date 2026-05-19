<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_page_renders(): void
    {
        $this->get('/contact')
            ->assertOk()
            ->assertSee('Send a message', false);
    }

    public function test_contact_form_persists_message_with_valid_payload(): void
    {
        $opened = now()->subSeconds(15)->getTimestamp();

        $this->get('/contact');
        $nonce = session('contact_form_nonce');

        $response = $this->from('/contact')->post('/contact', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '',
            'subject' => 'New build — London',
            'message' => 'We are planning a residential extension and would like to discuss scope and fees.',
            'form_opened_at' => (string) $opened,
            'company_website' => '',
            'contact_form_nonce' => $nonce,
        ]);

        $response->assertRedirect('/contact');
        $response->assertSessionHas('contact_status');

        $this->assertDatabaseHas('contact_messages', [
            'email' => 'test@example.com',
            'subject' => 'New build — London',
        ]);
    }

    public function test_honeypot_does_not_create_a_message(): void
    {
        $opened = now()->subSeconds(15)->getTimestamp();
        $before = ContactMessage::query()->count();

        $this->get('/contact');
        $nonce = session('contact_form_nonce');

        $response = $this->from('/contact')->post('/contact', [
            'name' => 'Bot',
            'email' => 'bot@example.com',
            'phone' => '',
            'subject' => 'SEO',
            'message' => 'We are planning a residential extension and would like to discuss scope and fees.',
            'form_opened_at' => (string) $opened,
            'company_website' => 'https://spam.test',
            'contact_form_nonce' => $nonce,
        ]);

        $response->assertRedirect('/contact');
        $response->assertSessionHas('contact_status');
        $this->assertSame($before, ContactMessage::query()->count());
    }

    public function test_wrong_or_missing_nonce_does_not_create_a_message(): void
    {
        $opened = now()->subSeconds(15)->getTimestamp();
        $before = ContactMessage::query()->count();

        $this->get('/contact');

        $response = $this->from('/contact')->post('/contact', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '',
            'subject' => 'Inquiry',
            'message' => 'We are planning a residential extension and would like to discuss scope and fees.',
            'form_opened_at' => (string) $opened,
            'company_website' => '',
            'contact_form_nonce' => 'invalid-nonce-value',
        ]);

        $response->assertRedirect('/contact');
        $response->assertSessionHas('contact_status');
        $this->assertSame($before, ContactMessage::query()->count());
    }

    public function test_too_fast_submission_fails_validation(): void
    {
        $this->get('/contact');
        $nonce = session('contact_form_nonce');

        $response = $this->from('/contact')->post('/contact', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '',
            'subject' => 'Inquiry',
            'message' => 'We are planning a residential extension and would like to discuss scope and fees.',
            'form_opened_at' => (string) time(),
            'company_website' => '',
            'contact_form_nonce' => $nonce,
        ]);

        $response->assertRedirect('/contact');
        $response->assertSessionHasErrors('message');
        $this->assertDatabaseCount('contact_messages', 0);
    }
}

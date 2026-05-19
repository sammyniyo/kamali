<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AdminPasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_reset_link_rejected_for_unknown_email(): void
    {
        Notification::fake();

        $response = $this->from(route('admin.password.request'))->post(route('admin.password.email'), [
            'email' => 'nobody@example.com',
        ]);

        $response->assertRedirect(route('admin.password.request'));
        $response->assertSessionHasErrors('email');
        Notification::assertNothingSent();
    }

    public function test_reset_link_sent_for_registered_email(): void
    {
        Notification::fake();

        $user = User::factory()->create(['email' => 'architect@example.com']);

        $response = $this->from(route('admin.password.request'))->post(route('admin.password.email'), [
            'email' => $user->email,
        ]);

        $response->assertRedirect(route('admin.password.request'));
        $response->assertSessionHas('status');
        $response->assertSessionHasNoErrors();
        Notification::assertSentTo($user, ResetPassword::class);
    }

    public function test_reset_email_is_normalized_to_lowercase(): void
    {
        Notification::fake();

        $user = User::factory()->create(['email' => 'team@example.com']);

        $response = $this->from(route('admin.password.request'))->post(route('admin.password.email'), [
            'email' => 'Team@Example.com',
        ]);

        $response->assertSessionHasNoErrors();
        Notification::assertSentTo($user, ResetPassword::class);
    }
}

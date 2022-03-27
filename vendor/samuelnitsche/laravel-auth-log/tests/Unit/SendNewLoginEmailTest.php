<?php

namespace SamuelNitsche\AuthLog\Tests\Unit;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use SamuelNitsche\AuthLog\Notifications\NewDevice;
use SamuelNitsche\AuthLog\Tests\Models\User;
use SamuelNitsche\AuthLog\Tests\TestCase;

class SendNewLoginEmailTest extends TestCase
{
    /** @test */
    public function it_notifies_users_about_a_new_login()
    {
        Notification::fake();

        $user = User::create(['name' => 'JohnDoe', 'email' => 'john@example.com']);

        Auth::login($user);

        Notification::assertSentTo($user, NewDevice::class);
    }

    /** @test */
    public function it_does_not_notify_users_about_a_second_login_from_the_same_device()
    {
        Notification::fake();

        $user = User::create(['name' => 'JohnDoe', 'email' => 'john@example.com']);

        Auth::login($user);

        Notification::assertSentTo($user, NewDevice::class, function ($email) use ($user) {
            $subject = trans('auth-log::messages.subject', ['app' => config('app.name')]);
            $content = trans('auth-log::messages.content', ['app' => config('app.name')]);

            return $email->subject = $subject && $email->content = $content;
        });

        Auth::logout();

        Notification::fake();

        Auth::login($user);

        Notification::assertNothingSent();
    }

    /** @test */
    public function it_does_not_notify_when_notifications_are_disabled()
    {
        config(['auth-log.notify' => false]);

        Notification::fake();

        $user = User::create(['name' => 'JohnDoe', 'email' => 'john@example.com']);

        Auth::login($user);

        Notification::assertNothingSent();
    }
}

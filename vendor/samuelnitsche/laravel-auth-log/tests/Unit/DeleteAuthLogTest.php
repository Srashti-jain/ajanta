<?php

namespace SamuelNitsche\AuthLog\Tests\Unit;

use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use SamuelNitsche\AuthLog\Tests\Models\User;
use SamuelNitsche\AuthLog\Tests\TestCase;

class DeleteAuthLogTest extends TestCase
{
    /** @test */
    public function it_deletes_all_entries_older_than_the_given_value()
    {
        Notification::fake();
        
        Carbon::setTestNow('2019-01-01 00:00:00');

        Auth::login($user = User::create(['name' => 'JohnDoe', 'email' => 'john@example.com']));

        $this->assertCount(1, $user->fresh()->authentications);

        Artisan::call('auth-log:clear');

        $this->assertCount(1, $user->fresh()->authentications);

        Carbon::setTestNow('2021-01-01 00:00:00');

        Artisan::call('auth-log:clear');

        $this->assertCount(0, $user->fresh()->authentications);
    }
}

<?php

namespace SamuelNitsche\AuthLog\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Jenssegers\Agent\Agent;
use SamuelNitsche\AuthLog\AuthLog;
use SamuelNitsche\AuthLog\Notifications\NewDevice;

class LogSuccessfulLogin
{
    /**
     * The request.
     *
     * @var Request
     */
    public $request;

    /**
     * Create the event listener.
     *
     * @param Request $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $agent = new Agent();
        $agent->setUserAgent($this->request->userAgent());

        $user = $event->user;
        $ip = $this->request->ip();
        $platform = $agent->platform();
        $browser = $agent->browser();
        $known = $user->authentications()->whereIpAddress($ip)->wherePlatform($platform)->whereBrowser($browser)->first();

        $authenticationLog = new AuthLog([
            'ip_address' => $ip,
            'platform' => $platform,
            'browser' => $browser,
            'login_at' => Carbon::now(),
        ]);

        $user->authentications()->save($authenticationLog);

        if (! $known && config('auth-log.notify')) {
            $user->notify(new NewDevice($authenticationLog));
        }
    }
}

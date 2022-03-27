<?php

namespace SamuelNitsche\AuthLog\Listeners;

use Illuminate\Auth\Events\Logout;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Jenssegers\Agent\Agent;
use SamuelNitsche\AuthLog\AuthLog;

class LogSuccessfulLogout
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
     * @param  Logout  $event
     * @return void
     */
    public function handle(Logout $event)
    {
        if ($event->user) {
            $agent = new Agent();
            $agent->setUserAgent($this->request->userAgent());

            $user = $event->user;
            $ip = $this->request->ip();
            $platform = $agent->platform();
            $browser = $agent->browser();
            $authenticationLog = $user->authentications()->whereIpAddress($ip)->wherePlatform($platform)->whereBrowser($browser)->first();

            if (! $authenticationLog) {
                $authenticationLog = new AuthLog([
                    'ip_address' => $ip,
                    'platform' => $platform,
                    'browser' => $browser,
                ]);
            }

            $authenticationLog->logout_at = Carbon::now();

            $user->authentications()->save($authenticationLog);
        }
    }
}

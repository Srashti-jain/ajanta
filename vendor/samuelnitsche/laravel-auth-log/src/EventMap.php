<?php

namespace SamuelNitsche\AuthLog;

trait EventMap
{
    /**
     * The Authentication Log event / listener mappings.
     *
     * @var array
     */
    protected $events = [
        'Illuminate\Auth\Events\Login' => [
            'SamuelNitsche\AuthLog\Listeners\LogSuccessfulLogin',
        ],

        'Illuminate\Auth\Events\Logout' => [
            'SamuelNitsche\AuthLog\Listeners\LogSuccessfulLogout',
        ],
    ];
}

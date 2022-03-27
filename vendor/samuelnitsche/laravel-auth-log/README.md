# Laravel Auth Log

[![Build Status](https://travis-ci.com/SamuelNitsche/laravel-auth-log.svg?branch=master)](https://travis-ci.com/SamuelNitsche/laravel-auth-log)
[![StyleCI](https://github.styleci.io/repos/188419456/shield?branch=master)](https://github.styleci.io/repos/188419456)

Laravel Auth Log is a package to automatically log all logins of your users. It can also send notifications when a successful login was made from an unknown device.

This package is a modified and extended version of [https://github.com/yadahan/laravel-authentication-log](https://github.com/yadahan/laravel-authentication-log). 

## Installation

> Laravel Auth Log requires Laravel 5.8 or higher, and PHP 7.2+.

You may use Composer to install Laravel Auth Log into your Laravel project:

    composer require samuelnitsche/laravel-auth-log

### Configuration

After installing the Laravel Auth Log, publish its config, migration and view, using the `vendor:publish` Artisan command:

    php artisan vendor:publish --provider="SamuelNitsche\AuthLog\AuthLogServiceProvider"

Next, you need to migrate your database. The Laravel Auth Log migration will create the table your application needs to store auth logs:

    php artisan migrate

Finally, add the `AuthLogable` and `Notifiable` traits to your authenticatable model (by default, `App\User` model). These traits provides various methods to allow you to get common auth log data, such as last login time, last login IP address, and set the channels to notify the user when login from a new device:

```php
use SamuelNitsche\AuthLog\AuthLogable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, AuthLogable;
}
```

### Basic Usage

Get all authentication logs for the user:

```php
User::find(1)->authentications;
```

Get the user last login info:

```php
User::find(1)->lastLoginAt();

User::find(1)->lastLoginIp();
```

Get the user previous login time & ip address (ignoring the current login):

```php
auth()->user()->previousLoginAt();

auth()->user()->previousLoginIp();
```

### Notify login from a new device

Notifications may be sent on the `mail`, `nexmo`, and `slack` channels. By default notify via email.

You may define `notifyAuthenticationLogVia` method to determine which channels the notification should be delivered on:

```php
/**
 * The Auth Log notifications delivery channels.
 *
 * @return array
 */
public function notifyAuthenticationLogVia()
{
    return ['nexmo', 'mail', 'slack'];
}
```

Of course you can disable notification by set the `notify` option in your `config/auth-log.php` configuration file to `false`:

```php
'notify' => env('AUTH_LOG_NOTIFY', false),
```

### Clear old logs

You may clear the old auth log records using the `auth-log:clear` Artisan command:

    php artisan auth-log:clear

Records that is older than the number of days specified in the `older` option in your `config/auth-log.php` will be deleted:

```php
'older' => 365,
```

## Contributing

Thank you for considering contributing to the Laravel Auth Log.

## License

Laravel Auth Log is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).

<?php

namespace SamuelNitsche\AuthLog\Tests;

use CreateAuthLogTable;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use SamuelNitsche\AuthLog\AuthLogServiceProvider;

abstract class TestCase extends OrchestraTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase();
        
        Notification::fake();
    }

    protected function getPackageProviders($app): array
    {
        return [
            AuthLogServiceProvider::class,
        ];
    }

    protected function setUpDatabase()
    {
        $this->createAuthLogTable();

        $this->createUserTable();
    }

    protected function createAuthLogTable()
    {
        include_once __DIR__.'/../database/migrations/2017_09_01_000000_create_auth_log_table.php';

        (new CreateAuthLogTable())->up();
    }

    protected function createUserTable()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });
    }
}

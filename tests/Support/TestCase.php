<?php

namespace Maize\Cache\Tests\Support;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Maize\Cache\CacheServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('cache:clear');

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Maize\\Cache\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            CacheServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('app.key', 'base64:WZWVY1aeHd5rooWQi7hyrXaizzW8VaEwqR3rFlfWfRs=');
        config()->set('database.default', 'testing');
        config()->set('cache.driver', 'array');

        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
    }
}

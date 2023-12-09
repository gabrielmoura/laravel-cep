<?php

namespace Gabrielmoura\LaravelCep;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class LaravelCepServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Registra o serviço
        $this->app->singleton(CepService::class, function (Application $app) {
            return new CepService($app->make(config('services.cep.endpoint', EndpointOption::DEFAULT)));
        });

        // Registra o facade
        $this->app->alias(Cep::class, 'Cep');
    }

    public function boot(): void
    {

    }
}

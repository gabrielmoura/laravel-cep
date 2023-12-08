<?php

namespace App\ServiceHttp\CepService;

use Gabrielmoura\LaravelCep\RequestCep;
use Gabrielmoura\LaravelCep\ViaCep;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class LaravelCepServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Registra a Interface de serviço
        $this->app->bind(RequestCep::class, ViaCep::class);
        // Registra a classe de serviço
        $this->app->singleton(CepService::class, fn (Application $app) => new CepService($this->app->make(RequestCep::class)));

    }

    public function boot(): void
    {

    }
}

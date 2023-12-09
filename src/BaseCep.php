<?php

namespace Gabrielmoura\LaravelCep;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class BaseCep
{
    protected PendingRequest $http;

    protected ?RedisWrapper $redis;

    /**
     * @description Trata o erro
     *
     * @throws CepException
     */
    protected function error(RequestException $e): void
    {
        throw new CepException($e->response->json() ?? $e->getMessage(), $e->response->status());
    }

    /**
     * @description Valida o CEP
     */
    protected function validate(string $cep): void
    {
        if (! preg_match('/^\d{5}-?\d{3}$/', $cep)) {
            throw new CepException('CEP inválido', 400);
        }
    }

    /**
     * @description Limpa o número
     */
    protected function numberClear(string $number): ?string
    {
        if ($number == null) {
            return null;
        }

        return preg_replace('/[^0-9]/', '', $number);
    }

    /**
     * BaseCep constructor.
     */
    public function __construct()
    {
        $this->http = Http::acceptJson()
            ->contentType('application/json');

        if (class_exists(\Illuminate\Support\Facades\Redis::class)) {
            $this->redis = new RedisWrapper(\Illuminate\Support\Facades\Redis::Connection());
        }
    }
}

<?php

namespace Gabrielmoura\LaravelCep;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;

class BaseCep
{
    protected PendingRequest $http;

    protected RedisWrapper $redis;

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
        if (! preg_match('/^[0-9]{8}$/', $cep)) {
            throw new CepException('CEP inválido', 400);
        }
    }

    /**
     * BaseCep constructor.
     */
    public function __construct()
    {
        $this->http = Http::acceptJson()
            ->contentType('application/json')
            ->withUserAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Safari/537.36');

        $this->redis = new RedisWrapper(Redis::Connection());
    }
}

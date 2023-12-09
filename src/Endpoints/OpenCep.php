<?php

namespace Gabrielmoura\LaravelCep\Endpoints;

use Gabrielmoura\LaravelCep\BaseCep;
use Gabrielmoura\LaravelCep\Dto\CepDto;
use Gabrielmoura\LaravelCep\RequestCep;

class OpenCep extends BaseCep implements RequestCep
{
    /**
     * @return array {bairro: string, cidade: string, estado: string, logradouro: string, cep: string}
     */
    private function getCep(string $cep): array
    {
        $this->validate($cep);

        $req = $this->http->get("https://opencep.com/v1/$cep.json");

        $req->onError(fn ($e) => $this->error($e));

        return $req->json();
    }

    public function find(string $cep, bool $cached = true): CepDto
    {
        if ($cached) {
            return new CepDto(
                $this->redis->rememberArray("cep:$cep", function () use ($cep) {
                    return $this->getCep($cep);
                }, 60 * 60 * 24)
            );
        }

        return new CepDto($this->getCep($cep));
    }
}

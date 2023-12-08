<?php

namespace Gabrielmoura\LaravelCep;

use Gabrielmoura\LaravelCep\Dto\CepDto;

class ViaCep extends BaseCep implements RequestCep
{
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

    private function getCep(string $cep): array
    {
        $this->validate($cep);

        $req = $this->http->get("https://viacep.com.br/ws/$cep/json/");

        $req->onError(fn($e) => $this->error($e));

        return $req->json();
    }
}

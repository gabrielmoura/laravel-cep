<?php

namespace Gabrielmoura\LaravelCep;

use Gabrielmoura\LaravelCep\Dto\CepDto;

class PostMon extends BaseCep implements RequestCep
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

    /**
     * @param  string  $cep CEP
     * @return array {bairro: string, cidade: string, estado: string, logradouro: string, cep: string}
     */
    private function getCep(string $cep): array
    {
        $this->validate($cep);

        $req = $this->http->get("https://api.postmon.com.br/v1/cep/$cep");

        $req->onError(fn ($e) => $this->error($e));

        return $req->json();
    }
}

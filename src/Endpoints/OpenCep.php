<?php

namespace Gabrielmoura\LaravelCep\Endpoints;

use Gabrielmoura\LaravelCep\BaseCep;
use Gabrielmoura\LaravelCep\Dto\CepDto;
use Gabrielmoura\LaravelCep\RequestCep;

class OpenCep extends BaseCep implements RequestCep
{
    /**
     * @param  string  $cep CEP
     * @return array {cep:string, logradouro:string, complemento:string, bairro:string, localidade:string, uf:string, ibge:string}
     */
    private function getCep(string $cep): array
    {
        $this->validate($cep);
        $cep = $this->numberClear($cep);

        $req = $this->http->get("https://opencep.com/v1/$cep.json");

        $req->onError(fn ($e) => $this->error($e));

        return $req->json();
    }

    private function transform(array $data): array
    {
        return [
            'cep' => $data['cep'],
            'logradouro' => $data['logradouro'],
            'complemento' => $data['complemento'],
            'bairro' => $data['bairro'],
            'localidade' => $data['localidade'],
            'uf' => $data['uf'],
            'ibge' => $data['ibge'],
            'gia' => null,
            'ddd' => null,
            'siafi' => null,
        ];

    }

    public function find(string $cep, bool $cached = true): CepDto
    {
        if ($cached && $this->hasRedis()) {
            return new CepDto(
                $this->redis->rememberArray("cep:$cep", function () use ($cep) {
                    return $this->transform(
                        $this->getCep($cep)
                    );
                }, 60 * 60 * 24)
            );
        }

        return new CepDto(
            $this->transform(
                $this->getCep($cep)
            )
        );
    }
}

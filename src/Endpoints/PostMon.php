<?php

namespace Gabrielmoura\LaravelCep\Endpoints;

use Gabrielmoura\LaravelCep\BaseCep;
use Gabrielmoura\LaravelCep\Dto\CepDto;
use Gabrielmoura\LaravelCep\RequestCep;

class PostMon extends BaseCep implements RequestCep
{
    public function find(string $cep, bool $cached = true): CepDto
    {
        if ($cached) {
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

    private function transform(array $data): array
    {
        return [
            'cep' => $data['cep'],
            'logradouro' => $data['logradouro'],
            'complemento' => null,
            'bairro' => $data['bairro'],
            'localidade' => $data['cidade'],
            'uf' => $data['estado'],
            'ibge' => $data['cidade_info']['codigo_ibge'],
            'gia' => null,
            'ddd' => null,
            'siafi' => null,
        ];
    }

    /**
     * @param  string  $cep CEP
     * @return array {bairro: string, cidade: string, logradouro: string, estado_info: {area_km2: string, codigo_ibge: string, nome: string}, cep: string, cidade_info: {area_km2: string, codigo_ibge: string}, estado: string}
     */
    private function getCep(string $cep): array
    {
        $this->validate($cep);

        $req = $this->http->get("https://api.postmon.com.br/v1/cep/$cep");

        $req->onError(fn ($e) => $this->error($e));

        return $req->json();
    }
}

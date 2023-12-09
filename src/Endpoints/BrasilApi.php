<?php

namespace Gabrielmoura\LaravelCep\Endpoints;

use Gabrielmoura\LaravelCep\BaseCep;
use Gabrielmoura\LaravelCep\Dto\CepDto;
use Gabrielmoura\LaravelCep\RequestCep;

class BrasilApi extends BaseCep implements RequestCep
{
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

    /**
     * @param  string  $cep CEP
     * @return array {cep:string, state:string, city:string, neighborhood:string, street:string, service:string}
     */
    private function getCep(string $cep): array
    {
        $this->validate($cep);

        $req = $this->http->get("https://brasilapi.com.br/api/cep/v1/$cep");

        $req->onError(fn ($e) => $this->error($e));

        return $req->json();
    }

    private function transform(array $data): array
    {
        return [
            'cep' => $data['cep'],
            'logradouro' => $data['street'],
            'complemento' => null,
            'bairro' => $data['neighborhood'],
            'localidade' => $data['city'],
            'uf' => $data['state'],
            'ibge' => null,
            'gia' => null,
            'ddd' => null,
            'siafi' => null,
        ];
    }
}

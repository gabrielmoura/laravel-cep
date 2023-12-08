<?php

namespace Gabrielmoura\LaravelCep\Dto;

final readonly class CepDto
{
    public string $cep;

    public string $logradouro;

    public ?string $complemento;

    public string $bairro;

    public string $localidade;

    public ?string $uf;

    public ?string $ibge;

    public ?string $gia;

    public ?string $ddd;

    public ?string $siafi;

    public function __construct(array $data)
    {
        $this->cep = data_get($data, 'cep');
        $this->logradouro = data_get($data, 'logradouro');
        $this->complemento = data_get($data, 'complemento');
        $this->bairro = data_get($data, 'bairro');
        $this->localidade = data_get($data, 'localidade');
        $this->uf = data_get($data, 'uf');
        $this->ibge = data_get($data, 'ibge');
        $this->gia = data_get($data, 'gia');
        $this->ddd = data_get($data, 'ddd');
        $this->siafi = data_get($data, 'siafi');
    }
}

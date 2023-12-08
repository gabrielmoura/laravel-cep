<?php

namespace App\ServiceHttp\CepService;

use Gabrielmoura\LaravelCep\Dto\CepDto;
use Gabrielmoura\LaravelCep\RequestCep;

class CepService
{
    public function __construct(protected RequestCep $pending)
    {
    }

    public function find(string $cep, bool $cached = true): CepDto
    {
        return $this->pending->find($cep, $cached);
    }
}

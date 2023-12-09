<?php

namespace Gabrielmoura\LaravelCep;

use Gabrielmoura\LaravelCep\Dto\CepDto;

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

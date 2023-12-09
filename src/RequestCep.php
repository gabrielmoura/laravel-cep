<?php

namespace Gabrielmoura\LaravelCep;

use Gabrielmoura\LaravelCep\Dto\CepDto;

interface RequestCep
{
    public function find(string $cep, bool $cached = true): CepDto;

    public function flushCache(?string $cep): void;
}

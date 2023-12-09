<?php

namespace Gabrielmoura\LaravelCep;

use Gabrielmoura\LaravelCep\Dto\CepDto;
use Illuminate\Support\Facades\Facade;

class Cep extends Facade
{
    /**
     * @method static CepDto find(string $cep, bool $cached = true)
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return CepService::class;
    }
}

<?php

namespace Gabrielmoura\LaravelCep;

use Gabrielmoura\LaravelCep\Endpoints\BrasilApi;
use Gabrielmoura\LaravelCep\Endpoints\OpenCep;
use Gabrielmoura\LaravelCep\Endpoints\PostMon;
use Gabrielmoura\LaravelCep\Endpoints\ViaCep;

enum EndpointOption
{
    const VIACEP = ViaCep::class;

    const POSTMON = PostMon::class;

    const OPENCEP = OpenCep::class;

    const BRASILAPI = BrasilApi::class;
}

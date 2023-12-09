# Laravel CEP

A simple Laravel package to get CEP information

<p align="center">
<a href="https://packagist.org/packages/gabrielmoura/laravel-cep"><img src="https://img.shields.io/packagist/v/gabrielmoura/laravel-cep" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/gabrielmoura/laravel-cep"><img src="https://img.shields.io/packagist/l/gabrielmoura/laravel-cep" alt="License"></a>
</p>

## Providers

- [ViaCEP](https://viacep.com.br/)
- [Postmon](https://postmon.com.br/)
- [Open CEP](https://opencep.com/)
- [Brasil API](https://brasilapi.com.br/)

## Configuration

If not defined, ViaCep will be used.

```php
// config/services.php
   'cep'=>[
        'endpoint' => \Gabrielmoura\LaravelCep\EndpointOption::VIACEP,
    ]
```

Consider installing **`illuminate/redis`** for automatic caching.

## Usage

### Container

```php
use Gabrielmoura\LaravelCep\CepService;
app(CepService::class)->find(cep:'01001000',cached: true);
```

### Facade

```php
use Gabrielmoura\LaravelCep\Cep;
Cep::find('01001000',cached: true);
```

## Compatibility

- Laravel 10.x

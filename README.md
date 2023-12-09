# Laravel CEP

A simple Laravel package to get CEP information

## Providers

- [ViaCEP](https://viacep.com.br/)
- [Postmon](https://postmon.com.br/)
- [Open CEP](https://opencep.com/)
- [Brasil API](https://brasilapi.com.br/)

## Configuration

```php
// config/services.php
   'cep'=>[
        'endpoint' => \Gabrielmoura\LaravelCep\EndpointOption::VIACEP,
    ]
```

## Usage

### Container

```php
use Gabrielmoura\LaravelCep\CepService;
app(CepService::class)->find('01001000');
```

### Facade

```php
use Gabrielmoura\LaravelCep\Cep;
Cep::find('01001000');
```

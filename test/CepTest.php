<?php

namespace Gabrielmoura\test;

use Gabrielmoura\LaravelCep\CepException;
use Gabrielmoura\LaravelCep\CepService;
use Gabrielmoura\LaravelCep\EndpointOption;
use Orchestra\Testbench\TestCase;

class CepTest extends TestCase
{
    public function testFindCityByCepUsingViaCepEndpoint()
    {
        $cepService = new CepService($this->app->make(EndpointOption::VIACEP));

        $address = $cepService->find('24912-595');

        $this->assertEquals('Maricá', $address->localidade);
    }

    public function testFindCityByCepUsingPostMonEndpoint()
    {
        $cepService = new CepService($this->app->make(EndpointOption::POSTMON));

        $address = $cepService->find('77820-226');

        $this->assertEquals('Avenida Brasil', $address->logradouro);
    }

    public function testFindCityByCepUsingOpenCepEndpoint()
    {
        $cepService = new CepService($this->app->make(EndpointOption::OPENCEP));

        $address = $cepService->find('59633-740');

        $this->assertEquals('Mossoró', $address->localidade);
    }

    public function testFindCityByCepUsingBrasilApiEndpoint()
    {
        $cepService = new CepService($this->app->make(EndpointOption::BRASILAPI));

        $address = $cepService->find('84182-110');

        $this->assertEquals('Castro', $address->localidade);
    }

    /**
     * @dataProvider invalidCepProvider
     */
    public function testValidationCepThrowsException($invalidCep)
    {
        // Arrange
        $cepService = new CepService($this->app->make(EndpointOption::DEFAULT));

        // Act & Assert
        $this->expectException(CepException::class);
        $cepService->find($invalidCep);
    }

    /**
     * Data provider for invalid CEPs.
     */
    public static function invalidCepProvider(): array
    {
        return [
            ['841821100'],
            ['84182'],
            ['9090-9090'],
            // Add more invalid CEPs as needed
        ];
    }
}

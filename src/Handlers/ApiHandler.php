<?php
namespace App\Handlers;

use App\Factories\ApiFactory;
use App\Interfaces\ApiInterface;

class ApiHandler implements ApiInterface
{
    /**
     * @return mixed
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function handleApiData()
    {
        return ApiFactory::connect()->getExchangeRates();
    }
}
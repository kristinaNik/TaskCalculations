<?php


namespace App\Handlers;


use App\Factories\ApiFactory;
use App\Interfaces\ApiInterface;

class ApiHandler implements ApiInterface
{
    /**
     * @return ApiFactory
     */
    public function handleApiData()
    {
        return ApiFactory::connect()->getExchangeRates();
    }
}
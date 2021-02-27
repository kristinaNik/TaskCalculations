<?php


namespace App\Factories;


use App\Services\ApiConnectionService;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\HttpOptions;

class ApiFactory
{
    /**
     * @return ApiConnectionService
     */
    public static function connect(): ApiConnectionService
    {
        return new ApiConnectionService(
            HttpClient::create(),
            new HttpOptions()
        );
    }
}
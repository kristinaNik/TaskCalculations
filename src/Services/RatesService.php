<?php


namespace App\Services;


use App\Interfaces\ApiInterface;

class RatesService
{

    /**
     * @var ApiInterface
     */
    private ApiInterface $api;

    /**
     * ConverterService constructor.
     * @param ApiInterface $api
     */
    public function __construct(ApiInterface $api)
    {
        $this->api = $api;
    }


    public function getRates()
    {
        return $this->api->handleApiData()->rates;
    }

}
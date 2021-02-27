<?php


namespace App\Services;


use Symfony\Component\HttpClient\HttpOptions;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiConnectionService
{

    /**
     * @var HttpClientInterface
     */
    private $client;

    /**
     * @var HttpOptions
     */
    private $options;


    public const API_URL = 'https://api.exchangeratesapi.io/latest';

    /**
     * ApiClientService constructor.
     * @param HttpClientInterface $client
     * @param HttpOptions $options
     */
    public function __construct(HttpClientInterface $client,HttpOptions $options)
    {
        $this->client = $client;
        $this->options = $options;
    }


    public function getExchangeRates()
    {
        $response = $this->client->request('GET', self::API_URL);
        $content =  $response->getContent();

        return json_decode($content);
    }
}
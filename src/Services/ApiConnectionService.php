<?php
namespace App\Services;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiConnectionService
{

    /**
     * @var HttpClientInterface
     */
    private $client;

    public const API_URL = 'https://api.exchangeratesapi.io/latest';

    /**
     * ApiClientService constructor.
     * @param HttpClientInterface $client
     */
    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @return mixed
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function getExchangeRates()
    {
        $response = $this->client->request('GET', self::API_URL);
        $content =  $response->getContent();

        return json_decode($content);
    }
}
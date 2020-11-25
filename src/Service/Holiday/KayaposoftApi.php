<?php

namespace App\Service\Holiday;

use Psr\Log\LoggerInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class KayaposoftApi
{
    private LoggerInterface $logger;
    private HttpClientInterface $client;

    public function __construct(LoggerInterface $logger, HttpClientInterface $client)
    {
        $this->logger = $logger;
        $this->client = $client;
    }

    public function getSupportedCountries(): ?array
    {

        $response = $this->client->request(
            'GET',
            'https://kayaposoft.com/enrico/json/v2.0/?action=getSupportedCountries'
        );

        try {
            $statusCode = $response->getStatusCode();
        } catch (ClientExceptionInterface $e) {
            return;
        } catch (RedirectionExceptionInterface $e) {
            return;
        } catch (ServerExceptionInterface $e) {
            return;
        } catch (TransportExceptionInterface $e) {
            return;
        }

        try {
            $content = $response->toArray();
        } catch (ClientExceptionInterface $e) {
            return;
        } catch (DecodingExceptionInterface $e) {
            return;
        } catch (RedirectionExceptionInterface $e) {
            return;
        } catch (ServerExceptionInterface $e) {
            return;
        } catch (TransportExceptionInterface $e) {
            return;
        }

        return $content;

    }
}
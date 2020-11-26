<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\ResponseInterface;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Config\Definition\Exception\Exception;

abstract class HttpClientService implements HttpClientServiceInterface
{
    private LoggerInterface $logger;
    private HttpClientInterface $client;

    public function __construct(LoggerInterface $logger, HttpClientInterface $client)
    {
        $this->logger = $logger;
        $this->client = $client;
    }

    public function getContent(string $method, string $url): string
    {

        $response = $this->getResponse($method, $url);

        $e = NULL;
        $content = [];
        try {
            $content = $response->getContent();
        } catch (ClientExceptionInterface $e) {
        } catch (RedirectionExceptionInterface $e) {
        } catch (ServerExceptionInterface $e) {
        } catch (TransportExceptionInterface $e) {
        }

        if ($e !== NULL) {
            $this->logger->error($e->getMessage());
            throw new Exception($e);
        }

        return $content;

    }

    public function getArrayContent(string $method, string $url): array
    {

        $response = $this->getResponse($method, $url);

        $e = NULL;
        $content = [];
        try {
            $content = $response->toArray();
        } catch (DecodingExceptionInterface $e) {
        } catch (ClientExceptionInterface $e) {
        } catch (RedirectionExceptionInterface $e) {
        } catch (ServerExceptionInterface $e) {
        } catch (TransportExceptionInterface $e) {
        }

        if ($e !== NULL) {
            $this->logger->error($e->getMessage());
            throw new Exception($e);
        }

        return $content;

    }

    private function getResponse(string $method, string $url): ResponseInterface
    {
        try {
            $response = $this->client->request(
                $method,
                $url
            );
        } catch (TransportExceptionInterface $e) {
            $this->logger->error($e->getMessage());
            throw new Exception($e);
        }
        return $response;
    }

}
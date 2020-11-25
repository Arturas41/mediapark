<?php

namespace App\Service;

interface HttpClientServiceInterface
{

    public function getContent(string $method, string $url): string;

    public function getArrayContent(string $method, string $url): array;

}
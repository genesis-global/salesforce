<?php

namespace GenesisGlobal\Salesforce\Client;

interface PerformanceLoggerInterface
{
    public function log($url, $requestTime, $method, $responseCode);
}

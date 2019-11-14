<?php

namespace GenesisGlobal\Salesforce\Client;

use GenesisGlobal\Salesforce\Authentication\AuthenticatorInterface;
use GenesisGlobal\Salesforce\Http\Exception\BadResponseException;
use GenesisGlobal\Salesforce\Http\HttpClientInterface;
use GenesisGlobal\Salesforce\Http\Response\ResponseCreatorInterface;
use GenesisGlobal\Salesforce\Http\Response\ResponseInterface;
use GenesisGlobal\Salesforce\Http\UrlGeneratorInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Httpful\Http;

/**
 * Class SalesforceClient
 * @package GenesisGlobal\Salesforce\Client
 */
class SalesforceClient implements SalesforceClientInterface, LoggerAwareInterface
{
    /**
     * Content of body type json
     */
    const BODY_TYPE_JSON = 'application/json';

    /**
     * @var HttpClientInterface
     */
    protected $httpClient;

    /**
     * @var UrlGeneratorInterface
     */
    protected $urlGenerator;

    /**
     * @var AuthenticatorInterface
     */
    protected $authenticator;

    /**
     * @var ResponseCreatorInterface
     */
    protected $responseCreator;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var PerformanceLoggerInterface
     */
    protected $performanceLogger;

    protected $timer;

    /**
     * SalesforceClient constructor.
     * @param HttpClientInterface $httpClient
     * @param UrlGeneratorInterface $urlGenerator
     * @param AuthenticatorInterface $authenticator
     * @param ResponseCreatorInterface $responseCreator
     */
    public function __construct(
        HttpClientInterface $httpClient,
        UrlGeneratorInterface $urlGenerator,
        AuthenticatorInterface $authenticator,
        ResponseCreatorInterface $responseCreator)
    {
        $this->httpClient = $httpClient;
        $this->urlGenerator = $urlGenerator;
        $this->authenticator = $authenticator;
        $this->responseCreator = $responseCreator;
    }

    /**
     * @param string $action
     * @param null $query
     * @return ResponseInterface
     */
    public function get($action = null, $query = null)
    {
        $url = $this->urlGenerator->getUrl($action, $this->resolveParams($query));

        try {
            $this->requestStartTime();
            $salesforceResponse = $this->httpClient->get(
                $url,
                [ 'headers' => $this->getAuthorizationHeaders() ]
            );
        } catch (BadResponseException $e) {
            return $this->manageError($e, $url, null, Http::GET);
        }
        $response = $this->responseCreator->create($salesforceResponse);
        $this->logRequest($url, null, $response->getCode(), $response->getContent(), Http::GET);
        return $this->responseCreator->create($salesforceResponse);
    }

    /**
     * @param string|null $action
     * @param null $data
     * @param null $query
     * @return ResponseInterface
     */
    public function post($action = null, $data = null, $query = null)
    {
        $url = $this->urlGenerator->getUrl($action, $this->resolveParams($query));
        try {
            $this->requestStartTime();
            $httpResponse = $this->httpClient->post(
                $url,
                $data,
                self::BODY_TYPE_JSON,
                [ 'headers' => $this->getAuthorizationHeaders() ]
            );
        } catch (BadResponseException $e) {
            return $this->manageError($e, $url, $data, Http::POST);
        }
        $response = $this->responseCreator->create($httpResponse);
        $this->logRequest($url, $data, $response->getCode(), $response->getContent(), Http::POST);
        return $response;
    }

    /**
     * @param string|null $action
     * @param null $data
     * @param null $query
     * @return ResponseInterface
     */
    public function patch($action = null, $data = null, $query = null)
    {
        $url = $this->urlGenerator->getUrl($action, $this->resolveParams($query));
        try {
            $this->requestStartTime();
            $httpResponse = $this->httpClient->patch(
                $url,
                $data,
                self::BODY_TYPE_JSON,
                [ 'headers' => $this->getAuthorizationHeaders() ]
            );
        } catch (BadResponseException $e) {
            return $this->manageError($e, $url, $data, Http::PATCH);
        }
        $response = $this->responseCreator->create($httpResponse);
        $this->logRequest($url, $data, $response->getCode(), $response->getContent(), Http::PATCH);
        return $response;
    }

    /**
     * @param $query
     * @return array|null
     */
    protected function resolveParams($query)
    {
        $params = null;
        if ($query) {
            $params = ['q' => $query];
        }
        return $params;
    }

    /**
     * @return array
     */
    protected function getAuthorizationHeaders()
    {
        return [
            'Authorization' => 'OAuth ' . $this->authenticator->getAccessToken()
        ];
    }

    protected function requestStartTime(): void
    {
        if (!$this->performanceLogger) {
            return;
        }

        $this->timer = microtime(true);
    }

    protected function requestStopTime(): void
    {
        $stop = microtime(true);
        $this->timer = $stop - $this->timer;
    }

    protected function performanceLog($url, $method, $responseCode): void
    {
        if ($this->performanceLogger) {
            $this->requestStopTime();
            $this->performanceLogger->log($url, $this->timer, $method, $responseCode);
        }
    }

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param PerformanceLoggerInterface $performanceLogger
     */
    public function setPerformanceLogger(PerformanceLoggerInterface $performanceLogger)
    {
        $this->performanceLogger = $performanceLogger;
    }

    /**
     * @param BadResponseException $e
     * @param $url
     * @param null $data
     * @return ResponseInterface
     */
    protected function manageError(BadResponseException $e, $url, $data = null, $method = null, $responseCode = 500)
    {
        $this->performanceLog($url, $method, $responseCode);
        if ($this->logger) {
            $this->logger->error($e->getMessage(), [
                'url' => $url,
                'data' => ($data ? $data: 'empty')
            ]);
        }
        return $this->responseCreator->create($e->getResponse());
    }

    protected function logRequest($url, $data = null, $responseCode = null, $response = null, $method = null)
    {
        $this->performanceLog($url, $method, $responseCode);
        if ($this->logger) {
            $this->logger->log(LogLevel::DEBUG, '[Request Log]', [
                'url' => $url,
                'data' => ($data ? $data : 'empty'),
                'responseCode' => $responseCode,
                'response' => $response
            ]);
        }
    }
}

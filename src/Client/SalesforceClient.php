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
            $salesforceResponse = $this->httpClient->get(
                $url,
                [ 'headers' => $this->getAuthorizationHeaders() ]
            );
        } catch (BadResponseException $e) {

            // we return Response with success=false
            return $this->manageError($e, $url);
        }
        $response = $this->responseCreator->create($salesforceResponse);
        $this->logRequest($url, null, $response->getCode(), $response->getContent());
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
            $httpResponse = $this->httpClient->post(
                $url,
                $data,
                self::BODY_TYPE_JSON,
                [ 'headers' => $this->getAuthorizationHeaders() ]
            );
        } catch (BadResponseException $e) {

            // we return Response with success=false
            return $this->manageError($e, $url, $data);
        }
        $response = $this->responseCreator->create($httpResponse);
        $this->logRequest($url, $data, $response->getCode(), $response->getContent());
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
            $httpResponse = $this->httpClient->patch(
                $url,
                $data,
                self::BODY_TYPE_JSON,
                [ 'headers' => $this->getAuthorizationHeaders() ]
            );
        } catch (BadResponseException $e) {

            return $this->manageError($e, $url, $data);
        }
        $response = $this->responseCreator->create($httpResponse);
        $this->logRequest($url, $data, $response->getCode(), $response->getContent());
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

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param BadResponseException $e
     * @param $url
     * @param null $data
     * @return ResponseInterface
     */
    protected function manageError(BadResponseException $e, $url, $data = null)
    {
        if ($e->getCode() === 401) {
            $this->authenticator->refreshToken();
        }

        if ($this->logger) {
            $this->logger->error($e->getMessage(), [
                'url' => $url,
                'data' => ($data ? $data: 'empty')
            ]);
        }
        return $this->responseCreator->create($e->getResponse());
    }

    protected function logRequest($url, $data = null, $responseCode = null, $response = null)
    {
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

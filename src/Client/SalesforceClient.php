<?php

namespace GenesisGlobal\Salesforce\Client;


use GenesisGlobal\Salesforce\Authentication\AuthenticatorInterface;
use GenesisGlobal\Salesforce\Http\HttpClientInterface;
use GenesisGlobal\Salesforce\Http\UrlGeneratorInterface;

/**
 * Class SalesforceClient
 * @package GenesisGlobal\Salesforce\Client
 */
class SalesforceClient implements SalesforceClientInterface
{
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
     * SalesforceClient constructor.
     * @param HttpClientInterface $httpClient
     * @param UrlGeneratorInterface $urlGenerator
     * @param AuthenticatorInterface $authenticator
     */
    public function __construct(
        HttpClientInterface $httpClient,
        UrlGeneratorInterface $urlGenerator,
        AuthenticatorInterface $authenticator)
    {
        $this->httpClient = $httpClient;
        $this->urlGenerator = $urlGenerator;
        $this->authenticator = $authenticator;
    }

    /**
     * @param string $action
     * @param null $query
     * @return mixed
     */
    public function get(string $action = null, $query = null)
    {
        return $this->request('get', $action, $query);
    }

    /**
     * @param string|null $action
     * @param null $data
     * @param null $query
     * @return mixed
     */
    public function post(string $action = null, $data = null, $query = null)
    {
        return $this->request('post', $action, $query);
    }

    /**
     * @param string|null $action
     * @param null $data
     * @param null $query
     * @return mixed
     */
    public function patch(string $action = null, $data = null, $query = null)
    {
        return $this->request('patch', $action, $query);
    }

    /**
     * @param string $type
     * @param $action
     * @param $query
     * @return mixed
     */
    protected function request(string $type, $action, $query)
    {
        $params = null;
        if ($query) {
            $params = ['q' => $query];
        }
        $method = $this->resolveMethod($type);

        $response = $this->httpClient->$method(
            $this->urlGenerator->getUrl($action, $params),
            [ 'headers' => $this->getAuthorizationHeaders() ]
        );

        return $response;
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
     * @param $type
     * @return string
     */
    protected function resolveMethod(string $type)
    {
        $type = strtolower($type);
        switch ($type) {
            case 'post':
                $method = 'post';
                break;
            case 'patch':
                $method = 'patch';
                break;
            case 'delete':
                $method = 'delete';
                break;
            default:
                $method = 'get';
        }
        return $method;
    }
}

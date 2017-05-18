<?php

namespace GenesisGlobal\Salesforce\Authentication;


use GenesisGlobal\Salesforce\Authentication\Exception\AuthenticationException;
use GenesisGlobal\Salesforce\Http\HttpClientInterface;
use GenesisGlobal\Salesforce\Http\UrlGeneratorInterface;
use Httpful\Mime;

/**
 * Class SalesforceUsernamePasswordAuthenticator
 * @package GenesisGlobal\Salesforce\Authentication
 */
class SalesforceUsernamePasswordAuthenticator implements AuthenticatorInterface
{

    /**
     * @var string
     */
    protected $token;

    /**
     * @var string
     */
    protected $clientId;

    /**
     * @var string
     */
    protected $clientSecret;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var HttpClientInterface
     */
    protected $httpClient;

    /**
     * @var UrlGeneratorInterface
     */
    protected $urlGenerator;

    /**
     * @var AuthenticationCallbackInterface
     */
    protected $authenticationCallback;

    /**
     * SalesforceUsernamePasswordAuthenticator constructor.
     * @param HttpClientInterface $httpClient
     * @param UrlGeneratorInterface $urlGenerator
     * @param $config
     * @param AuthenticationCallbackInterface $authenticationCallback
     */
    public function __construct(
        HttpClientInterface $httpClient,
        UrlGeneratorInterface $urlGenerator,
        $config,
        AuthenticationCallbackInterface $authenticationCallback = null)
    {
        $this->httpClient = $httpClient;
        $this->urlGenerator = $urlGenerator;
        $this->authenticationCallback = $authenticationCallback;

        $this->clientId = $config['client_id'];
        $this->clientSecret = $config['client_secret'];
        $this->username = $config['username'];
        $this->password = $config['password'];
    }

    /**
     * @return mixed
     * @throws AuthenticationException
     */
    public function getAccessToken()
    {
        if ($this->token) {
            return $this->token;
        }

        $response = $this->httpClient->post(
            $this->urlGenerator->getUrl(),
            $this->buildDataForAuthentication(),
            Mime::FORM
        );

        // if authentication callback passed, use it
        if ($this->authenticationCallback) {
            $this->authenticationCallback->afterAuthenticationRequest($response);
        }

        // return access_token
        if ($response->code == 200 && isset($response->body->access_token)) {
            return $response->body->access_token;
        }

        return null;
    }

    /**
     * Destroy token
     */
    public function refreshToken()
    {
        $this->token = null;
    }

    /**
     * @return array
     */
    protected function buildDataForAuthentication()
    {
        return [
            'grant_type' => 'password',
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'username' => $this->username,
            'password' => $this->password
        ];
    }
}

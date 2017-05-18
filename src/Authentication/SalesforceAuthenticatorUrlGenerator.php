<?php

namespace GenesisGlobal\Salesforce\Authentication;


use GenesisGlobal\Salesforce\Http\UrlGeneratorInterface;

/**
 * Class SalesforceAuthenticatorUrlGenerator
 * @package GenesisGlobal\Salesforce\Authentication
 */
class SalesforceAuthenticatorUrlGenerator implements UrlGeneratorInterface
{
    /**
     * @var string
     */
    protected $endpoint;

    /**
     * SalesforceAuthenticatorUrlGenerator constructor.
     * @param $config
     */
    public function __construct($config)
    {
        $this->endpoint = $config['endpoint'];
    }

    /**
     * @param null $action
     * @param null $parameters
     * @return string
     */
    public function getUrl($action = null, $parameters = null)
    {
        return $this->getBasePath();

    }

    /**
     * @return string
     */
    public function getBasePath()
    {
        // make sure we got only one slash there :)
        return rtrim($this->endpoint, "/") . '/services/oauth2/token';
    }
}

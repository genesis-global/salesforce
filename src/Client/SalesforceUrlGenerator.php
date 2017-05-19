<?php

namespace GenesisGlobal\Salesforce\Client;


use GenesisGlobal\Salesforce\Http\UrlGeneratorInterface;

/**
 * Class SalesforceUrlGenerator
 * @package GenesisGlobal\Salesforce\Client
 */
class SalesforceUrlGenerator implements UrlGeneratorInterface
{

    /**
     * @var string
     */
    protected $version;

    /**
     * @var string
     */
    protected $endpoint;

    /**
     * SalesforceUrlGenerator constructor.
     * @param $endpoint
     * @param $version
     */
    public function __construct($endpoint, $version)
    {
        $this->endpoint = $endpoint;
        $this->version = $version;
    }

    /**
     * @param null $action
     * @param null $parameters
     * @return string
     */
    public function getUrl($action = null, $parameters = null)
    {
        $url = $this->getBasePath();
        if ($action) {

            // make sure action doesn't have forwarding slash
            $url = $url . ltrim($action, "/");
        }
        $url = $this->addParameters($url, $parameters);

        return $url;
    }

    /**
     * @return string
     */
    public function getBasePath()
    {
        // make sure we got only one slash there :)
        return rtrim($this->endpoint, "/") . '/services/data/' . $this->version . '/';
    }

    /**
     * @param $path
     * @param $parameters
     * @return string
     */
    protected function addParameters($path, $parameters)
    {
        if ($parameters && is_array($parameters)) {

            $glue = '?';
            foreach ($parameters as $key => $value) {
                $path .= $glue . $key . '=' . strtr($value, ' ', '+');
                $glue = '&';
            }
        }
        return $path;
    }
}
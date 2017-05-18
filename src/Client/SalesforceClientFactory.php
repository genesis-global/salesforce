<?php

namespace GenesisGlobal\Salesforce\Client;


use GenesisGlobal\Salesforce\Authentication\SalesforceAuthenticatorUrlGenerator;
use GenesisGlobal\Salesforce\Authentication\SalesforceUsernamePasswordAuthenticator;
use GenesisGlobal\Salesforce\Http\HttpfulClient;

/**
 * Class SalesforceClientFactory
 *
 * Feel free to create your own factory with your custom dependencies
 * @package GenesisGlobal\Salesforce\Client
 */
class SalesforceClientFactory implements SalesforceClientFactoryInterface
{
    /**
     * @param array $config
     * config = [
     *      authentication => [
     *          endpoint => http://endpoint,
     *          client_id => id,
     *          client_secret => secret,
     *          username => name,
     *          password => pass
     *      ],
     *      rest => [
     *          version => 2.0,
     *          endpoint => http://endpoint
     *      ]
     * ]
     * @return SalesforceClient
     */
    public function create(array $config)
    {
        if (!isset($config['authentication']) || !isset($config['rest'])) {
            throw new \InvalidArgumentException('SalesforceClient creation failed, wrong parameters.');
        }

        $httpClient = new HttpfulClient();
        $authUrlGenerator = new SalesforceAuthenticatorUrlGenerator($config['authentication']);
        $authenticator = new SalesforceUsernamePasswordAuthenticator(
            $httpClient,
            $authUrlGenerator,
            $config['authentication']
        );

        $salesforceUrlGenerator = new SalesforceUrlGenerator($config['rest']);
        $client = new SalesforceClient(
            $httpClient,
            $salesforceUrlGenerator,
            $authenticator
        );

        return $client;
    }
}

<?php

namespace GenesisGlobal\Salesforce\Client;


/**
 * Interface SalesforceClientFactoryInterface
 * @package GenesisGlobal\Salesforce\Client
 */
interface SalesforceClientFactoryInterface
{
    /**
     * @param array $config
     * @return SalesforceClientInterface
     */
    public function create(array $config);
}

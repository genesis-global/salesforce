<?php

namespace GenesisGlobal\Salesforce\Client;


/**
 * Interface SalesforceClientInterface
 * @package GenesisGlobal\Salesforce\Client
 */
interface SalesforceClientInterface
{
    /**
     * @param string $action
     * @param null $query
     * @return mixed
     */
    public function get(string $action = null, $query = null);

    /**
     * @param string|null $action
     * @param null $query
     * @param null $data
     * @return mixed
     */
    public function post(string $action = null, $data = null, $query = null);

    /**
     * @param string|null $action
     * @param null $query
     * @param null $data
     * @return mixed
     */
    public function patch(string $action = null, $data = null, $query = null);
}

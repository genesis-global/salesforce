<?php

namespace GenesisGlobal\Salesforce\Authentication;


/**
 * Interface CredentialsKeeperInterface
 * Keeps credentials for Authenticator
 * @package GenesisGlobal\Salesforce\Authentication
 */
interface CredentialsKeeperInterface
{
    /**
     * @return array
     */
    public function getCredentials();
}
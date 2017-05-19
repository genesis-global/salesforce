<?php

namespace GenesisGlobal\Salesforce\Authentication;

/**
 * Class Credentials
 * @package GenesisGlobal\Salesforce\Authentication
 */
class Credentials implements CredentialsKeeperInterface
{
    /**
     * @var
     */
    protected $credentials;

    /**
     * UsernamePasswordCredentials constructor.
     * @param $credentials
     */
    public function __construct($credentials)
    {
        $this->credentials = $credentials;
    }

    /**
     * @return mixed
     */
    public function getCredentials()
    {
        return $this->credentials;
    }
}

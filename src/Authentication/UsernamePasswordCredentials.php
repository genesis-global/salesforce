<?php
/**
 * Created by PhpStorm.
 * User: qbik
 * Date: 19.05.2017
 * Time: 09:35
 */

namespace GenesisGlobal\Salesforce\Authentication;


/**
 * Class UsernamePasswordCredentials
 * @package GenesisGlobal\Salesforce\Authentication
 */
class UsernamePasswordCredentials implements CredentialsKeeperInterface
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

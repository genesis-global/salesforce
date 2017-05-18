<?php

namespace GenesisGlobal\Salesforce\Http;


/**
 * Interface UrlGeneratorInterface
 * @package GenesisGlobal\Salesforce\Http
 */
interface UrlGeneratorInterface
{
    /**
     * @param $action
     * @param null $parameters
     * @return string
     */
    public function getUrl($action = null, $parameters = null);
}

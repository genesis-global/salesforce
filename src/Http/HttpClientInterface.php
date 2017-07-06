<?php

namespace GenesisGlobal\Salesforce\Http;


/**
 * Interface HttpClientInterface
 * @package GenesisGlobal\Salesforce\Http
 */
interface HttpClientInterface
{
    /**
     * @param string $uri
     * @param null $options
     * @return mixed
     */
    public function get($uri, $options = null);

    /**
     * @param string $uri
     * @param $data
     * @param $sendsType
     * @param null $options
     * @return mixed
     */
    public function post($uri, $data, $sendsType, $options = null);

    /**
     * @param string $uri
     * @param $data
     * @param $sendsType
     * @param null $options
     * @return mixed
     */
    public function patch($uri, $data, $sendsType, $options = null);
}

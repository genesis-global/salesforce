<?php

namespace GenesisGlobal\Salesforce\Http;

use GenesisGlobal\Salesforce\Http\Exception\BadResponseException;
use GenesisGlobal\Salesforce\Http\Exception\HttpRequestException;
use Httpful\Mime;
use Httpful\Request as Client;
use Httpful\Request;
use Httpful\Response;

/**
 * Class HttpfulClient
 * @package GenesisGlobal\Salesforce\Http
 */
class HttpfulClient implements HttpClientInterface
{
    /**
     * @param string $uri
     * @param null $options
     * @return \Httpful\Response
     * @throws HttpRequestException
     */
    public function get($uri, $options = null)
    {
        try {
            $request = Client::get($uri);

            $this->addOptionsToRequest($request, $options);
            $response = $request->send();

        } catch (\Exception $e) {
            throw new HttpRequestException('Unexpected server response.' . $e->getMessage(), $e->getCode());
        }
        $this->afterRequest($response);
        return $response;
    }

    /**
     * @param string $uri
     * @param $data
     * @param $sendsType
     * @param null $options
     * @return \Httpful\Response
     * @throws HttpRequestException
     */
    public function post($uri, $data, $sendsType, $options = null)
    {
        try {
            $request = Client::post($uri)
                ->sendsType($sendsType)
                ->body($this->prepareBodyForPost($data, $sendsType));

            $this->addOptionsToRequest($request, $options);
            $response = $request->send();

        } catch (\Exception $e) {
            throw new HttpRequestException('Unexpected server response.' . $e->getMessage(), $e->getCode());
        }
        $this->afterRequest($response);
        return $response;
    }

    /**
     * @param string $uri
     * @param $data
     * @param $sendsType
     * @param null $options
     * @return \Httpful\Response
     * @throws HttpRequestException
     */
    public function patch($uri, $data, $sendsType, $options = null)
    {
        try {
            $request = Client::patch($uri)
                ->sendsType($sendsType)
                ->body($this->prepareBodyForPost($data, $sendsType));

            $this->addOptionsToRequest($request, $options);
            $response = $request->send();

        } catch (\Exception $e) {
            throw new HttpRequestException('Unexpected server response.' . $e->getMessage(), $e->getCode());
        }
        $this->afterRequest($response);
        return $response;
    }

    /**
     * @param $data
     * @param $sendsType
     * @return string
     */
    protected function prepareBodyForPost($data, $sendsType)
    {
        if ($sendsType === Mime::JSON) {
            $data = json_encode($data);
        } elseif ($sendsType == Mime::FORM) {
            $data = http_build_query($data);
        }
        return $data;
    }

    /**
     * @param Request $request
     * @param $options
     * @return Request
     */
    protected function addOptionsToRequest(Request $request, $options)
    {
        // add extra curl options
        if (is_array($options) && isset($options['curlOptions'])) {
            foreach ($options['curlOptions'] as $option => $value) {
                $request->addOnCurlOption($option, $value);
            }
        }

        // add extra headers
        if (is_array($options) && isset($options['headers'])) {
            $request->addHeaders($options['headers']);
        }

        // auto parse options check
        if (is_array($options) && isset($options['auto_parse'])) {
            $request->autoParse($options['auto_parse']);
        }
        return $request;
    }

    /**
     * @param Response $response
     * @throws BadResponseException
     */
    protected function afterRequest(Response $response)
    {
        if ($response->code >= 400) {
            throw new BadResponseException('Bad response.', $response->code, null, $response);
        }
    }
}

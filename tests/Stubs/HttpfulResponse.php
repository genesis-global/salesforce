<?php
/**
 * Created by PhpStorm.
 * User: qbik
 * Date: 06.07.2017
 * Time: 15:07
 */

namespace GenesisGlobal\Salesforce\Tests\Stubs;


use Httpful\Request;
use Httpful\Response;

class HttpfulResponse extends Response
{
    public function __construct($body, $contentType, $status)
    {
        // remove next line replace them to spaces
        $body = trim(preg_replace('/\s\s+/', ' ', $body));

        // build default headers with status and Content-Type from stub constructor
        $headers = 'HTTP/1.1 ' . $status .' OK
            Date: Fri, 10 Jun 2016 09:16:23 GMT
            Server: Apache/2.4.12 (Ubuntu)
            Cache-Control: no-cache
            Transfer-Encoding: chunked
            Content-Type: ' . $contentType;
        $request = Request::init()->expects($contentType);
        parent::__construct($body, $headers, $request);
    }
}
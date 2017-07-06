<?php
/**
 * Created by PhpStorm.
 * User: qbik
 * Date: 06.07.2017
 * Time: 14:48
 */

namespace GenesisGlobal\Salesforce\Tests\Client;


use GenesisGlobal\Salesforce\Authentication\AuthenticatorInterface;
use GenesisGlobal\Salesforce\Client\SalesforceClient;
use GenesisGlobal\Salesforce\Http\HttpClientInterface;
use GenesisGlobal\Salesforce\Http\Response\Response;
use GenesisGlobal\Salesforce\Http\Response\ResponseCreator;
use GenesisGlobal\Salesforce\Http\UrlGeneratorInterface;
use GenesisGlobal\Salesforce\Tests\Stubs\HttpfulResponse;
use Httpful\Mime;
use PHPUnit\Framework\TestCase;



class SalesforceClientTest extends TestCase
{
    protected $httpClient;

    protected $urlGenerator;

    protected $authenticator;

    protected $responseCreator;


    public function setUp()
    {
        $this->httpClient = $this->createMock(HttpClientInterface::class);
        $this->urlGenerator = $this->createMock(UrlGeneratorInterface::class);
        $this->responseCreator = new ResponseCreator();
        $this->authenticator = $this->createMock(AuthenticatorInterface::class);
    }

    public function testGet()
    {
        $successResponse = new HttpfulResponse(
            '{"testkey": "testresponsevalue"}',
            Mime::JSON,
            '200'
        );
        $httpClient = $this->httpClient;
        $httpClient->method('get')
            ->willReturnOnConsecutiveCalls(null, $successResponse);

        $client = new SalesforceClient(
            $this->httpClient,
            $this->urlGenerator,
            $this->authenticator,
            $this->responseCreator
        );

        /** @var Response $response */
        $response = $client->get();
        $this->assertEquals('Response from salesforce malformed.', $response->getErrors()[0]->getMessage());
        $this->assertEquals('SALESFORCE_RESPONSE_MALFORMED', $response->getErrors()[0]->getCode());

        $response = $client->get();
        $this->assertObjectHasAttribute('testkey', $response->getContent());
        $this->assertEquals('testresponsevalue', $response->getContent()->testkey);
    }
}
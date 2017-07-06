<?php
/**
 * Created by PhpStorm.
 * User: qbik
 * Date: 06.07.2017
 * Time: 14:30
 */

namespace GenesisGlobal\Salesforce\Tests\Authentication;


use GenesisGlobal\Salesforce\Authentication\CredentialsKeeperInterface;
use GenesisGlobal\Salesforce\Authentication\SalesforceUsernamePasswordAuthenticator;
use GenesisGlobal\Salesforce\Http\HttpClientInterface;
use GenesisGlobal\Salesforce\Http\UrlGeneratorInterface;
use Httpful\Mime;
use PHPUnit\Framework\TestCase;

class SalesforceUsernamePasswordAuthenticatorTest extends TestCase
{
    protected $httpClient;

    protected $urlGenerator;

    protected $credentialsKeeper;

    public function setUp()
    {
        $url = 'http://test-url.com';
        $authData = [
            'client_id' => 'testclientid',
            'client_secret' => 'testsecret',
            'username' => 'testuser',
            'password' => 'password',
            'security_token' => 'testtoken'
        ];

        $dataToSend = [
            'grant_type' => 'password',
            'client_id' => 'testclientid',
            'client_secret' => 'testsecret',
            'username' => 'testuser',
            'password' => 'passwordtesttoken'
        ];
        $result = new \stdClass();
        $result->code = 200;
        $result->body = new \stdClass();
        $result->body->access_token = 'accesstoken';

        $this->httpClient = $this->createMock(HttpClientInterface::class);
        $this->httpClient->method('post')
            ->with($url, $dataToSend, Mime::FORM)
            ->willReturn($result);
        ;
        $this->urlGenerator = $this->createMock(UrlGeneratorInterface::class);
        $this->urlGenerator->method('getUrl')
            ->willReturn($url)
        ;
        $this->credentialsKeeper = $this->createMock(CredentialsKeeperInterface::class);
        $this->credentialsKeeper->method('getCredentials')
            ->willReturn($authData)
        ;
    }

    public function testAccessToken()
    {
        $authenticator = new SalesforceUsernamePasswordAuthenticator(
            $this->httpClient,
            $this->urlGenerator,
            $this->credentialsKeeper
        );
        $this->assertEquals('accesstoken',$authenticator->getAccessToken());
    }
}
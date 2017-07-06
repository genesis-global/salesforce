<?php
/**
 * Created by PhpStorm.
 * User: qbik
 * Date: 06.07.2017
 * Time: 16:41
 */

namespace GenesisGlobal\Salesforce\Tests\Response;


use GenesisGlobal\Salesforce\Http\Response\ResponseCreator;
use GenesisGlobal\Salesforce\Tests\Stubs\HttpfulResponse;
use Httpful\Mime;
use PHPUnit\Framework\TestCase;

class ResponseCreatorTest extends TestCase
{
    public function testCreate()
    {
        $creator = new ResponseCreator();

        $failedResponse = new \stdClass();

        $this->assertEquals(
            'Response from salesforce malformed.',
            $creator->create($failedResponse)->getErrors()[0]->getMessage()
        );
        $this->assertEquals(
            'SALESFORCE_RESPONSE_MALFORMED',
            $creator->create($failedResponse)->getErrors()[0]->getCode()
        );

        $errors = [
            'errors' => [
                [
                    'errorCode' => 'some salesforce error code',
                    'message' => 'some salesforce error message'
                ],
                [
                    'errorCode' => 'second error code',
                    'message' => 'second error message'
                ],
            ]
        ];
        $responseWithError = new HttpfulResponse(json_encode($errors), Mime::JSON, 200);

        $this->assertEquals(
            'some salesforce error message',
            $creator->create($responseWithError)->getErrors()[0]->getMessage()
        );
        $this->assertEquals(
            'some salesforce error code',
            $creator->create($responseWithError)->getErrors()[0]->getCode()
        );

        $this->assertEquals(
            'second error message',
            $creator->create($responseWithError)->getErrors()[1]->getMessage()
        );
        $this->assertEquals(
            'second error code',
            $creator->create($responseWithError)->getErrors()[1]->getCode()
        );

        $responseWithSuccess = new HttpfulResponse(json_encode(['someKey' => 'someValue']), Mime::JSON, 200);
        $this->assertObjectHasAttribute('someKey', $creator->create($responseWithSuccess)->getContent());
        $this->assertEquals('someValue', $creator->create($responseWithSuccess)->getContent()->someKey);
    }
}
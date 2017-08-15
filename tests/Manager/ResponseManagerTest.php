<?php

namespace Chubbyphp\Tests\ApiHttp\Manager;

use Chubbyphp\ApiHttp\Factory\ResponseFactoryInterface;
use Chubbyphp\ApiHttp\Manager\RequestManagerInterface;
use Chubbyphp\ApiHttp\Manager\ResponseManager;
use Chubbyphp\Serialization\SerializerInterface;
use Chubbyphp\Serialization\TransformerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Http\Response;

/**
 * @covers \Chubbyphp\ApiHttp\Manager\ResponseManager
 */
final class ResponseManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateEmptyResponse()
    {
        $responseHandler = new ResponseManager(
            $this->getRequestManager(),
            $this->getResponseFactory(),
            $this->getSerializer(),
            $this->getTransform()
        );

        $response = $responseHandler->createResponse($this->getRequest());

        self::assertSame(204, $response->getStatusCode());
    }

    public function testCreateResponseWithoutAccept()
    {
        $responseHandler = new ResponseManager(
            $this->getRequestManager(),
            $this->getResponseFactory(),
            $this->getSerializer(),
            $this->getTransform()
        );

        $object = new \stdClass();
        $object->key = 'value';

        $response = $responseHandler->createResponse($this->getRequest(), 200, $object);

        self::assertSame(406, $response->getStatusCode());
    }

    public function testCreateResponse()
    {
        $responseHandler = new ResponseManager(
            $this->getRequestManager('application/json'),
            $this->getResponseFactory(),
            $this->getSerializer(),
            $this->getTransform()
        );

        $object = new \stdClass();
        $object->key = 'value';

        $response = $responseHandler->createResponse($this->getRequest(), 200, $object);

        self::assertSame(200, $response->getStatusCode());
        self::assertSame('{"key":"value"}', (string) $response->getBody());
    }

    /**
     * @param string|null $accept
     *
     * @return RequestManagerInterface
     */
    private function getRequestManager(string $accept = null): RequestManagerInterface
    {
        /** @var RequestManagerInterface|\PHPUnit_Framework_MockObject_MockObject $responseManager */
        $responseManager = $this->getMockBuilder(RequestManagerInterface::class)
            ->setMethods(['getAccept', 'getContentType', 'getDataFromRequestBody', 'getDataFromRequestQuery'])
            ->getMock();

        $responseManager->expects(self::any())->method('getAccept')->willReturnCallback(
            function () use ($accept) {
                return $accept;
            }
        );

        return $responseManager;
    }

    /**
     * @return ResponseFactoryInterface
     */
    private function getResponseFactory(): ResponseFactoryInterface
    {
        /** @var ResponseFactoryInterface|\PHPUnit_Framework_MockObject_MockObject $responseFactory */
        $responseFactory = $this->getMockBuilder(ResponseFactoryInterface::class)
            ->setMethods(['createResponse'])
            ->getMock();

        $responseFactory->expects(self::any())->method('createResponse')->willReturnCallback(
            function (int $code = 200) {
                return new Response($code);
            }
        );

        return $responseFactory;
    }

    /**
     * @return SerializerInterface
     */
    private function getSerializer(): SerializerInterface
    {
        /** @var SerializerInterface|\PHPUnit_Framework_MockObject_MockObject $deserializer */
        $deserializer = $this->getMockBuilder(SerializerInterface::class)
            ->setMethods(['serialize'])
            ->getMockForAbstractClass();

        $deserializer->expects(self::any())->method('serialize')->willReturnCallback(
            function (Request $request, $object, string $path = '') {
                return (array) $object;
            }
        );

        return $deserializer;
    }

    /**
     * @return TransformerInterface
     */
    private function getTransform(): TransformerInterface
    {
        /** @var TransformerInterface|\PHPUnit_Framework_MockObject_MockObject $transform */
        $transform = $this->getMockBuilder(TransformerInterface::class)
            ->setMethods([])
            ->getMockForAbstractClass();

        $transform->expects(self::any())->method('transform')->willReturnCallback(
            function (array $data, string $contentType) {
                self::assertSame('application/json', $contentType);

                return json_encode($data);
            }
        );

        return $transform;
    }

    /**
     * @return Request
     */
    private function getRequest(): Request
    {
        /** @var Request|\PHPUnit_Framework_MockObject_MockObject $request */
        $request = $this->getMockBuilder(Request::class)
            ->setMethods([])
            ->getMockForAbstractClass();

        return $request;
    }
}

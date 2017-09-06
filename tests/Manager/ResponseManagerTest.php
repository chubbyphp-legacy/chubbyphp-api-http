<?php

namespace Chubbyphp\Tests\ApiHttp\Manager;

use Chubbyphp\ApiHttp\Error\ErrorInterface;
use Chubbyphp\ApiHttp\Factory\ResponseFactoryInterface;
use Chubbyphp\ApiHttp\Manager\RequestManagerInterface;
use Chubbyphp\ApiHttp\Manager\ResponseManager;
use Chubbyphp\Serialization\SerializerInterface;
use Chubbyphp\Serialization\TransformerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\StreamInterface;

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

        $response = $responseHandler->createResponse($this->getRequest(), 200, 'application/json');

        self::assertSame(204, $response->getStatusCode());
    }

    public function testCreateResponse()
    {
        $responseHandler = new ResponseManager(
            $this->getRequestManager(),
            $this->getResponseFactory(),
            $this->getSerializer(),
            $this->getTransform()
        );

        $object = new \stdClass();
        $object->key = 'value';

        $response = $responseHandler->createResponse($this->getRequest(), 200, 'application/json', $object);

        self::assertSame(200, $response->getStatusCode());
        self::assertSame('{"key":"value"}', (string) $response->getBody());
    }

    public function testCreateErrorResponse()
    {
        $responseHandler = new ResponseManager(
            $this->getRequestManager(),
            $this->getResponseFactory(),
            $this->getSerializer(),
            $this->getTransform()
        );

        $response = $responseHandler->createResponseByError(
            $this->getRequest(),
            403,
            'application/json',
            $this->getError()
        );

        self::assertSame(403, $response->getStatusCode());
    }

    /**
     * @return RequestManagerInterface
     */
    private function getRequestManager(
        array $supportedAccepts = [],
        array $supportedContentTypes = []
    ): RequestManagerInterface {
        /** @var RequestManagerInterface|\PHPUnit_Framework_MockObject_MockObject $responseManager */
        $responseManager = $this->getMockBuilder(RequestManagerInterface::class)
            ->setMethods([
                'getAccept',
                'getAcceptLanguage',
                'getContentType',
                'getDataFromRequestBody',
                'getDataFromRequestQuery',
                'getSupportedAccepts',
                'getSupportedContentTypes',
                'getSupportedLocales'
            ])
            ->getMock();

        $responseManager->expects(self::any())->method('getSupportedAccepts')->willReturn($supportedAccepts);
        $responseManager->expects(self::any())->method('getSupportedContentTypes')->willReturn($supportedContentTypes);

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
                return $this->getResponse($code, $this->getBody());
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

    /**
     * @param int             $code
     * @param StreamInterface $body
     *
     * @return Response
     */
    private function getResponse(int $code, StreamInterface $body): Response
    {
        /** @var Response|\PHPUnit_Framework_MockObject_MockObject $response */
        $response = $this->getMockBuilder(Response::class)
            ->setMethods(['withStatus', 'getStatusCode', 'withHeader', 'getBody'])
            ->getMockForAbstractClass();

        $response->__code = $code;
        $response->__headers = [];
        $response->__body = $body;

        $response->expects(self::any())->method('getStatusCode')->willReturnCallback(
            function () use ($response) {
                return $response->__code;
            }
        );

        $response->expects(self::any())->method('withStatus')->willReturnCallback(
            function ($code) use ($response) {
                $response->__code = $code;

                return $response;
            }
        );

        $response->expects(self::any())->method('withHeader')->willReturnCallback(
            function ($name, $value) use ($response) {
                $response->__headers[$name] = $value;

                return $response;
            }
        );

        $response->expects(self::any())->method('getBody')->willReturnCallback(
            function () use ($response) {
                return $response->__body;
            }
        );

        return $response;
    }

    /**
     * @return StreamInterface
     */
    private function getBody(): StreamInterface
    {
        /** @var StreamInterface|\PHPUnit_Framework_MockObject_MockObject $body */
        $body = $this->getMockBuilder(StreamInterface::class)
            ->setMethods(['write', '__toString'])
            ->getMockForAbstractClass();

        $body->__content = '';

        $body->expects(self::any())->method('write')->willReturnCallback(
            function ($string) use ($body) {
                $body->__content = $string;

                return strlen($string);
            }
        );

        $body->expects(self::any())->method('__toString')->willReturnCallback(
            function () use ($body) {
                return $body->__content;
            }
        );

        return $body;
    }
    
    /**
     * @return ErrorInterface
     */
    private function getError(): ErrorInterface
    {
        /** @var ErrorInterface|\PHPUnit_Framework_MockObject_MockObject $error */
        $error = $this->getMockBuilder(ErrorInterface::class)
            ->setMethods(['getScope', 'getKey', 'getDetail', 'getReference', 'getArguments'])
            ->getMockForAbstractClass();

        return $error;
    }
}

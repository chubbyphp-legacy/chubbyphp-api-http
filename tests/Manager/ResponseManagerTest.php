<?php

namespace Chubbyphp\Tests\ApiHttp\Manager;

use Chubbyphp\ApiHttp\Error\Error;
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

    public function testCreateEmptyResponseWithDiffrentStatusCode()
    {
        $responseHandler = new ResponseManager(
            $this->getRequestManager(),
            $this->getResponseFactory(),
            $this->getSerializer(),
            $this->getTransform()
        );

        $response = $responseHandler->createResponse($this->getRequest(), 201, 'application/json');

        self::assertSame(201, $response->getStatusCode());
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
            418,
            'application/json',
            new Error(Error::SCOPE_RESOURCE, 'you_are_a_teapod')
        );

        self::assertSame(418, $response->getStatusCode());
        self::assertSame(
            '{"scope":"resource","key":"you_are_a_teapod","detail":null,"reference":null,"arguments":[]}',
            (string) $response->getBody()
        );
    }

    public function testCreateBodyNotDeserializableResponse()
    {
        $responseHandler = new ResponseManager(
            $this->getRequestManager([], ['application/json']),
            $this->getResponseFactory(),
            $this->getSerializer(),
            $this->getTransform()
        );

        $body = $this->getBody();
        $body->write('{{""}');

        $response = $responseHandler->createBodyNotDeserializableResponse(
            $this->getRequest([], $body),
            'application/json',
            'application/json'
        );

        self::assertSame(400, $response->getStatusCode());
        self::assertSame(
            '{"scope":"body","key":"body_not_deserializable","detail":"the given body is not deserializable with given content-type","reference":"deserialize","arguments":{"contentType":"application\/json","body":"{{\"\"}"}}',
            (string) $response->getBody()
        );
    }

    public function testCreatePermissionDeniedResponse()
    {
        $responseHandler = new ResponseManager(
            $this->getRequestManager([], ['application/json']),
            $this->getResponseFactory(),
            $this->getSerializer(),
            $this->getTransform()
        );

        $response = $responseHandler->createPermissionDeniedResponse(
            $this->getRequest(),
            'application/json',
            'user',
            ['id' => 1]
        );

        self::assertSame(403, $response->getStatusCode());
        self::assertSame(
            '{"scope":"header","key":"permission_denied","detail":"the wished resource does not exist","reference":"user","arguments":{"id":1}}',
            (string) $response->getBody()
        );
    }

    public function testCreateResourceNotFoundResponse()
    {
        $responseHandler = new ResponseManager(
            $this->getRequestManager([], ['application/json']),
            $this->getResponseFactory(),
            $this->getSerializer(),
            $this->getTransform()
        );

        $response = $responseHandler->createResourceNotFoundResponse(
            $this->getRequest(),
            'application/json',
            'model',
            ['id' => 1]
        );

        self::assertSame(404, $response->getStatusCode());
        self::assertSame(
            '{"scope":"resource","key":"resource_not_found","detail":"the wished resource does not exist","reference":"model","arguments":{"id":1}}',
            (string) $response->getBody()
        );
    }

    public function testCreateAcceptNotSupportedResponse()
    {
        $responseHandler = new ResponseManager(
            $this->getRequestManager(['application/json']),
            $this->getResponseFactory(),
            $this->getSerializer(),
            $this->getTransform()
        );

        $response = $responseHandler->createAcceptNotSupportedResponse(
            $this->getRequest(['Accept' => 'application/php'])
        );

        self::assertSame(406, $response->getStatusCode());
        self::assertTrue($response->hasHeader('X-Not-Acceptable'));
        self::assertSame(
            'Accept "application/php" is not supported, supported are application/json',
            $response->getHeaderLine('X-Not-Acceptable')
        );
    }

    public function testCreateContentTypeNotSupportedResponse()
    {
        $responseHandler = new ResponseManager(
            $this->getRequestManager([], ['application/json']),
            $this->getResponseFactory(),
            $this->getSerializer(),
            $this->getTransform()
        );

        $response = $responseHandler->createContentTypeNotSupportedResponse(
            $this->getRequest(['Content-Type' => 'application/php']),
            'application/json'
        );

        self::assertSame(415, $response->getStatusCode());
        self::assertSame(
            '{"scope":"header","key":"contentype_not_supported","detail":"the given content type is not supported","reference":"content-type","arguments":{"contentType":"application\/php","supportedContentTypes":["application\/json"]}}',
            (string) $response->getBody()
        );
    }

    public function testCreateValidationErrorResponse()
    {
        $responseHandler = new ResponseManager(
            $this->getRequestManager([], ['application/json']),
            $this->getResponseFactory(),
            $this->getSerializer(),
            $this->getTransform()
        );

        $response = $responseHandler->createValidationErrorResponse(
            $this->getRequest(),
            'application/json',
            Error::SCOPE_BODY,
            'model',
            ['name' => ['not.null']]
        );

        self::assertSame(422, $response->getStatusCode());
        self::assertSame(
            '{"scope":"body","key":"validation_error","detail":"there where validation errors while validating the object","reference":"model","arguments":{"name":["not.null"]}}',
            (string) $response->getBody()
        );
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
                'getSupportedLocales',
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
                if ($object instanceof ErrorInterface) {
                    return [
                        'scope' => $object->getScope(),
                        'key' => $object->getKey(),
                        'detail' => $object->getDetail(),
                        'reference' => $object->getReference(),
                        'arguments' => $object->getArguments(),
                    ];
                }

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
     * @param array $headers
     *
     * @return Request
     */
    private function getRequest(array $headers = [], StreamInterface $body = null): Request
    {
        /** @var Request|\PHPUnit_Framework_MockObject_MockObject $request */
        $request = $this->getMockBuilder(Request::class)
            ->setMethods(['hasHeader', 'getHeaderLine'])
            ->getMockForAbstractClass();

        $request->__headers = $headers;
        $request->__body = $body;

        $request->expects(self::any())->method('hasHeader')->willReturnCallback(
            function ($name) use ($request) {
                return isset($request->__headers[$name]);
            }
        );

        $request->expects(self::any())->method('getHeaderLine')->willReturnCallback(
            function ($name) use ($request) {
                return $request->__headers[$name];
            }
        );

        $request->expects(self::any())->method('getBody')->willReturnCallback(
            function () use ($request) {
                if (null === $request->__body) {
                    return $this->getBody();
                }

                return $request->__body;
            }
        );

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
            ->setMethods(['withStatus', 'getStatusCode', 'hasHeader', 'getHeaderLine', 'withHeader', 'getBody'])
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

        $response->expects(self::any())->method('hasHeader')->willReturnCallback(
            function ($name) use ($response) {
                return isset($response->__headers[$name]);
            }
        );

        $response->expects(self::any())->method('getHeaderLine')->willReturnCallback(
            function ($name) use ($response) {
                return $response->__headers[$name];
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

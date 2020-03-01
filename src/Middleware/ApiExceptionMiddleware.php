<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Middleware;

use Chubbyphp\ApiHttp\ApiProblem\ServerError\InternalServerError;
use Chubbyphp\ApiHttp\Manager\ResponseManagerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

final class ApiExceptionMiddleware implements MiddlewareInterface
{
    /**
     * @var ResponseManagerInterface
     */
    private $responseManager;

    /**
     * @var bool
     */
    private $debug;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        ResponseManagerInterface $responseManager,
        bool $debug = false,
        ?LoggerInterface $logger = null
    ) {
        $this->responseManager = $responseManager;
        $this->debug = $debug;
        $this->logger = $logger ?? new NullLogger();
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (\Throwable $exception) {
            return $this->handleException($request, $exception);
        }
    }

    private function handleException(ServerRequestInterface $request, \Throwable $exception): ResponseInterface
    {
        $backtrace = $this->backtrace($exception);

        $this->logger->error('Exception', ['backtrace' => $backtrace]);

        if (null === $accept = $request->getAttribute('accept')) {
            throw $exception;
        }

        if ($this->debug) {
            $internalServerError = new InternalServerError($exception->getMessage());
            $internalServerError->setBacktrace($backtrace);
        } else {
            $internalServerError = new InternalServerError();
        }

        return $this->responseManager->createFromApiProblem($internalServerError, $accept);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function backtrace(\Throwable $exception): array
    {
        $exceptions = [];
        do {
            $exceptions[] = [
                'class' => get_class($exception),
                'message' => $exception->getMessage(),
                'code' => $exception->getCode(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'trace' => $exception->getTraceAsString(),
            ];
        } while ($exception = $exception->getPrevious());

        return $exceptions;
    }
}

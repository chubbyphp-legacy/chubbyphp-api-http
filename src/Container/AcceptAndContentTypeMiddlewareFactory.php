<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Container;

use Chubbyphp\ApiHttp\Manager\ResponseManagerInterface;
use Chubbyphp\ApiHttp\Middleware\AcceptAndContentTypeMiddleware;
use Chubbyphp\Negotiation\AcceptNegotiatorInterface;
use Chubbyphp\Negotiation\ContentTypeNegotiatorInterface;
use Psr\Container\ContainerInterface;

final class AcceptAndContentTypeMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): AcceptAndContentTypeMiddleware
    {
        return new AcceptAndContentTypeMiddleware(
            $container->get(AcceptNegotiatorInterface::class),
            $container->get(ContentTypeNegotiatorInterface::class),
            $container->get(ResponseManagerInterface::class)
        );
    }
}

<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\ServiceFactory;

use Chubbyphp\ApiHttp\Manager\ResponseManagerInterface;
use Chubbyphp\ApiHttp\Middleware\AcceptAndContentTypeMiddleware;
use Chubbyphp\Laminas\Config\Factory\AbstractFactory;
use Chubbyphp\Negotiation\AcceptNegotiatorInterface;
use Chubbyphp\Negotiation\ContentTypeNegotiatorInterface;
use Chubbyphp\Negotiation\ServiceFactory\AcceptNegotiatorFactory;
use Chubbyphp\Negotiation\ServiceFactory\ContentTypeNegotiatorFactory;
use Psr\Container\ContainerInterface;

final class AcceptAndContentTypeMiddlewareFactory extends AbstractFactory
{
    public function __invoke(ContainerInterface $container): AcceptAndContentTypeMiddleware
    {
        /** @var AcceptNegotiatorInterface $acceptNegotiator */
        $acceptNegotiator = $this->resolveDependency(
            $container,
            AcceptNegotiatorInterface::class,
            AcceptNegotiatorFactory::class
        );

        /** @var ContentTypeNegotiatorInterface $contentTypeNegotiator */
        $contentTypeNegotiator = $this->resolveDependency(
            $container,
            ContentTypeNegotiatorInterface::class,
            ContentTypeNegotiatorFactory::class
        );

        /** @var ResponseManagerInterface $responseManager */
        $responseManager = $this->resolveDependency(
            $container,
            ResponseManagerInterface::class,
            ResponseManagerFactory::class
        );

        return new AcceptAndContentTypeMiddleware($acceptNegotiator, $contentTypeNegotiator, $responseManager);
    }
}

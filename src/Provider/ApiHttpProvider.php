<?php

declare(strict_types=1);

namespace Chubbyphp\ApiHttp\Provider;

use Chubbyphp\ApiHttp\ServiceProvider\ApiHttpServiceProvider;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

final class ApiHttpProvider implements ServiceProviderInterface
{
    /**
     * @var ApiHttpServiceProvider
     */
    private $serviceProvider;

    public function __construct()
    {
        $this->serviceProvider = new ApiHttpServiceProvider();
    }

    public function register(Container $container): void
    {
        $this->serviceProvider->register($container);
    }
}

# chubbyphp-api-http

[![Build Status](https://api.travis-ci.org/chubbyphp/chubbyphp-api-http.png?branch=master)](https://travis-ci.org/chubbyphp/chubbyphp-api-http)
[![Total Downloads](https://poser.pugx.org/chubbyphp/chubbyphp-api-http/downloads.png)](https://packagist.org/packages/chubbyphp/chubbyphp-api-http)
[![Latest Stable Version](https://poser.pugx.org/chubbyphp/chubbyphp-api-http/v/stable.png)](https://packagist.org/packages/chubbyphp/chubbyphp-api-http)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/chubbyphp/chubbyphp-api-http/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/chubbyphp/chubbyphp-api-http/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/chubbyphp/chubbyphp-api-http/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/chubbyphp/chubbyphp-api-http/?branch=master)

## Description

A simple http handler implementation for API.

## Requirements

 * php: ~7.0
 * chubbyphp/chubbyphp-deserialization: ~1.1
 * chubbyphp/chubbyphp-negotiation: ~1.0
 * chubbyphp/chubbyphp-serialization: ~1.0
 * psr/http-message: ~1.0

## Installation

Through [Composer](http://getcomposer.org) as [chubbyphp/chubbyphp-api-http][1].

```sh
composer require chubbyphp/chubbyphp-api-http "~1.0@beta"
```

## Usage

### Manager

#### RequestManager

```php
<?php

use Chubbyphp\ApiHttp\Manager\RequestManager;
use Chubbyphp\Deserialization\DeserializerInterface;
use Chubbyphp\Deserialization\TransformerInterface;
use Chubbyphp\Negotiation\AcceptLanguageNegotiator;
use Chubbyphp\Negotiation\AcceptNegotiator;
use Chubbyphp\Negotiation\ContentTypeNegotiator;
use MyProject\Model\Model;
use Psr\Http\Message\ServerRequestInterface as Request;

$acceptNegotiator = ...; // AcceptNegotiator
$acceptLanguageNegotiator = ...; // AcceptLanguageNegotiator
$contentTypeNegotiator = ...; // ContentTypeNegotiator
$deserializer = ...; // DeserializerInterface
$transformer = ...; // TransformerInterface

$requestManager = new RequestManager($acceptNegotiator, $acceptLanguageNegotiator, $contentTypeNegotiator, $deserializer, $transformer);

$request = ...; // Request
$object = new Model;

$requestManager->getAccept($request); // application/json
$requestManager->getAcceptLanguage($request); // en
$requestManager->getContentType($request); // application/json
$requestManager->getDataFromRequestBody($request, $object); // deserialize data from body to $object
$requestManager->getDataFromRequestQuery($request, $object); // deserialize query from body to $object
```

#### ResponseManager

```php
<?php

use Chubbyphp\ApiHttp\Factory\ResponseFactoryInterface;
use Chubbyphp\ApiHttp\Manager\RequestManager;
use Chubbyphp\ApiHttp\Manager\ResponseManager;
use Chubbyphp\Serialization\SerializerInterface;
use Chubbyphp\Serialization\TransformerInterface;
use MyProject\Model\Model;
use Psr\Http\Message\ServerRequestInterface as Request;

$requestManager = ...; // RequestManager
$responseFactory = ...; // ResponseFactoryInterface
$serializer = ...; // SerializerInterface
$transformer = ...; // TransformerInterface

$responseManager = new ResponseManager($requestManager, $responseFactory, $serializer, $transformer);

$request = ...; // Request
$object = new Model;

$responseManager->createResponse($request, 200, $object); // Response
```

## Copyright

Dominik Zogg 2017

[1]: https://packagist.org/packages/chubbyphp/chubbyphp-api-http

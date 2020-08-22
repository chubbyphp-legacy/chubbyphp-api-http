# chubbyphp-api-http

[![Build Status](https://api.travis-ci.org/chubbyphp/chubbyphp-api-http.png?branch=master)](https://travis-ci.org/chubbyphp/chubbyphp-api-http)
[![Coverage Status](https://coveralls.io/repos/github/chubbyphp/chubbyphp-api-http/badge.svg?branch=master)](https://coveralls.io/github/chubbyphp/chubbyphp-api-http?branch=master)
[![Latest Stable Version](https://poser.pugx.org/chubbyphp/chubbyphp-api-http/v/stable.png)](https://packagist.org/packages/chubbyphp/chubbyphp-api-http)
[![Total Downloads](https://poser.pugx.org/chubbyphp/chubbyphp-api-http/downloads.png)](https://packagist.org/packages/chubbyphp/chubbyphp-api-http)
[![Monthly Downloads](https://poser.pugx.org/chubbyphp/chubbyphp-api-http/d/monthly)](https://packagist.org/packages/chubbyphp/chubbyphp-api-http)
[![Daily Downloads](https://poser.pugx.org/chubbyphp/chubbyphp-api-http/d/daily)](https://packagist.org/packages/chubbyphp/chubbyphp-api-http)

## Description

A simple http handler implementation for API.

## Requirements

 * php: ^7.2
 * chubbyphp/chubbyphp-deserialization: ^3.0
 * chubbyphp/chubbyphp-negotiation: ^1.6
 * chubbyphp/chubbyphp-serialization: ^3.0
 * psr/http-factory: ^1.0.1
 * psr/http-message: ^1.0.1
 * psr/http-server-middleware: ^1.0.1
 * psr/log: ^1.1.3

## Installation

Through [Composer](http://getcomposer.org) as [chubbyphp/chubbyphp-api-http][1].

```sh
composer require chubbyphp/chubbyphp-api-http "^4.0"
```

## Usage

 * [ApiProblem (example)][2]
 * [AcceptAndContentTypeMiddlewareFactory][3]
 * [ApiExceptionMiddlewareFactory][4]
 * [RequestManagerFactory][5]
 * [ResponseManagerFactory][6]
 * [RequestManager][7]
 * [ResponseManager][8]
 * [AcceptAndContentTypeMiddleware][9]
 * [ApiExceptionMiddleware][10]
 * [ApiHttpServiceFactory][11]
 * [ApiHttpServiceProvider][12]
 * [ApiProblemMapping (example)][13]

## Copyright

Dominik Zogg 2020

[1]: https://packagist.org/packages/chubbyphp/chubbyphp-api-http
[2]: doc/ApiProblem/ApiProblem.md
[3]: doc/Container/AcceptAndContentTypeMiddlewareFactory.md
[4]: doc/Container/ApiExceptionMiddlewareFactory.md
[5]: doc/Container/RequestManagerFactory.md
[6]: doc/Container/ResponseManagerFactory.md
[7]: doc/Manager/RequestManager.md
[8]: doc/Manager/ResponseManager.md
[9]: doc/Middleware/AcceptAndContentTypeMiddleware.md
[10]: doc/Middleware/ApiExceptionMiddleware.md
[11]: doc/ServiceFactory/ApiHttpServiceFactory.md
[12]: doc/ServiceProvider/ApiHttpServiceProvider.md
[13]: doc/Serialization/ApiProblemMapping.md

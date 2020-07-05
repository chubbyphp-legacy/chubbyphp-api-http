# chubbyphp-api-http

[![Build Status](https://api.travis-ci.org/chubbyphp/chubbyphp-api-http.png?branch=master)](https://travis-ci.org/chubbyphp/chubbyphp-api-http)
[![Coverage Status](https://coveralls.io/repos/github/chubbyphp/chubbyphp-api-http/badge.svg?branch=master)](https://coveralls.io/github/chubbyphp/chubbyphp-api-http?branch=master)
[![Total Downloads](https://poser.pugx.org/chubbyphp/chubbyphp-api-http/downloads.png)](https://packagist.org/packages/chubbyphp/chubbyphp-api-http)
[![Monthly Downloads](https://poser.pugx.org/chubbyphp/chubbyphp-api-http/d/monthly)](https://packagist.org/packages/chubbyphp/chubbyphp-api-http)
[![Latest Stable Version](https://poser.pugx.org/chubbyphp/chubbyphp-api-http/v/stable.png)](https://packagist.org/packages/chubbyphp/chubbyphp-api-http)
[![Latest Unstable Version](https://poser.pugx.org/chubbyphp/chubbyphp-api-http/v/unstable)](https://packagist.org/packages/chubbyphp/chubbyphp-api-http)

## Description

A simple http handler implementation for API.

## Requirements

 * php: ^7.2
 * chubbyphp/chubbyphp-deserialization: ^2.17.1
 * chubbyphp/chubbyphp-negotiation: ^1.5.3
 * chubbyphp/chubbyphp-serialization: ^2.13.2
 * psr/http-factory: ^1.0.1
 * psr/http-message: ^1.0.1
 * psr/http-server-middleware: ^1.0.1
 * psr/log: ^1.1.3

## Installation

Through [Composer](http://getcomposer.org) as [chubbyphp/chubbyphp-api-http][1].

```sh
composer require chubbyphp/chubbyphp-api-http "^3.4"
```

## Usage

 * [ApiProblem (example)][2]
 * [RequestManager][3]
 * [ResponseManager][4]
 * [AcceptAndContentTypeMiddleware][5]
 * [ApiExceptionMiddleware][6]
 * [ApiHttpServiceFactory][7]
 * [ApiHttpServiceProvider][8]
 * [ApiProblemMapping (example)][9]

## Copyright

Dominik Zogg 2020

[1]: https://packagist.org/packages/chubbyphp/chubbyphp-api-http
[2]: doc/ApiProblem/ApiProblem.md
[3]: doc/Manager/RequestManager.md
[4]: doc/Manager/ResponseManager.md
[5]: doc/Middleware/AcceptAndContentTypeMiddleware.md
[6]: doc/ServiceFactory/ApiExceptionMiddleware.md
[7]: doc/ServiceFactory/ApiHttpServiceFactory.md
[8]: doc/ServiceProvider/ApiHttpServiceProvider.md
[9]: doc/Serialization/ApiProblemMapping.md

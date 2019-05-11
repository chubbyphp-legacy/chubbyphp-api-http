# chubbyphp-api-http

[![Build Status](https://api.travis-ci.org/chubbyphp/chubbyphp-api-http.png?branch=master)](https://travis-ci.org/chubbyphp/chubbyphp-api-http)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/chubbyphp/chubbyphp-api-http/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/chubbyphp/chubbyphp-api-http/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/chubbyphp/chubbyphp-api-http/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/chubbyphp/chubbyphp-api-http/?branch=master)
[![Total Downloads](https://poser.pugx.org/chubbyphp/chubbyphp-api-http/downloads.png)](https://packagist.org/packages/chubbyphp/chubbyphp-api-http)
[![Monthly Downloads](https://poser.pugx.org/chubbyphp/chubbyphp-api-http/d/monthly)](https://packagist.org/packages/chubbyphp/chubbyphp-api-http)
[![Latest Stable Version](https://poser.pugx.org/chubbyphp/chubbyphp-api-http/v/stable.png)](https://packagist.org/packages/chubbyphp/chubbyphp-api-http)
[![Latest Unstable Version](https://poser.pugx.org/chubbyphp/chubbyphp-api-http/v/unstable)](https://packagist.org/packages/chubbyphp/chubbyphp-api-http)

## Description

A simple http handler implementation for API.

## Requirements

 * php: ^7.1
 * chubbyphp/chubbyphp-deserialization: ^2.0
 * chubbyphp/chubbyphp-negotiation: ^1.1
 * chubbyphp/chubbyphp-serialization: ^2.0
 * psr/http-factory: ^1.0.1
 * psr/http-message: ^1.0.1
 * psr/http-server-middleware: ^1.0.1

## Installation

Through [Composer](http://getcomposer.org) as [chubbyphp/chubbyphp-api-http][1].

```sh
composer require chubbyphp/chubbyphp-api-http "^3.1"
```

## Usage

 * [ApiProblem (example)][2]
 * [RequestManager][3]
 * [ResponseManager][4]
 * [AcceptAndContentTypeMiddleware][5]
 * [ApiHttpProvider][6]
 * [ApiProblemMapping (example)][7]

## Copyright

Dominik Zogg 2019

[1]: https://packagist.org/packages/chubbyphp/chubbyphp-api-http
[2]: doc/ApiProblem/ApiProblem.md
[3]: doc/Manager/RequestManager.md
[4]: doc/Manager/ResponseManager.md
[5]: doc/Middleware/AcceptAndContentTypeMiddleware.md
[6]: doc/Provider/ApiHttpProvider.md
[7]: doc/Serialization/ApiProblemMapping.md

# chubbyphp-api-http

[![Build Status](https://api.travis-ci.org/chubbyphp/chubbyphp-api-http.png?branch=master)](https://travis-ci.org/chubbyphp/chubbyphp-api-http)
[![Coverage Status](https://coveralls.io/repos/github/chubbyphp/chubbyphp-api-http/badge.svg?branch=master)](https://coveralls.io/github/chubbyphp/chubbyphp-api-http?branch=master)
[![Infection MSI](https://badge.stryker-mutator.io/github.com/chubbyphp/chubbyphp-api-http/master)](https://travis-ci.org/chubbyphp/chubbyphp-api-http)
[![Latest Stable Version](https://poser.pugx.org/chubbyphp/chubbyphp-api-http/v/stable.png)](https://packagist.org/packages/chubbyphp/chubbyphp-api-http)
[![Total Downloads](https://poser.pugx.org/chubbyphp/chubbyphp-api-http/downloads.png)](https://packagist.org/packages/chubbyphp/chubbyphp-api-http)
[![Monthly Downloads](https://poser.pugx.org/chubbyphp/chubbyphp-api-http/d/monthly)](https://packagist.org/packages/chubbyphp/chubbyphp-api-http)

[![bugs](https://sonarcloud.io/api/project_badges/measure?project=chubbyphp_chubbyphp-api-http&metric=bugs)](https://sonarcloud.io/dashboard?id=chubbyphp_chubbyphp-api-http)
[![code_smells](https://sonarcloud.io/api/project_badges/measure?project=chubbyphp_chubbyphp-api-http&metric=code_smells)](https://sonarcloud.io/dashboard?id=chubbyphp_chubbyphp-api-http)
[![coverage](https://sonarcloud.io/api/project_badges/measure?project=chubbyphp_chubbyphp-api-http&metric=coverage)](https://sonarcloud.io/dashboard?id=chubbyphp_chubbyphp-api-http)
[![duplicated_lines_density](https://sonarcloud.io/api/project_badges/measure?project=chubbyphp_chubbyphp-api-http&metric=duplicated_lines_density)](https://sonarcloud.io/dashboard?id=chubbyphp_chubbyphp-api-http)
[![ncloc](https://sonarcloud.io/api/project_badges/measure?project=chubbyphp_chubbyphp-api-http&metric=ncloc)](https://sonarcloud.io/dashboard?id=chubbyphp_chubbyphp-api-http)
[![sqale_rating](https://sonarcloud.io/api/project_badges/measure?project=chubbyphp_chubbyphp-api-http&metric=sqale_rating)](https://sonarcloud.io/dashboard?id=chubbyphp_chubbyphp-api-http)
[![alert_status](https://sonarcloud.io/api/project_badges/measure?project=chubbyphp_chubbyphp-api-http&metric=alert_status)](https://sonarcloud.io/dashboard?id=chubbyphp_chubbyphp-api-http)
[![reliability_rating](https://sonarcloud.io/api/project_badges/measure?project=chubbyphp_chubbyphp-api-http&metric=reliability_rating)](https://sonarcloud.io/dashboard?id=chubbyphp_chubbyphp-api-http)
[![security_rating](https://sonarcloud.io/api/project_badges/measure?project=chubbyphp_chubbyphp-api-http&metric=security_rating)](https://sonarcloud.io/dashboard?id=chubbyphp_chubbyphp-api-http)
[![sqale_index](https://sonarcloud.io/api/project_badges/measure?project=chubbyphp_chubbyphp-api-http&metric=sqale_index)](https://sonarcloud.io/dashboard?id=chubbyphp_chubbyphp-api-http)
[![vulnerabilities](https://sonarcloud.io/api/project_badges/measure?project=chubbyphp_chubbyphp-api-http&metric=vulnerabilities)](https://sonarcloud.io/dashboard?id=chubbyphp_chubbyphp-api-http)

## Description

A simple http handler implementation for API.

## Requirements

 * php: ^7.2|^8.0
 * chubbyphp/chubbyphp-deserialization: ^3.0
 * chubbyphp/chubbyphp-negotiation: ^1.7
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
[3]: doc/ServiceFactory/AcceptAndContentTypeMiddlewareFactory.md
[4]: doc/ServiceFactory/ApiExceptionMiddlewareFactory.md
[5]: doc/ServiceFactory/RequestManagerFactory.md
[6]: doc/ServiceFactory/ResponseManagerFactory.md
[7]: doc/Manager/RequestManager.md
[8]: doc/Manager/ResponseManager.md
[9]: doc/Middleware/AcceptAndContentTypeMiddleware.md
[10]: doc/Middleware/ApiExceptionMiddleware.md
[11]: doc/ServiceFactory/ApiHttpServiceFactory.md
[12]: doc/ServiceProvider/ApiHttpServiceProvider.md
[13]: doc/Serialization/ApiProblemMapping.md

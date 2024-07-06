# chubbyphp-api-http

[![CI](https://github.com/chubbyphp/chubbyphp-api-http/workflows/CI/badge.svg?branch=master)](https://github.com/chubbyphp/chubbyphp-api-http/actions?query=workflow%3ACI)
[![Coverage Status](https://coveralls.io/repos/github/chubbyphp/chubbyphp-api-http/badge.svg?branch=master)](https://coveralls.io/github/chubbyphp/chubbyphp-api-http?branch=master)
[![Mutation testing badge](https://img.shields.io/endpoint?style=flat&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2Fchubbyphp%2Fchubbyphp-api-http%2Fmaster)](https://dashboard.stryker-mutator.io/reports/github.com/chubbyphp/chubbyphp-api-http/master)
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

DEPRECATED: No personal interest anymore and based on stats nobody seems to use it. Feel free to create an issue if you disagree.

## Requirements

 * php: ^8.1
 * chubbyphp/chubbyphp-deserialization: ^4.0
 * chubbyphp/chubbyphp-http-exception: ^1.1
 * chubbyphp/chubbyphp-negotiation: ^2.0
 * chubbyphp/chubbyphp-serialization: ^4.0
 * psr/http-factory: ^1.0.2
 * psr/http-message: ^1.1|^2.0
 * psr/http-server-middleware: ^1.0.2
 * psr/log: ^2.0|^3.0

## Installation

Through [Composer](http://getcomposer.org) as [chubbyphp/chubbyphp-api-http][1].

```sh
composer require chubbyphp/chubbyphp-api-http "^6.0"
```

## Usage

 * [AcceptAndContentTypeMiddlewareFactory][2]
 * [ApiExceptionMiddlewareFactory][3]
 * [RequestManagerFactory][4]
 * [ResponseManagerFactory][5]
 * [RequestManager][6]
 * [ResponseManager][7]
 * [AcceptAndContentTypeMiddleware][8]
 * [ApiExceptionMiddleware][9]

## Copyright

2024 Dominik Zogg

[1]: https://packagist.org/packages/chubbyphp/chubbyphp-api-http

[2]: doc/ServiceFactory/AcceptAndContentTypeMiddlewareFactory.md
[3]: doc/ServiceFactory/ApiExceptionMiddlewareFactory.md
[4]: doc/ServiceFactory/RequestManagerFactory.md
[5]: doc/ServiceFactory/ResponseManagerFactory.md
[6]: doc/Manager/RequestManager.md
[7]: doc/Manager/ResponseManager.md
[8]: doc/Middleware/AcceptAndContentTypeMiddleware.md
[9]: doc/Middleware/ApiExceptionMiddleware.md

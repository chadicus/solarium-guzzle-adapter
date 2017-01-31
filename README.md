# This package is abandoned. The Guzzle Adapter is now availble with Solarium 3.8


# Solarium\Core\Client\Adapter\GuzzleAdapter

[![Build Status](https://travis-ci.org/chadicus/solarium-guzzle-adapter.svg?branch=master)](https://travis-ci.org/chadicus/solarium-guzzle-adapter)
[![Code Quality](https://scrutinizer-ci.com/g/chadicus/solarium-guzzle-adapter/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/chadicus/solarium-guzzle-adapter/?branch=master)
[![Code Coverage](https://coveralls.io/repos/github/chadicus/solarium-guzzle-adapter/badge.svg?branch=master)](https://coveralls.io/github/chadicus/solarium-guzzle-adapter?branch=master)

[![Latest Stable Version](https://poser.pugx.org/chadicus/solarium-guzzle-adapter/v/stable)](https://packagist.org/packages/chadicus/solarium-guzzle-adapter)
[![Latest Unstable Version](https://poser.pugx.org/chadicus/solarium-guzzle-adapter/v/unstable)](https://packagist.org/packages/chadicus/solarium-guzzle-adapter)
[![License](https://poser.pugx.org/chadicus/solarium-guzzle-adapter/license)](https://packagist.org/packages/chadicus/solarium-guzzle-adapter)

[![Total Downloads](https://poser.pugx.org/chadicus/solarium-guzzle-adapter/downloads)](https://packagist.org/packages/chadicus/solarium-guzzle-adapter)
[![Daily Downloads](https://poser.pugx.org/chadicus/solarium-guzzle-adapter/d/daily)](https://packagist.org/packages/chadicus/solarium-guzzle-adapter)
[![Monthly Downloads](https://poser.pugx.org/chadicus/solarium-guzzle-adapter/d/monthly)](https://packagist.org/packages/chadicus/solarium-guzzle-adapter)

A [Solarium Adapter](http://solarium.readthedocs.io/en/stable/client-and-adapters/) implementation use [Guzzle](http://docs.guzzlephp.org/en/latest/). A [Pull Request](https://github.com/solariumphp/solarium/pull/466) exists to put this into the Solarium project. But as of right now, the main library supports PHP < 5.5. This library was created as to use the adapter immediately in various projects

## Requirements

GuzzleAdapter requires PHP 5.6 (or later).

##Composer
To add the library as a local, per-project dependency use [Composer](http://getcomposer.org)! Simply add a dependency on
`chadicus/solarium-guzzle-adapter` to your project's `composer.json` file such as:

```sh
composer require chadicus/solarium-guzzle-adapter
```

##Contact
Developers may be contacted at:

 * [Pull Requests](https://github.com/chadicus/solarium-guzzle-adapter/pulls)
 * [Issues](https://github.com/chadicus/solarium-guzzle-adapter/issues)

##Project Build
With a checkout of the code get [Composer](http://getcomposer.org) in your PATH and run:

```sh
composer install
./vendor/bin/phpunit
./vendor/bin/phpcs --standard=./vendor/chadicus/coding-standard/Chadicus src
```

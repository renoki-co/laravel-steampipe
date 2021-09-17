Package Name Here
===================================

![CI](https://github.com/renoki-co/laravel-steampipe/workflows/CI/badge.svg?branch=master)
[![codecov](https://codecov.io/gh/renoki-co/laravel-steampipe/branch/master/graph/badge.svg)](https://codecov.io/gh/renoki-co/laravel-steampipe/branch/master)
[![StyleCI](https://github.styleci.io/repos/:styleci_code/shield?branch=master)](https://github.styleci.io/repos/:styleci_code)
[![Latest Stable Version](https://poser.pugx.org/renoki-co/laravel-steampipe/v/stable)](https://packagist.org/packages/renoki-co/laravel-steampipe)
[![Total Downloads](https://poser.pugx.org/renoki-co/laravel-steampipe/downloads)](https://packagist.org/packages/renoki-co/laravel-steampipe)
[![Monthly Downloads](https://poser.pugx.org/renoki-co/laravel-steampipe/d/monthly)](https://packagist.org/packages/renoki-co/laravel-steampipe)
[![License](https://poser.pugx.org/renoki-co/laravel-steampipe/license)](https://packagist.org/packages/renoki-co/laravel-steampipe)

Use Laravel's built-in ORM classes to query cloud resources with [Steampipe](https://hub.steampipe.io), an open source CLI to instantly query cloud APIs using SQL.

## 🤝 Supporting

If you are using one or more Renoki Co. open-source packages in your production apps, in presentation demos, hobby projects, school projects or so, spread some kind words about our work or sponsor our work via Patreon. 📦

You will sometimes get exclusive content on tips about Laravel, AWS or Kubernetes on Patreon and some early-access to projects or packages.

[<img src="https://c5.patreon.com/external/logo/become_a_patron_button.png" height="41" width="175" />](https://www.patreon.com/bePatron?u=10965171)

## 🚀 Installation

You can install the package via composer:

```bash
composer require renoki-co/laravel-steampipe
```

In your `config/database.php`, add a new driver:

```php
'connections' => [

    'steampipe' => [
        'driver' => 'steampipe',
        'binary' => env('STEAMPIPE_BINARY', 'steampipe'),
    ],

],
```

You can define the Steampipe binary path with `STEAMPIPE_BINARY`.

## 🙌 Usage

Steampipe is multi-vendor, multi-plugin. This means that you can interact with cloud APIs just like yo would do with Postgres. You would want to create a model for the "tables" you would want to access the cloud APIs through.

For example, let's make a `AwsRegion` model for the [`aws_region` table](https://hub.steampipe.io/plugins/turbot/aws/tables/aws_region). Make sure you have [installed the AWS plugin for Steampipe](https://steampipe.io/docs).

```bash
php artisan steampipe:make:model aws_region
```

**Please observe that the models are created from the table in singular, `aws_region`. Usually, in Laravel you would have created the model class name directly. To break even and make the generation command easier, you should pass the table name instead of a class name.**

The command will create for you an `app/Steampipe/Aws/AwsRegion.php` file where you can access the model:

```php
use App\Steampipe\Aws\AwsRegion;

foreach (AwsRegion::all() as $region) {
    //
}
```

## Generation

You may generate as many models as you need. The convention is that when creating a table, it will always follow this pattern:

```
App\Steampipe\{Provider}\{TableNameStudlyCase};
```

This way, the models will know how to access the tables.

## 🐛 Testing

``` bash
vendor/bin/phpunit
```

## 🤝 Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## 🔒  Security

If you discover any security related issues, please email alex@renoki.org instead of using the issue tracker.

## 🎉 Credits

- [Alex Renoki](https://github.com/rennokki)
- [All Contributors](../../contributors)

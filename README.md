Laravel Steampipe
=================

![CI](https://github.com/renoki-co/laravel-steampipe/workflows/CI/badge.svg?branch=master)
[![codecov](https://codecov.io/gh/renoki-co/laravel-steampipe/branch/master/graph/badge.svg)](https://codecov.io/gh/renoki-co/laravel-steampipe/branch/master)
[![StyleCI](https://github.styleci.io/repos/407113139/shield?branch=master)](https://github.styleci.io/repos/407113139)
[![Latest Stable Version](https://poser.pugx.org/renoki-co/laravel-steampipe/v/stable)](https://packagist.org/packages/renoki-co/laravel-steampipe)
[![Total Downloads](https://poser.pugx.org/renoki-co/laravel-steampipe/downloads)](https://packagist.org/packages/renoki-co/laravel-steampipe)
[![Monthly Downloads](https://poser.pugx.org/renoki-co/laravel-steampipe/d/monthly)](https://packagist.org/packages/renoki-co/laravel-steampipe)
[![License](https://poser.pugx.org/renoki-co/laravel-steampipe/license)](https://packagist.org/packages/renoki-co/laravel-steampipe)

Use Laravel's built-in ORM classes to query cloud resources with [Steampipe](https://hub.steampipe.io), an open source CLI to instantly query cloud APIs using SQL.

## 🤝 Supporting

**If you are using one or more Renoki Co. open-source packages in your production apps, in presentation demos, hobby projects, school projects or so, sponsor our work with [Github Sponsors](https://github.com/sponsors/rennokki). 📦**

[<img src="https://github-content.s3.fr-par.scw.cloud/static/33.jpg" height="210" width="418" />](https://github-content.renoki.org/github-repo/33)

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

Steampipe is multi-vendor, multi-plugin. This means that you can interact with any cloud APIs just like yo would do with Postgres.

For it to work locally and avoid code pollution, you would want to create a model for the "tables" you would want to access the cloud APIs through.

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

All SQL-like methods from Laravel ORM are available to be used as explained [in the Steampipe documentation](https://steampipe.io/docs/using-steampipe/writing-queries).

Models also work with the built-in model features, like hidden fields or appends.

## Generation

You may generate as many models as you need. The convention is that when creating a table, it will always follow this pattern:

```
App\Steampipe\{Provider}\{TableNameStudlyCase};
```

This way, the models will know how to access the tables. For example, for a [DigitalOcean droplet](https://hub.steampipe.io/plugins/turbot/digitalocean/tables/digitalocean_droplet) it would look like this:

```bash
php artisan steampipe:make:model digitalocean_droplet
```

```php
use App\Steampipe\Digitalocean\DigitaloceanDroplet;

DigitaloceanDroplet::find(227211874);
```

## 🐛 Testing

You will need to set up an AWS account and add `AWS_ACCESS_KEY_ID` and `AWS_SECRET_ACCESS_KEY` to your environment variables.

The user with the access tokens should have the following IAM policy:

```json
{
    "Version": "2012-10-17",
    "Statement": [
        {
            "Effect": "Allow",
            "Action": "ec2:DescribeRegions",
            "Resource": "*"
        }
    ]
}
```

To run tests:

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

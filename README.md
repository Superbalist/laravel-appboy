# laravel-appboy

A Laravel library for sending push notifications via the [Appboy](https://www.appboy.com/documentation/REST_API) API

[![Author](http://img.shields.io/badge/author-@superbalist-blue.svg?style=flat-square)](https://twitter.com/superbalist)
[![Build Status](https://img.shields.io/travis/Superbalist/laravel-appboy/master.svg?style=flat-square)](https://travis-ci.org/Superbalist/laravel-appboy)
[![StyleCI](https://styleci.io/repos/92826972/shield?branch=master)](https://styleci.io/repos/92826972)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Packagist Version](https://img.shields.io/packagist/v/superbalist/laravel-appboy.svg?style=flat-square)](https://packagist.org/packages/superbalist/laravel-appboy)
[![Total Downloads](https://img.shields.io/packagist/dt/superbalist/laravel-appboy.svg?style=flat-square)](https://packagist.org/packages/superbalist/laravel-appboy)

This package is a wrapper bridging [php-appboy](https://github.com/Superbalist/php-appboy) into Laravel.

## Installation

```bash
composer require superbalist/laravel-appboy
```

Register the service provider in app.php
```php
'providers' => [
    // ...
    Superbalist\LaravelAppboy\AppboyServiceProvider::class,
]
```

Register the facade in app.php
```php
'aliases' => [
    // ...
    'Appboy' => Superbalist\LaravelAppboy\AppboyFacade::class,
]
```

The package has a default configuration which uses the following environment variables.
```
APPBOY_APP_GROUP_ID=null
APPBOY_API_URI=https://api.appboy.com
```

To customize the configuration file, publish the package configuration using Artisan.
```bash
php artisan vendor:publish --provider="Superbalist\LaravelAppboy\AppboyServiceProvider"
```

You can then edit the generated config at `app/config/appboy.php`.

## Usage

```php
use Appboy;
use Superbalist\Appboy\NotificationBuilder;
use Superbalist\Appboy\ScheduledNotificationBuilder;
use Superbalist\Appboy\Messages\AndroidMessageBuilder;
use Superbalist\Appboy\Messages\AppleMessageBuilder;

// send a push message
Appboy::sendMessage(
    (new NotificationBuilder())
        ->toUsers([1, 2])
        ->setCampaign('my_campaign')
        ->ignoreFrequencyCapping()
        ->setSubscriptionState('opted_in')
        ->withMessages([
            'apple_push' => (new AppleMessageBuilder())
                ->setAlert('Hello World!')
                ->setSound('custom_sound')
                ->withExtraAttributes(['is_test' => true])
                ->setCategory('shipping_notification')
                ->expiresAt(new \DateTime('2017-05-29 10:00:00', new \DateTimeZone('Africa/Johannesburg')))
                ->setUri('http://superbalist.com')
                ->setMessageVariation('group_a')
                ->setAsset('file://image.jpg', 'jpg')
                ->build(),
            'android_push' => (new AndroidMessageBuilder())
                ->setAlert('Hello World!')
                ->setTitle('Message Title')
                ->withExtraAttributes(['is_test' => true])
                ->setMessageVariation('group_a')
                ->setPriority(2)
                ->setCollapseKey('shipment_1234')
                ->setSound('custom_sound')
                ->setUri('http://superbalist.com')
                ->setSummaryText('This is a summary line')
                ->setTimeToLive(60)
                ->setNotificationId(18456)
                ->setPushIconImageUrl('http://link/to/asset.jpg')
                ->setAccentColour(16777215)
                ->build(),
        ])
        ->build()
);

// schedule a push message
Appboy::scheduleMessage(
    (new ScheduledNotificationBuilder())
        ->toUsers([1, 2])
        ->setCampaign('my_campaign')
        ->ignoreFrequencyCapping()
        ->setSubscriptionState('opted_in')
        ->withMessage(
            'apple_push',
            (new AppleMessageBuilder())
                ->setAlert('Hello World!')
                ->setSound('custom_sound')
                ->withExtraAttributes(['is_test' => true])
                ->setCategory('shipping_notification')
                ->expiresAt(new \DateTime('2017-05-29 10:00:00', new \DateTimeZone('Africa/Johannesburg')))
                ->setUri('http://superbalist.com')
                ->setMessageVariation('group_a')
                ->setAsset('file://image.jpg', 'jpg')
                ->build()
        )
        ->sendsAt(new \DateTime('2017-05-29 10:00:00', new \DateTimeZone('Africa/Johannesburg')))
        ->build()
```

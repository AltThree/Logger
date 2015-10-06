# Alt Three Logger

A logger wrapper for Laravel 5.


## Installation

[PHP](https://php.net) 5.5+ or [HHVM](http://hhvm.com) 3.6+, and [Composer](https://getcomposer.org) are required.

To get the latest version of Alt Three Logger, simply add the following line to the require block of your `composer.json` file:

```
"alt-three/logger": "~1.0"
```

You'll then need to run `composer install` or `composer update` to download it and have the autoloader updated.

Once Alt Three Logger is installed, you need to register the service provider. Open up `config/app.php` and add the following to the `providers` key.

* `'AltThree\Logger\LoggerServiceProvider'`

You can register the Logger facade in the `aliases` key of your `config/app.php` file if you like.

* `'Logger' => 'AltThree\Logger\Facades\Logger'`


## Configuration

Alt Three Logger requires configuration.

To get started, you'll need to publish all vendor assets:

```bash
$ php artisan vendor:publish
```

This will create a `config/logger.php` file in your app that you can modify to set your configuration. Also, make sure you check for changes to the original config file in this package between releases.


## Usage

Alt Three Logger provides a clean way to log to multiple destinations at once. Simply fill out the config with the psr loggers you want to use, and we'll do the rest. We even allow you to configure which level of messages to send to each logger.

Due to limitations with the way Laravel's setup, we cannot override the `log` instance that's bound to the ioc, so you'll find that still gives you an instance of Laravel's bog standard logger, and Laravel's Log facade will be using that instance too, however we do provide our own facade to use if you'd like.

The main advantage to this package is that we are still able to override the ioc bindings to the psr logger interface and to Laravel's logger contract, so if you're dependency injecting those, you'll get our fancy logger to work with. Brilliant!

An example of where this package can really help you out is in the exception handler. Without you having to make any changes there, you immediately have the ability to log to multiple places as Laravel's injecting our logger into your exception handler because of the binding we have to the psr logger interface.


## Supported Loggers

Alt Three provides two ready-made logger packages:

- [Bugsnag](https://github.com/AltThree/Bugsnag)
- [Sentry](https://github.com/AltThree/Sentry)


## Security

If you discover a security vulnerability within this package, please e-mail us at support@alt-three.com. All security vulnerabilities will be promptly addressed.


## License

Alt Three Logger is licensed under [The MIT License (MIT)](LICENSE).

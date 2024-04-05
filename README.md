![HTTPClient](.github/logo.png?raw=true)

# HTTPClient, PHP HTTP client

HTTPClient is a PHP HTTP client that makes it easy to send HTTP requests and
trivial to integrate with web services.

- Simple interface for building query strings, POST requests, using HTTP cookies, 
  uploading JSON data.
- Uses PSR-7 interfaces for requests, responses.
- Supports PSR-18 allowing interoperability between other PSR-18 HTTP Clients.
- Middleware system allows you to augment and compose client behavior.

PSR standards

<pre>
- PSR-12              coding standarts
- PSR-4               autoload
- PSR-7               http message interface
- PSR-15              http middleware
- PSR-16              cache interface
- PSR-17              http factories
- PSR-18              http client
</pre>

### 🐳 Needed tools

1. Clone this project: `git clone git@github.com:dolhopolovi/HTTPClient.git`
2. Move to the project folder: `cd HTTPClient`

### 🔥 Application execution

1. Install all the dependencies: `composer install`
2. Then you'll have available application

### ✅ Tests execution

1. Install the dependencies if you haven't done it previously: `make build`
2. Execute PHPUnit tests: `./vendor/bin/phpunit --testsuite Unit`

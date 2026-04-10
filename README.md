# phpnomad/mvc-app-template

A working scaffold for a standalone PHPNomad MVC application. No WordPress, no Symfony framework, no host platform. Just PHPNomad running directly behind an `index.php` entrypoint, with routing wired through `phpnomad/fastroute-rest-integration`, templates through `phpnomad/twig-integration`, events through `phpnomad/symfony-event-dispatcher-integration`, caching through `phpnomad/symfony-cache-integration`, configuration through `phpnomad/json-config-integration`, and error pages through `filp/whoops`. Clone it, install dependencies, point a web server at `index.php`, and you have a running PHPNomad app to start modifying.

## How to use this template

This repository is not published on Packagist, so clone it directly.

```bash
git clone https://github.com/phpnomad/mvc-app-template.git my-app
cd my-app
composer install
```

For local development, PHP's built-in server works.

```bash
php -S localhost:8000 index.php
```

Point any other web server (Apache, Nginx, Caddy) at `index.php` as the front controller.

## What's included

- `index.php` is the front controller. It registers Whoops, builds the `Application`, wires config files, and dispatches the request as a `RequestInitiated` event.
- `app/Application.php` runs a two-phase bootstrap. The first pass loads core PHPNomad integrations (config, core, events, REST). The second pass loads your app's own `Initializer`.
- `app/Initializer.php` is where you bind concrete strategies and providers to PHPNomad interfaces and register routes from config.
- `app/Strategies/` contains a `CachePolicy` that reads from config, a `PathResolver` that resolves asset paths relative to `index.php`, and a `CurrentContextResolverStrategy` that detects Rest vs Web requests.
- `app/Auth/PassthroughUser.php` is a no-auth placeholder `User` implementation. Replace it when you need real authentication.
- `controllers/HomeController.php` plus `controllers/Services/RenderableResponseService.php` show a sample controller and the service that bridges controllers and the Twig renderer.
- `configs/app.json` and `configs/cache.json` hold routes and cache settings as JSON, loaded through `phpnomad/json-config-integration`.
- `public/` contains a base Twig layout, header/footer/sidebar components, a landing page at `public/index.twig`, and a `dist/styles.css` stylesheet.

## Requirements

- Composer
- A PHP runtime that satisfies the dependency tree
- A web server (or PHP's built-in server) pointing at `index.php` as the front controller

## Documentation

Framework documentation lives at [phpnomad.com](https://phpnomad.com). The bootstrapping guide there explains the initializer and loader patterns this template is built on.

## License

MIT. See [LICENSE](LICENSE).

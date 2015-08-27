# Twig module for Stratify

Pre-configure Twig to work with Stratify and Puli so that you can use it straightaway.

## Installation

```
composer require stratify/twig-module
```

Then enable the `twig` module in your Stratify application.

## Usage

The `Twig_Environment` instance is now injectable wherever dependency injection is available.

Templates are loaded through Puli, so you need to use Puli paths to render a template (or extend another one).

Example of a Stratify controller:

```php
function (Twig_Environment $twig) {
    return $twig->render('/app/views/home.twig');
}
```

## Configuration

The following configuration options can be customized if needed:

- `twig.options`: [Twig options](http://twig.sensiolabs.org/doc/api.html#environment-options)

    ```php
    return [
        `twig.options` => [
            'strict_variables' => true,
        ],
    ]
    ```
- `twig.extensions`: array of [Twig extensions](http://twig.sensiolabs.org/doc/api.html#using-extensions)

    ```php
    return [
        `twig.extensions` => [
            get(Twig_Extension_Profiler::class),
            get(My\Custom\TwigExtension::class),
        ],
    ]
    ```

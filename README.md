# Twig module for Stratify

Pre-configuration for Twig to work with Stratify and Puli.

## Installation

```
composer require stratify/twig-module
```

Then enable the `twig` module in your Stratify application.

## Usage

The `Twig_Environment` instance is now injectable wherever dependency injection is available.

Templates are loaded through Puli, so you need to use [Puli paths](http://docs.puli.io/en/latest/glossary.html#glossary-puli-path) to render a template (or extend another one).

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
    `twig.options` => add([
        'strict_variables' => true,
    ]),
    ```
- `twig.globals`: [Global variables available in templates](http://twig.sensiolabs.org/doc/advanced.html#id1)

    ```php
    `twig.globals` => add([
        'appName' => 'My super project',
        'debug' => get('debug'), // container parameters can be injected too
    ]),
    ```
- `twig.extensions`: array of [Twig extensions](http://twig.sensiolabs.org/doc/api.html#using-extensions)

    ```php
    `twig.extensions` => add([
        get(Twig_Extension_Profiler::class),
        get(My\Custom\TwigExtension::class),
    ]),
    ```

Recommended options for **production**:

```php
'twig.options' => [
    'cache' => /* cache directory */,
],
```

Recommended options for **development**:

```php
'twig.options' => [
    'debug' => true,
    'cache' => false,
    'strict_variables' => true,
],
```

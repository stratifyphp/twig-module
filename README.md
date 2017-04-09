# Twig module for Stratify

Pre-configuration for Twig to work with Stratify.

## Installation

```
composer require stratify/twig-module
```

Then enable the `stratify/twig-module` module in your Stratify application.

## Usage

The `Twig_Environment` instance is now injectable wherever dependency injection is available.

Example of a Stratify controller:

```php
function (Twig_Environment $twig) {
    return $twig->render('home.twig');
}
```

## Configuration

The following configuration options can be customized if needed:

- `twig.paths`: Paths containing templates to register

    ```php
    `twig.paths` => add([
        __DIR__.'/../views',
    ]),
    ```
    
    Templates can then be rendered as `foo.twig`.
    
    Templates can also be namespaced, which can be useful for reusable modules:
    
    ```php
    `twig.paths` => add([
        'blog' => __DIR__.'/../views',
    ]),
    ```
    
    Templates can then be rendered as `@blog/foo.twig`.
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

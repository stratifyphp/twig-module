<?php

use Psr\Container\ContainerInterface;
use Stratify\TwigModule\Extension\StratifyExtension;
use function DI\add;
use function DI\get;
use function DI\object;

return [

    /**
     * Register paths containing Twig templates.
     *
     * You can optionally index paths by a namespace, that allows to use the `@namespace/template.twig` notation.
     *
     *     'twig.paths' => add([
     *         // not namespaced
     *         __DIR__.'/../blog/views',
     *         // namespaced
     *         'admin' => __DIR__.'/../admin/views',
     *     ]),
     *
     * Templates can then be included as `foo.twig` (not namespaced) or `@admin/bar.twig` (namespaced).
     *
     * @see https://twig.sensiolabs.org/doc/2.x/api.html#built-in-loaders
     */
    'twig.paths' => [],

    /**
     * Twig options
     *
     * @see http://twig.sensiolabs.org/doc/api.html#environment-options
     */
    'twig.options' => [],

    /**
     * Global variables available in Twig templates
     *
     * Remember PHP-DI helpers can be used in this array to inject parameters in Twig templates, for example:
     *
     *     'twig.globals' => add([
     *         'debug' => get('debug'),
     *     ]),
     *
     * @see http://twig.sensiolabs.org/doc/advanced.html#id1
     */
    'twig.globals' => [],

    /**
     * Register Twig extensions through this array.
     */
    'twig.extensions' => add([
        get(Twig_Extension_Debug::class),
        get(StratifyExtension::class),
    ]),

    Twig_Environment::class => object()
        ->constructor(get(Twig_LoaderInterface::class), get('twig.options'))
        ->method('setExtensions', get('twig.extensions')),

    Twig_LoaderInterface::class => function (ContainerInterface $c) : Twig_LoaderInterface {
        $loader = new Twig_Loader_Filesystem;
        $paths = $c->get('twig.paths');
        // Paths can be namespaced
        foreach ($paths as $namespace => $path) {
            if (is_string($namespace)) {
                $loader->addPath($path, $namespace);
            } else {
                $loader->addPath($path);
            }
        }
        return $loader;
    },

];

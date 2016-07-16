<?php

use Puli\Repository\Api\ResourceRepository;
use Puli\TwigExtension\PuliExtension;
use Puli\TwigExtension\PuliTemplateLoader;
use Puli\UrlGenerator\Api\UrlGenerator;
use Stratify\TwigModule\Extension\StratifyExtension;
use function DI\add;
use function DI\get;
use function DI\object;

return [

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
     *     'twig.globals' => [
     *         'debug' => get('debug'),
     *     ],
     *
     * @see http://twig.sensiolabs.org/doc/advanced.html#id1
     */
    'twig.globals' => [],

    /**
     * Register Twig extensions through this array.
     */
    'twig.extensions' => add([
        get(Twig_Extension_Debug::class),
        get(PuliExtension::class),
        get(StratifyExtension::class),
    ]),

    Twig_Environment::class => object()
        ->constructor(get(Twig_LoaderInterface::class), get('twig.options'))
        ->method('setExtensions', get('twig.extensions')),

    Twig_LoaderInterface::class => object(PuliTemplateLoader::class),

    PuliExtension::class => object()
        ->constructor(get(ResourceRepository::class), get(UrlGenerator::class)),

];

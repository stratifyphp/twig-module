<?php

namespace Stratify\TwigModule\Extension;

use Interop\Container\ContainerInterface;
use Stratify\Router\UrlGenerator;
use Twig_Extension;
use Twig_Extension_GlobalsInterface;
use Twig_SimpleFunction;

/**
 * Twig extension that registers Stratify-specific functions and helpers.
 *
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 */
class StratifyExtension extends Twig_Extension implements Twig_Extension_GlobalsInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getGlobals()
    {
        return $this->container->get('twig.globals');
    }

    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('path', [$this, 'generatePath']),
        ];
    }

    public function generatePath(string $name, array $parameters = []) : string
    {
        $urlGenerator = $this->container->get(UrlGenerator::class);
        return $urlGenerator->generate($name, $parameters);
    }

    public function getName()
    {
        return 'stratify';
    }
}

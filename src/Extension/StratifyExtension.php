<?php

namespace Stratify\TwigModule\Extension;

use Stratify\Router\UrlGenerator;
use Twig_Extension;
use Twig_SimpleFunction;

/**
 * Twig extension that registers Stratify-specific functions and helpers.
 *
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 */
class StratifyExtension extends Twig_Extension
{
    /**
     * @var UrlGenerator
     */
    private $urlGenerator;

    public function __construct(UrlGenerator $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('path', [$this, 'generatePath']),
        ];
    }

    public function generatePath(string $name, array $parameters = []) : string
    {
        return $this->urlGenerator->generate($name, $parameters);
    }

    public function getName()
    {
        return 'stratify';
    }
}

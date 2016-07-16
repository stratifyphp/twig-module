<?php
declare(strict_types = 1);

namespace Stratify\TwigModule\Test\Extension;

use DI\Container;
use DI\ContainerBuilder;
use function DI\get;
use function DI\object;
use Interop\Container\ContainerInterface;
use Puli\Repository\Api\ResourceRepository;
use Puli\Repository\NullRepository;
use Twig_Loader_Array;
use Twig_LoaderInterface;

class StratifyExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function should_define_no_global_variables_by_default()
    {
        $container = $this->createContainer();
        $twig = $container->get(\Twig_Environment::class);
        $this->assertEquals([], $twig->getGlobals());
    }

    /**
     * @test
     */
    public function should_allow_to_define_global_variables()
    {
        $container = $this->createContainer([
            'twig.globals' => [
                'foo' => 'bar',
                'qux' => get('baz'),
            ],
            'baz' => 'Hello!',
        ]);
        $twig = $container->get(\Twig_Environment::class);

        $expected = [
            'foo' => 'bar',
            'qux' => 'Hello!',
        ];
        $this->assertEquals($expected, $twig->getGlobals());
    }

    private function createContainer(array $definitions = [])
    {
        $builder = new ContainerBuilder;
        $builder->addDefinitions(__DIR__ . '/../../res/config/config.php');
        $builder->addDefinitions([
            // Mocks so that the tests run
            ContainerInterface::class => get(Container::class),
            Twig_LoaderInterface::class => object(Twig_Loader_Array::class)
                ->constructor([]),
            ResourceRepository::class => object(NullRepository::class),
        ]);
        $builder->addDefinitions($definitions);
        return $builder->build();
    }
}

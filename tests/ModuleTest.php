<?php
declare(strict_types = 1);

namespace Stratify\TwigModule\Test;

use function DI\add;
use DI\ContainerBuilder;
use function DI\get;
use PHPUnit\Framework\TestCase;

class ModuleTest extends TestCase
{
    /** @test */
    public function allows_to_register_template_paths()
    {
        $twig = $this->createTwig([
            'twig.paths' => add([
                __DIR__.'/Fixture',
            ]),
        ]);
        self::assertEquals('Hello!', trim($twig->render('test.twig')));
    }

    /** @test */
    public function allows_to_register_namespaced_template_paths()
    {
        $twig = $this->createTwig([
            'twig.paths' => add([
                'foo' => __DIR__.'/Fixture',
            ]),
        ]);
        self::assertEquals('Hello!', trim($twig->render('@foo/test.twig')));
    }

    /** @test */
    public function defines_no_global_variables_by_default()
    {
        $twig = $this->createTwig();
        self::assertEquals([], $twig->getGlobals());
    }

    /** @test */
    public function allows_to_define_global_variables()
    {
        $twig = $this->createTwig([
            'twig.globals' => [
                'foo' => 'bar',
                'qux' => get('baz'),
            ],
            'baz' => 'Hello!',
        ]);

        $expected = [
            'foo' => 'bar',
            'qux' => 'Hello!',
        ];
        self::assertEquals($expected, $twig->getGlobals());
    }

    private function createTwig(array $definitions = []) : \Twig_Environment
    {
        $builder = new ContainerBuilder;
        $builder->addDefinitions(__DIR__ . '/../res/config/config.php');
        $builder->addDefinitions($definitions);
        return $builder->build()->get(\Twig_Environment::class);
    }
}

<?php

declare(strict_types=1);

/*
 * This file is part of Biurad opensource projects.
 *
 * PHP version 7.2 and above required
 *
 * @author    Divine Niiquaye Ibok <divineibok@gmail.com>
 * @copyright 2019 Biurad Group (https://biurad.com/)
 * @license   https://opensource.org/licenses/BSD-3-Clause License
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Biurad\DependencyInjection;

use Nette;
use Nette\DI\ContainerBuilder;
use Nette\DI\Definitions;
use Nette\DI\PhpGenerator as NettePhpGenerator;
use Throwable;

/**
 * Container PHP code generator.
 *
 * @author Divine Niiquaye Ibok <divineibok@gmail.com>
 */
class PhpGenerator extends NettePhpGenerator
{
    /**
     * Generates PHP classes. First class is the container.
     *
     * @param string $className
     *
     * @return Nette\PhpGenerator\ClassType
     */
    public function generate(string $className): Nette\PhpGenerator\ClassType
    {
        $class = parent::generate($className);

        $class->getMethod(Container::getMethodName(ContainerBuilder::THIS_CONTAINER))
            ->addBody(' //container instance is binded to it self');

        return $class;
    }

    /**
     * @param Nette\PhpGenerator\ClassType $class
     *
     * @throws Throwable
     *
     * @return string
     */
    public function toString(Nette\PhpGenerator\ClassType $class): string
    {
        $class->setComment(<<<'COMMENT'
/**
 * Main DependencyInjection Container. This class has been auto-generated
 * by the Nette Dependency Injection Component.
 *
 * Automatically detects if "container" property are presented in class or uses
 * global container as fallback.
 *
 */
COMMENT);

        return parent::toString($class);
    }

    public function generateMethod(Definitions\Definition $def): Nette\PhpGenerator\Method
    {
        $method   = parent::generateMethod($def);
        $name     = $def->getName();
        $comment  = 'This service can be accessed by it\'s name in lower case,';
        $comment2 = "thus `%s`, using container get or make methods.\n\n@return %s";

        $method->setProtected();
        $method->setComment(\sprintf($comment . "\n" . $comment2, $name, $def->getType()));

        return $method;
    }
}

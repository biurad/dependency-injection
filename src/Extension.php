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

use Contributte\DI\Extension\CompilerExtension;
use Nette\DI\ContainerBuilder;
use Nette\DI\Config\Loader as NetteLoader;
use Nette\Loaders\RobotLoader;
use ReflectionClass;

/**
 * Configurator compiling extension.
 *
 * @author Divine Niiquaye Ibok <divineibok@gmail.com>
 */
abstract class Extension extends CompilerExtension
{
    /**
     * @return Builder
     */
    public function getContainerBuilder(): ContainerBuilder
    {
        return $this->compiler->getContainerBuilder();
    }

    /**
     * Get a key from config using dots on string
     *
     * @return mixed
     */
    public function getFromConfig(string $key)
    {
        return Builder::arrayGet($this->config, $key);
    }

    /**
     * @return NetteLoader
     */
    protected function createLoader(): NetteLoader
    {
        $loader = parent::createLoader();

        $loader->addAdapter('yaml', Adapters\YamlAdapter::class);
        $loader->addAdapter('yml', Adapters\YamlAdapter::class);
        $loader->addAdapter('xml', Adapters\XmlAdapter::class);

        return $loader;
    }

    /**
     * Returns the configuration array for the given extension.
     *
     * @param string $extension The extension class name
     * @param string $config    The config in dotted form
     *
     * @return mixed value from extension config or null if not found
     */
    protected function getExtensionConfig(string $extension, string $config)
    {
        $extensions = $this->compiler->getExtensions($extension);

        if (empty($extensions) || \count($extensions) !== 1) {
            return null;
        }

        return Builder::arrayGet(\current($extensions)->getConfig(), $config);
    }

    /**
     * @param string[] $scanDirs
     * @param string   $className
     *
     * @return string[]
     */
    protected function findClasses(array $scanDirs, string $className): array
    {
        $classes = [];

        if (!empty($scanDirs)) {
            $robot = new RobotLoader();

            $robot->addDirectory(...$scanDirs);
            $robot->acceptFiles = ['*.php'];
            $robot->rebuild();
            $classes = \array_keys($robot->getIndexedClasses());
        }

        $foundClasses = [];

        foreach (\array_unique($classes) as $class) {
            if (
                \class_exists($class)
                && ($rc = new ReflectionClass($class)) && $rc->isSubclassOf($className)
                && !$rc->isAbstract()
            ) {
                $foundClasses[] = $rc->getName();
            }
        }

        return $foundClasses;
    }
}

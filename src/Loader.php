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

/**
 * DI container loader.
 *
 * @author Divine Niiquaye Ibok <divineibok@gmail.com>
 */
class Loader extends Nette\DI\ContainerLoader
{
    /**
     * @param string   $class
     * @param callable $generator
     *
     * @return array of (code, file[])
     */
    protected function generate(string $class, callable $generator): array
    {
        $compiler = new Compiler(new Builder());
        $compiler->setClassName($class);

        $code = $generator(...[&$compiler]) ?: $compiler->compile();

        return [
            "<?php\n$code",
            \serialize($compiler->exportDependencies()),
        ];
    }
}

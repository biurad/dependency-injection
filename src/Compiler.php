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

use Nette\DI\Compiler as NetteCompiler;
use Nette\DI\PhpGenerator as NettePhpGenerator;

class Compiler extends NetteCompiler
{
    protected function createPhpGenerator(): NettePhpGenerator
    {
        return new PhpGenerator($this->getContainerBuilder());
    }
}

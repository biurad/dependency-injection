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

use Nette\DI\Resolver as NetteResolver;
use Nette\Utils\Reflection;
use ReflectionFunctionAbstract;

/**
 * Services resolver
 *
 * @internal
 */
class Resolver extends NetteResolver
{
    /**
     * Add missing arguments using autowiring.
     *
     * @param ReflectionFunctionAbstract $method
     * @param mixed[] $arguments
     * @param  (callable(string $type, bool $single): object|object[]|null) $getter
     *
     * @return mixed[]
     */
    public static function autowireArguments(
        ReflectionFunctionAbstract $method,
        array $arguments,
        callable $getter
    ): array {
        $optCount = 0;
        $num = -1;
        $res = [];

        foreach ($method->getParameters() as $num => $param) {
            $paramName = $param->name;
            if (!$param->isVariadic() && array_key_exists($paramName, $arguments)) {
                $res[$num] = $arguments[$paramName];
                unset($arguments[$paramName], $arguments[$num]);
            } elseif (array_key_exists($num, $arguments)) {
                $res[$num] = $arguments[$num];
                unset($arguments[$num]);
            } else {
                $res[$num] = self::autowireArgument($param, $getter);
            }

            $optCount = $param->isOptional() && $res[$num] === ($param->isDefaultValueAvailable() ? Reflection::getParameterDefaultValue($param) : null)
                ? $optCount + 1
                : 0;
        }

        // extra parameters
        while (array_key_exists(++$num, $arguments)) {
            $res[$num] = $arguments[$num];
            unset($arguments[$num]);
            $optCount = 0;
        }

        if ($optCount) {
            $res = array_slice($res, 0, -$optCount);
        }

        return $res;
    }
}

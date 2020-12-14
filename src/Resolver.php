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

use Nette\DI\MissingServiceException;
use Nette\DI\Resolver as NetteResolver;
use Nette\DI\ServiceCreationException;
use Nette\Utils\Reflection;
use ReflectionFunctionAbstract;
use ReflectionParameter;

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
     * @param (callable(string $type, bool $single): object|object[]|null) $getter
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

    /**
	 * Resolves missing argument using autowiring.
     * @param ReflectionParameter $parameter
	 * @param (callable(string $type, bool $single): object|object[]|null)  $getter
     *
	 * @throws ServiceCreationException
     *
	 * @return mixed
	 */
	private static function autowireArgument(ReflectionParameter $parameter, callable $getter)
	{
		$type = Reflection::getParameterType($parameter);
		$method = $parameter->getDeclaringFunction();
		$desc = Reflection::toString($parameter);

		if ($type && !Reflection::isBuiltinType($type)) {
			try {
				$res = $getter($type, true);
			} catch (MissingServiceException $e) {
				$res = null;
			} catch (ServiceCreationException $e) {
				throw new ServiceCreationException("{$e->getMessage()} (needed by $desc)", 0, $e);
			}
            
			if ($res !== null || $parameter->allowsNull()) {
				return $res;
			} elseif (class_exists($type) || interface_exists($type)) {
				throw new ServiceCreationException("Service of type $type needed by $desc not found. Did you add it to configuration file?");
			} else {
				throw new ServiceCreationException("Class $type needed by $desc not found. Check type hint and 'use' statements.");
			}

		} elseif (
			$method instanceof \ReflectionMethod
			&& $type === 'array'
			&& preg_match('#@param[ \t]+([\w\\\\]+)\[\][ \t]+\$' . $parameter->name . '#', (string) $method->getDocComment(), $m)
			&& ($itemType = Reflection::expandClassName($m[1], $method->getDeclaringClass()))
			&& (class_exists($itemType) || interface_exists($itemType))
		) {
			return $getter($itemType, false);

		} elseif (
			($type && $parameter->allowsNull())
			|| $parameter->isOptional()
			|| $parameter->isDefaultValueAvailable()
		) {
			// !optional + defaultAvailable = func($a = null, $b) since 5.4.7
			// optional + !defaultAvailable = i.e. Exception::__construct, mysqli::mysqli, ...
			return $parameter->isDefaultValueAvailable()
				? Reflection::getParameterDefaultValue($parameter)
				: null;

		} else {
			throw new ServiceCreationException("Parameter $desc has no class type hint or default value, so its value must be specified.");
		}
	}
}

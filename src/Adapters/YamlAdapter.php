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

namespace Biurad\DependencyInjection\Adapters;

use Nette\DI\Config\Adapters\NeonAdapter;
use Nette\Utils\FileSystem;
use Nette\Neon;

/**
 * Reading and generating Yaml files for DI.
 *
 * @author Divine Niiquaye Ibok <divineibok@gmail.com>
 */
final class YamlAdapter extends \Nette\Di\Config\Adapter
{
    /**
     * {@inheritdoc}
     */
    public function load(string $file): array
    {
        // So yaml syntax could work properly
        $contents = \str_replace(
            ['~', '\'false\'', '\'true\'', '"false"', '"true"'],
            ['null', 'false', 'true', 'false', 'true'],
            FileSystem::read($file)
        );

        return (new NeonAdapter())->process((array) Neon\Neon::decode($contents));
    }

    /**
     * Generates configuration in NEON format.
     */
    public function dump(array $data): string
    {
        return (new NeonAdapter())->dump($data);
    }
}

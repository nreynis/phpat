<?php

namespace PhpAT\Config;

use PhpAT\App\Configuration;
use Symfony\Component\Yaml\Yaml;

class ConfigurationFactory
{
    private const DEFAULT_OPTIONS = [
        'verbosity' => 0,
        'ignore-docblocks' => false,
        'ignore-php-extensions' => true
    ];

    public function create(string $configFilePath, array $commandOptions): Configuration
    {
        $config = Yaml::parse(file_get_contents($configFilePath));
        $config['options'] = array_merge($config['options'] ?? [], $commandOptions);

        return new Configuration(
            $config['src']['path'] ?? '',
            $config['src']['include'] ?? [],
            $config['src']['exclude'] ?? [],
            $config['composer'] ?? [],
            $config['tests']['path'] ?? '',
            $this->decideVerbosity($commandOptions, $config),
            (bool) $commandOptions['generate-baseline'],
            (bool) ($config['options']['ignore-docblocks'] ?? static::DEFAULT_OPTIONS['ignore-docblocks']),
            (bool) ($config['options']['ignore-php-extensions'] ?? static::DEFAULT_OPTIONS['ignore-php-extensions'])
        );
    }

    private function decideVerbosity(array $commandOptions, $config): int
    {
        if ($commandOptions['quiet'] === true) {
            return 0;
        }

        return ($config['options']['verbosity'] ?? static::DEFAULT_OPTIONS['verbosity']);
    }
}

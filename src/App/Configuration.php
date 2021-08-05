<?php

declare(strict_types=1);

namespace PhpAT\App;

class Configuration
{
    private $phpStormStubsPath;
    private $srcPath;
    private $srcIncluded;
    private $srcExcluded;
    private $composerConfiguration;
    private $testsPath;
    private $baselinePath;
    private $verbosity;
    private $generateBaseline;
    private $ignoreDocBlocks;
    private $ignorePhpExtensions;

    public function __construct(
        string $srcPath,
        array $srcIncluded,
        array $srcExcluded,
        array $composerConfiguration,
        string $testPath,
        int $verbosity,
        bool $generateBaseline,
        bool $ignoreDocBlocks,
        bool $ignorePhpExtensions
    ) {
        $root = is_file(__DIR__ . '/../../../../autoload.php')
            ? realpath(__DIR__ . '/../../../../..')
            : realpath(__DIR__ . '/../..');

        $this->srcPath = $this->normalizePath($root . '/' . $srcPath);
        $this->srcIncluded = $srcIncluded;
        $this->srcExcluded = $srcExcluded;
        $this->composerConfiguration = $composerConfiguration;
        $this->testsPath = $testPath;
        $this->baselinePath = $this->normalizePath($root . '/phpat.baseline');
        $this->verbosity = (int) $verbosity;
        $this->generateBaseline = $generateBaseline;
        $this->ignoreDocBlocks = (bool) $ignoreDocBlocks;
        $this->ignorePhpExtensions = (bool) $ignorePhpExtensions;
        $this->phpStormStubsPath = $root . '/vendor/jetbrains/phpstorm-stubs';
    }

    public function getSrcPath(): string
    {
        return $this->srcPath;
    }

    public function getSrcIncluded(): array
    {
        return $this->srcIncluded;
    }

    public function getSrcExcluded(): array
    {
        return $this->srcExcluded;
    }

    public function getComposerConfiguration(): array
    {
        return $this->composerConfiguration;
    }

    public function getTestsPath(): string
    {
        return $this->testsPath;
    }

    public function getBaselinePath(): string
    {
        return $this->baselinePath;
    }

    public function getVerbosity(): int
    {
        return $this->verbosity;
    }

    public function mustGenerateBaseline(): bool
    {
        return $this->generateBaseline;
    }

    public function getIgnoreDocBlocks(): bool
    {
        return $this->ignoreDocBlocks;
    }

    public function getIgnorePhpExtensions(): bool
    {
        return $this->ignorePhpExtensions;
    }

    public function getPhpStormStubsPath(): string
    {
        return $this->phpStormStubsPath;
    }

    private function normalizePath(string $path): string
    {
        return str_replace('\\', '/', realpath($path));
    }
}

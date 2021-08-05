<?php

namespace PhpAT\Baseline;

use PhpAT\App\Configuration;

class BaselineGenerator
{
    /** @var Configuration */
    private $configuration;

    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
    }

    public function generate(array $errors): void
    {
        $baselineFilePath = $this->configuration->getBaselinePath();
        //$file = fopen($baselineFilePath, 'a') ?: null;
        $previousErrors = $this->getErrorsFromBaselineFile($baselineFilePath);
        list($outdated, $newErrors) = $this->compareErrors($previousErrors, $errors);
    }

    private function getErrorsFromBaselineFile(string $file): array
    {
        if (!is_file($file)) {
            return [];
        }

        $baselineErrors = json_decode(@file_get_contents($file) ?: '[]', true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Invalid json format in baseline file');
        }

        return $baselineErrors;
    }

    private function compareErrors(array $previousErrors, array $errors): array
    {
        $outdated = [];
        $new = [];
        var_dump($previousErrors);
        var_dump($errors);
        return [$outdated, $new];
    }
}

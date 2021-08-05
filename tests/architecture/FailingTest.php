<?php

namespace Tests\PhpAT\architecture;

use PhpAT\Rule\Rule;
use PhpAT\Selector\Selector;
use PhpAT\Test\ArchitectureTest;

class FailingTest extends ArchitectureTest
{
    public function testExtractorsDependOnRuleBuilder(): Rule
    {
        return $this->newRule
            ->classesThat(Selector::implementInterface(\PhpAT\Test\TestExtractor::class))
            ->mustNotDependOn()
            ->classesThat(Selector::haveClassName(\PhpAT\Rule\RuleBuilder::class))
            ->build();
    }
}

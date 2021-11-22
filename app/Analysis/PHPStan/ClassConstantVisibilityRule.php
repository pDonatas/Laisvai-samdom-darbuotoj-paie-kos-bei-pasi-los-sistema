<?php

declare(strict_types=1);

namespace App\Analysis\PHPStan;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;

class ClassConstantVisibilityRule implements Rule
{
    public function getNodeType(): string
    {
        return Node\Stmt\ClassConst::class;
    }

    /**
     * @param Node\Stmt\ClassConst $node
     * @param Scope $scope
     *
     * @return array (string|\PHPStan\Rules\RuleError)[]
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if (($node->flags & Node\Stmt\Class_::VISIBILITY_MODIFIER_MASK) === 0) {
            return [
                sprintf(
                    'Constant %s must declare a visibility keyword',
                    $node->consts[0]->name->name
                )
            ];
        }

        return [];
    }
}

<?php

declare(strict_types=1);

namespace Rector\TypePerfect\Rules;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Return_;
use PhpParser\NodeFinder;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Type\Constant\ConstantBooleanType;

/**
 * @implements Rule<ClassMethod>
 */
final class NoReturnFalseInNonBoolClassMethodRule implements Rule
{
    /**
     * @api
     * @var string
     */
    public const ERROR_MESSAGE = 'Returning false in non return bool class method. Use null with type|null instead or add bool return type';

    private readonly NodeFinder $nodeFinder;

    public function __construct(
    ) {
        $this->nodeFinder = new NodeFinder();
    }

    /**
     * @return class-string<Node>
     */
    public function getNodeType(): string
    {
        return ClassMethod::class;
    }

    /**
     * @param ClassMethod $node
     * @retur string[]
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if ($node->stmts === null) {
            return [];
        }

        if ($node->returnType instanceof Node) {
            return [];
        }

        /** @var Return_[] $returns */
        $returns = $this->nodeFinder->findInstanceOf($node->stmts, Return_::class);

        foreach ($returns as $return) {
            if (! $return->expr instanceof Expr) {
                continue;
            }

            $exprType = $scope->getType($return->expr);
            if (! $exprType instanceof ConstantBooleanType) {
                continue;
            }

            if ($exprType->getValue()) {
                continue;
            }

            return [self::ERROR_MESSAGE];
        }

        return [];
    }
}

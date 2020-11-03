<?php

declare(strict_types=1);

namespace Rector\TypePerfect\Tests\Rules\NarrowPublicClassMethodParamTypeRule\Fixture;

use Rector\TypePerfect\Tests\Rules\NarrowPublicClassMethodParamTypeRule\Source\ExpectedThisType\CallByThis;

final class SkipThisPassedExactType
{
    public function run(CallByThis $obj)
    {
    }
}

<?php

declare(strict_types=1);

namespace Rector\TypePerfect\Tests\Rules\ForbiddenParamTypeRemovalRule\Fixture;

class ParentClass
{
    public function execute(string $string, int $int)
    {
    }
}

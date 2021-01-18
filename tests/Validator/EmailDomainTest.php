<?php

namespace App\Tests;

use App\Validator\EmailDomain;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;
use Symfony\Component\Validator\Exception\MissingOptionsException;

class EmailDomainTest extends TestCase
{
    public function testRequiredParameters()
    {
        $this->expectException(MissingOptionsException::class);
        new EmailDomain();
    }

    public function testBadShapedBlockedParameter()
    {
        $this->expectException(ConstraintDefinitionException::class);
        new EmailDomain(['blocked' => 'azeaze']);
    }
}

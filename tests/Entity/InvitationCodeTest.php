<?php

namespace App\Tests;

use App\Entity\InvitationCode;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserRepositoryTest extends KernelTestCase
{
    public function getEntity(): InvitationCode
    {
        $code = new InvitationCode();
        return $code
            ->setCode("12345")
            ->setExpireAt(new \DateTime())
            ->setDescription('Description du test');
    }

    public function assertHasErrors(InvitationCode $code, int $number = 0)
    {
        self::bootKernel();
        $errors = self::$container->get('validator')->validate($code);
        $messages = [];
        /** @var ConstraintViolation $error */
        foreach ($errors as $error) {
            $messages[] = $error->getPropertyPath() . ' => ' . $error->getMessage();
        }
        $this->assertCount($number, $errors, implode(', ', $messages));
    }

    public function testValidEntity()
    {

        $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testInvalidEntity()
    {
        $this->assertHasErrors($this->getEntity()->setCode('1a345'), 1);
        $this->assertHasErrors($this->getEntity()->setCode('1345'), 1);
    }

    public  function testInvalidCodeBlank()
    {
        $this->assertHasErrors($this->getEntity()->setCode(''), 1);
    }

    public  function testInvalidDescriptionBlank()
    {
        $this->assertHasErrors($this->getEntity()->setDescription(''), 1);
    }
}

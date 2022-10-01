<?php

namespace App\Tests;

use App\Entity\Consultant;
use PHPUnit\Framework\TestCase;

class ConsultantUnitTest extends TestCase
{
    public function testIsTrue()
    {
        $consultant = new Consultant();

        $consultant
            ->setEmail('true@test.com')
            ->setPassword('password')
            ->setResetToken('resetToken')
            ->setIsActivated(true)
            ->setIsVerified(true);
        

        $this->assertTrue($consultant->getEmail() === 'true@test.com');
        $this->assertTrue($consultant->getPassword() === 'password');
        $this->assertTrue($consultant->getResetToken() === 'resetToken');
        $this->assertTrue($consultant->isIsActivated() === true);
        $this->assertTrue($consultant->isVerified() === true);

    }

    public function testIsFalse()
    {
        $consultant = new Consultant();

        $consultant
            ->setEmail('true@test.com')
            ->setPassword('password')
            ->setResetToken('resetToken')
            ->setIsActivated(true)
            ->setIsVerified(true);

        $this->assertFalse($consultant->getEmail() === 'false@test.com');
        $this->assertFalse($consultant->getPassword() === 'false');
        $this->assertFalse($consultant->getResetToken() === 'false');
        $this->assertFalse($consultant->isIsActivated() === false);
        $this->assertFalse($consultant->isVerified() === false);

    }

    public function testIsEmpty()
    {
        $consultant = new Consultant();

        $this->assertEmpty($consultant->getEmail());
        $this->assertEmpty($consultant->getResetToken());
        $this->assertEmpty($consultant->isIsActivated());
        $this->assertEmpty($consultant->isVerified());
    }
}

<?php

namespace App\Tests;

use App\Entity\Administrator;
use PHPUnit\Framework\TestCase;

class AdministratorUnitTest extends TestCase
{
    public function testIsTrue()
    {
        $admin = new Administrator();

        $admin
            ->setEmail('true@test.com')
            ->setPassword('password')
            ->setResetToken('resetToken')
            ->setIsActivated(true)
            ->setIsVerified(true);
        

        $this->assertTrue($admin->getEmail() === 'true@test.com');
        $this->assertTrue($admin->getPassword() === 'password');
        $this->assertTrue($admin->getResetToken() === 'resetToken');
        $this->assertTrue($admin->isIsActivated() === true);
        $this->assertTrue($admin->isVerified() === true);

    }

    public function testIsFalse()
    {
        $admin = new Administrator();

        $admin
            ->setEmail('true@test.com')
            ->setPassword('password')
            ->setResetToken('resetToken')
            ->setIsActivated(true)
            ->setIsVerified(true);

        $this->assertFalse($admin->getEmail() === 'false@test.com');
        $this->assertFalse($admin->getPassword() === 'false');
        $this->assertFalse($admin->getResetToken() === 'false');
        $this->assertFalse($admin->isIsActivated() === false);
        $this->assertFalse($admin->isVerified() === false);

    }

    public function testIsEmpty()
    {
        $admin = new Administrator();

        $this->assertEmpty($admin->getEmail());
        $this->assertEmpty($admin->getResetToken());
        $this->assertEmpty($admin->isIsActivated());
        $this->assertEmpty($admin->isVerified());
    }
}

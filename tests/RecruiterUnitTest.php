<?php

namespace App\Tests;

use App\Entity\Recruiter;
use PHPUnit\Framework\TestCase;

class RecruiterUnitTest extends TestCase
{
    public function testIsTrue()
    {
        $recruiter = new Recruiter();

        $recruiter
            ->setEmail('true@test.com')
            ->setPassword('password')
            ->setName('name')
            ->setAddress('address')
            ->setZipcode('zipcode')
            ->setCity('city')
            ->setResetToken('resetToken')
            ->setIsActivated(true)
            ->setIsVerified(true);
        

        $this->assertTrue($recruiter->getEmail() === 'true@test.com');
        $this->assertTrue($recruiter->getPassword() === 'password');
        $this->assertTrue($recruiter->getName() === 'name');
        $this->assertTrue($recruiter->getAddress() === 'address');
        $this->assertTrue($recruiter->getZipcode() === 'zipcode');
        $this->assertTrue($recruiter->getCity() === 'city');
        $this->assertTrue($recruiter->getResetToken() === 'resetToken');
        $this->assertTrue($recruiter->isIsActivated() === true);
        $this->assertTrue($recruiter->isVerified() === true);

    }

    public function testIsFalse()
    {
        $recruiter = new Recruiter();

        $recruiter
            ->setEmail('true@test.com')
            ->setPassword('password')
            ->setName('name')
            ->setAddress('adresse')
            ->setZipcode('zipcode')
            ->setCity('city')
            ->setResetToken('resetToken')
            ->setIsActivated(true)
            ->setIsVerified(true);

        $this->assertFalse($recruiter->getEmail() === 'false@test.com');
        $this->assertFalse($recruiter->getPassword() === 'false');
        $this->assertFalse($recruiter->getName() === 'false');
        $this->assertFalse($recruiter->getAddress() === 'false');
        $this->assertFalse($recruiter->getZipcode() === 'false');
        $this->assertFalse($recruiter->getCity() === 'false');
        $this->assertFalse($recruiter->getResetToken() === 'false');
        $this->assertFalse($recruiter->isIsActivated() === false);
        $this->assertFalse($recruiter->isVerified() === false);

    }

    public function testIsEmpty()
    {
        $recruiter = new Recruiter();

        $this->assertEmpty($recruiter->getEmail());
        $this->assertEmpty($recruiter->getName());
        $this->assertEmpty($recruiter->getAddress());
        $this->assertEmpty($recruiter->getZipcode());
        $this->assertEmpty($recruiter->getCity());
        $this->assertEmpty($recruiter->getResetToken());
        $this->assertEmpty($recruiter->isIsActivated());
        $this->assertEmpty($recruiter->isVerified());
    }
}

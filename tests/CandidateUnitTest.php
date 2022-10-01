<?php

namespace App\Tests;

use App\Entity\Candidate;
use PHPUnit\Framework\TestCase;

class CandidateUnitTest extends TestCase
{
    public function testIsTrue()
    {
        $candidat = new Candidate();

        $candidat
            ->setEmail('true@test.com')
            ->setPassword('password')
            ->setFirstname('firstname')
            ->setLastname('lastname')
            ->setCv('cv')
            ->setResetToken(('reset_token'))
            ->setIsActivated(true)
            ->setIsVerified(true);
        

        $this->assertTrue($candidat->getEmail() === 'true@test.com');
        $this->assertTrue($candidat->getPassword() === 'password');
        $this->assertTrue($candidat->getFirstname() === 'firstname');
        $this->assertTrue($candidat->getLastname() === 'lastname');
        $this->assertTrue($candidat->getCv() === 'cv');
        $this->assertTrue($candidat->getResetToken() === 'reset_token');
        $this->assertTrue($candidat->isIsActivated() === true);
        $this->assertTrue($candidat->isVerified() === true);

    }

    public function testIsFalse()
    {
        $candidat = new Candidate();

        $candidat
            ->setEmail('true@test.com')
            ->setPassword('password')
            ->setFirstname('firstname')
            ->setLastname('lastname')
            ->setCv('cv')
            ->setResetToken(('reset_token'))
            ->setIsActivated(true)
            ->setIsVerified(true);

            $this->assertFalse($candidat->getEmail() === 'false@test.com');
            $this->assertFalse($candidat->getPassword() === 'false');
            $this->assertFalse($candidat->getFirstname() === 'false');
            $this->assertFalse($candidat->getLastname() === 'false');
            $this->assertFalse($candidat->getCv() === 'false');
            $this->assertFalse($candidat->getResetToken() === 'false');
            $this->assertFalse($candidat->isIsActivated() === false);
            $this->assertFalse($candidat->isVerified() === false);

    }

    public function testIsEmpty()
    {
        $candidat = new Candidate();

        $this->assertEmpty($candidat->getEmail());
        $this->assertEmpty($candidat->getFirstname());
        $this->assertEmpty($candidat->getLastname());
        $this->assertEmpty($candidat->getCv());
        $this->assertEmpty($candidat->getResetToken());
        $this->assertEmpty($candidat->isIsActivated());
        $this->assertEmpty($candidat->isVerified());
    }
}

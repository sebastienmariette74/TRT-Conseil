<?php

namespace App\Tests;

use App\Entity\JobOffer;
use App\Entity\Recruiter;
use PHPUnit\Framework\TestCase;

class JobOfferUnitTest extends TestCase
{
    public function testIsTrue()
    {
        $jobOffer = new JobOffer();
        $recruiter = new Recruiter();

        $jobOffer
            ->setTitle('title')
            ->setCity('city')
            ->setDescription('description')
            ->setRecruiter($recruiter)
            ->setIsActivated(true);
        

        $this->assertTrue($jobOffer->getTitle() === 'title');
        $this->assertTrue($jobOffer->getCity() === 'city');
        $this->assertTrue($jobOffer->getDescription() === 'description');
        $this->assertTrue($jobOffer->getRecruiter() === $recruiter);
        $this->assertTrue($jobOffer->isIsActivated() === true);

    }

    public function testIsFalse()
    {
        $jobOffer = new JobOffer();
        $recruiter = new Recruiter();

        $jobOffer
            ->setTitle('title')
            ->setCity('city')
            ->setDescription('description')
            ->setRecruiter($recruiter)
            ->setIsActivated(true);

            $this->assertFalse($jobOffer->getTitle() === 'false@test.com');
            $this->assertFalse($jobOffer->getCity() === 'false');
            $this->assertFalse($jobOffer->getDescription() === 'false');
            $this->assertFalse($jobOffer->getRecruiter() === new Recruiter());
            $this->assertFalse($jobOffer->isIsActivated() === false);
    }

    public function testIsEmpty()
    {
        $jobOffer = new JobOffer();

        $this->assertEmpty($jobOffer->getTitle());
        $this->assertEmpty($jobOffer->getCity());
        $this->assertEmpty($jobOffer->getDescription());
        $this->assertEmpty($jobOffer->getRecruiter());
        $this->assertEmpty($jobOffer->isIsActivated());
    }
}

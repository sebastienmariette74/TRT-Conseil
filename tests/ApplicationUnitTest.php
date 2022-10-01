<?php

namespace App\Tests;

use App\Entity\Application;
use App\Entity\Candidate;
use App\Entity\JobOffer;
use PHPUnit\Framework\TestCase;

class ApplicationUnitTest extends TestCase
{
    public function testIsTrue()
    {
        $application = new Application();
        $candidate = new Candidate();
        $jobOffer = new JobOffer();

        $application
            ->setCandidate($candidate)
            ->setJobOffer($jobOffer)
            ->setIsActivated(true);
        

        $this->assertTrue($application->getCandidate() === $candidate);
        $this->assertTrue($application->getJobOffer() === $jobOffer);
        $this->assertTrue($application->isIsActivated() === true);

    }

    public function testIsFalse()
    {
        $application = new Application();
        $candidate = new Candidate();
        $jobOffer = new JobOffer();

        $application
            ->setCandidate($candidate)
            ->setJobOffer($jobOffer)
            ->setIsActivated(true);

        $this->assertFalse($application->getCandidate() === new Candidate());
        $this->assertFalse($application->getJobOffer() === new JobOffer());
        $this->assertFalse($application->isIsActivated() === false);

    }

    public function testIsEmpty()
    {
        $application = new Application();

        $this->assertEmpty($application->getCandidate());
        $this->assertEmpty($application->getJobOffer());
        $this->assertEmpty($application->isIsActivated());
    }
}

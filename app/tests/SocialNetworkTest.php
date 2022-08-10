<?php

namespace App\Tests;

use App\Entity\SocialNetwork;
use PHPUnit\Framework\TestCase;

class SocialNetworkTest extends TestCase
{
    public function testCanBeCreatedWithNullLogoUrl(): void
    {
        $this->assertInstanceOf(SocialNetwork::class, new SocialNetwork("Facebook", "http://test.com", null));
    }

    public function testCanBeCreatedWithoutLogoUrl(): void
    {
        $this->assertInstanceOf(SocialNetwork::class, new SocialNetwork("Facebook", "http://test.com"));
    }
}

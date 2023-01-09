<?php

declare(strict_types=1);

namespace Marvin255\Jwt\Symfony\Tests\Profile;

use Marvin255\Jwt\Symfony\Profile\JwtProfile;
use Marvin255\Jwt\Symfony\Profile\JwtProfileManager;
use Marvin255\Jwt\Symfony\Tests\BaseCase;

/**
 * @internal
 */
class JwtProfileManagerTest extends BaseCase
{
    public function testConstructorException(): void
    {
        $profile = $this->getMockBuilder(JwtProfile::class)->getMock();

        $this->expectException(\InvalidArgumentException::class);
        new JwtProfileManager([$profile, 'test']);
    }

    public function testProfile(): void
    {
        $profile = $this->getMockBuilder(JwtProfile::class)->getMock();
        $profile->method('getName')->willReturn('test');

        $profile1 = $this->getMockBuilder(JwtProfile::class)
            ->disableOriginalConstructor()
            ->getMock();
        $profile1->method('getName')->willReturn('test_1');

        $manager = new JwtProfileManager([$profile, $profile1]);
        $testedProfile = $manager->profile('test_1');

        $this->assertSame($profile1, $testedProfile);
    }

    public function testProfileDefault(): void
    {
        $profile = $this->getMockBuilder(JwtProfile::class)->getMock();
        $profile->method('getName')->willReturn('test');

        $profile1 = $this->getMockBuilder(JwtProfile::class)
            ->disableOriginalConstructor()
            ->getMock();
        $profile1->method('getName')->willReturn('test_1');

        $manager = new JwtProfileManager([$profile, $profile1]);
        $testedProfile = $manager->profile();

        $this->assertSame($profile, $testedProfile);
    }

    public function testProfileNotFound(): void
    {
        $profile = $this->getMockBuilder(JwtProfile::class)->getMock();
        $profile->method('getName')->willReturn('test');

        $manager = new JwtProfileManager([$profile]);

        $this->expectException(\InvalidArgumentException::class);
        $manager->profile('test_1');
    }
}

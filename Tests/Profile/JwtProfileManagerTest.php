<?php

declare(strict_types=1);

namespace Marvin255\Jwt\Symfony\Tests\Profile;

use Marvin255\Jwt\Symfony\Profile\JwtProfile;
use Marvin255\Jwt\Symfony\Profile\JwtProfileManager;
use Marvin255\Jwt\Symfony\Tests\BaseCase;

/**
 * @internal
 */
final class JwtProfileManagerTest extends BaseCase
{
    public function testConstructorException(): void
    {
        $exceptionMessage = 'JWT profile must implements ' . JwtProfile::class;
        $profile = $this->getMockBuilder(JwtProfile::class)->getMock();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage($exceptionMessage);
        new JwtProfileManager(
            [
                $profile,
                'test',
            ]
        );
    }

    public function testProfile(): void
    {
        $name = 'test_1';

        $profile = $this->getMockBuilder(JwtProfile::class)->getMock();
        $profile->method('getName')->willReturn('test');

        $profile1 = $this->getMockBuilder(JwtProfile::class)
            ->disableOriginalConstructor()
            ->getMock();
        $profile1->method('getName')->willReturn($name);

        $manager = new JwtProfileManager(
            [
                $profile,
                $profile1,
            ]
        );
        $testedProfile = $manager->profile($name);

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

        $manager = new JwtProfileManager(
            [
                $profile,
                $profile1,
            ]
        );
        $testedProfile = $manager->profile();

        $this->assertSame($profile, $testedProfile);
    }

    public function testProfileNotFoundException(): void
    {
        $name = 'test_1';
        $exceptionMessage = "Can't find profile with name {$name}";

        $profile = $this->getMockBuilder(JwtProfile::class)->getMock();
        $profile->method('getName')->willReturn('test');

        $manager = new JwtProfileManager(
            [
                $profile,
            ]
        );

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage($exceptionMessage);
        $manager->profile($name);
    }

    public function testProfileNotFoundDefaultException(): void
    {
        $manager = new JwtProfileManager();

        $this->expectException(\InvalidArgumentException::class);
        $manager->profile();
    }
}

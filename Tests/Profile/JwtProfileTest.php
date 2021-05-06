<?php

declare(strict_types=1);

namespace Marvin255\Jwt\Symfony\Tests\Profile;

use Marvin255\Jwt\JwtBuilder;
use Marvin255\Jwt\JwtDecoder;
use Marvin255\Jwt\JwtEncoder;
use Marvin255\Jwt\JwtSigner;
use Marvin255\Jwt\JwtValidator;
use Marvin255\Jwt\Symfony\Profile\JwtProfile;
use Marvin255\Jwt\Symfony\Tests\BaseCase;

/**
 * @internal
 */
class JwtProfileTest extends BaseCase
{
    public function testGetName(): void
    {
        $name = 'name';
        $decoder = $this->getMockBuilder(JwtDecoder::class)->getMock();
        $encoder = $this->getMockBuilder(JwtEncoder::class)->getMock();
        $builder = $this->getMockBuilder(JwtBuilder::class)->getMock();
        $validator = $this->getMockBuilder(JwtValidator::class)->getMock();
        $signer = $this->getMockBuilder(JwtSigner::class)->getMock();

        $profile = new JwtProfile(
            $name,
            $decoder,
            $encoder,
            $builder,
            $validator,
            $signer
        );
        $testName = $profile->getName();

        $this->assertSame($name, $testName);
    }

    public function testGetDecoder(): void
    {
        $name = 'name';
        $decoder = $this->getMockBuilder(JwtDecoder::class)->getMock();
        $encoder = $this->getMockBuilder(JwtEncoder::class)->getMock();
        $builder = $this->getMockBuilder(JwtBuilder::class)->getMock();
        $validator = $this->getMockBuilder(JwtValidator::class)->getMock();
        $signer = $this->getMockBuilder(JwtSigner::class)->getMock();

        $profile = new JwtProfile(
            $name,
            $decoder,
            $encoder,
            $builder,
            $validator,
            $signer
        );
        $testDecoder = $profile->getDecoder();

        $this->assertSame($decoder, $testDecoder);
    }

    public function testGetEncoder(): void
    {
        $name = 'name';
        $decoder = $this->getMockBuilder(JwtDecoder::class)->getMock();
        $encoder = $this->getMockBuilder(JwtEncoder::class)->getMock();
        $builder = $this->getMockBuilder(JwtBuilder::class)->getMock();
        $validator = $this->getMockBuilder(JwtValidator::class)->getMock();
        $signer = $this->getMockBuilder(JwtSigner::class)->getMock();

        $profile = new JwtProfile(
            $name,
            $decoder,
            $encoder,
            $builder,
            $validator,
            $signer
        );
        $testEncoder = $profile->getEncoder();

        $this->assertSame($encoder, $testEncoder);
    }

    public function testGetBuilder(): void
    {
        $name = 'name';
        $decoder = $this->getMockBuilder(JwtDecoder::class)->getMock();
        $encoder = $this->getMockBuilder(JwtEncoder::class)->getMock();
        $builder = $this->getMockBuilder(JwtBuilder::class)->getMock();
        $validator = $this->getMockBuilder(JwtValidator::class)->getMock();
        $signer = $this->getMockBuilder(JwtSigner::class)->getMock();

        $profile = new JwtProfile(
            $name,
            $decoder,
            $encoder,
            $builder,
            $validator,
            $signer
        );
        $testBuilder = $profile->getBuilder();

        $this->assertSame($builder, $testBuilder);
    }

    public function testGetValidator(): void
    {
        $name = 'name';
        $decoder = $this->getMockBuilder(JwtDecoder::class)->getMock();
        $encoder = $this->getMockBuilder(JwtEncoder::class)->getMock();
        $builder = $this->getMockBuilder(JwtBuilder::class)->getMock();
        $validator = $this->getMockBuilder(JwtValidator::class)->getMock();
        $signer = $this->getMockBuilder(JwtSigner::class)->getMock();

        $profile = new JwtProfile(
            $name,
            $decoder,
            $encoder,
            $builder,
            $validator,
            $signer
        );
        $testValidator = $profile->getValidator();

        $this->assertSame($validator, $testValidator);
    }

    public function testGetSigner(): void
    {
        $name = 'name';
        $decoder = $this->getMockBuilder(JwtDecoder::class)->getMock();
        $encoder = $this->getMockBuilder(JwtEncoder::class)->getMock();
        $builder = $this->getMockBuilder(JwtBuilder::class)->getMock();
        $validator = $this->getMockBuilder(JwtValidator::class)->getMock();
        $signer = $this->getMockBuilder(JwtSigner::class)->getMock();

        $profile = new JwtProfile(
            $name,
            $decoder,
            $encoder,
            $builder,
            $validator,
            $signer
        );
        $testSigner = $profile->getSigner();

        $this->assertSame($signer, $testSigner);
    }
}

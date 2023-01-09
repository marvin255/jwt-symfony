<?php

declare(strict_types=1);

namespace Marvin255\Jwt\Symfony\Tests\Profile;

use Marvin255\Jwt\JwtBuilder;
use Marvin255\Jwt\JwtDecoder;
use Marvin255\Jwt\JwtEncoder;
use Marvin255\Jwt\JwtSigner;
use Marvin255\Jwt\JwtValidator;
use Marvin255\Jwt\Symfony\Profile\JwtProfileBase;
use Marvin255\Jwt\Symfony\Tests\BaseCase;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * @internal
 */
class JwtProfileBaseTest extends BaseCase
{
    public function testGetName(): void
    {
        $name = 'name';
        /** @var MockObject&JwtDecoder */
        $decoder = $this->getMockBuilder(JwtDecoder::class)->getMock();
        /** @var MockObject&JwtEncoder */
        $encoder = $this->getMockBuilder(JwtEncoder::class)->getMock();
        /** @var MockObject&JwtBuilder */
        $builder = $this->getMockBuilder(JwtBuilder::class)->getMock();
        /** @var MockObject&JwtValidator */
        $validator = $this->getMockBuilder(JwtValidator::class)->getMock();
        /** @var MockObject&JwtSigner */
        $signer = $this->getMockBuilder(JwtSigner::class)->getMock();

        $profile = new JwtProfileBase(
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
        /** @var MockObject&JwtDecoder */
        $decoder = $this->getMockBuilder(JwtDecoder::class)->getMock();
        /** @var MockObject&JwtEncoder */
        $encoder = $this->getMockBuilder(JwtEncoder::class)->getMock();
        /** @var MockObject&JwtBuilder */
        $builder = $this->getMockBuilder(JwtBuilder::class)->getMock();
        /** @var MockObject&JwtValidator */
        $validator = $this->getMockBuilder(JwtValidator::class)->getMock();
        /** @var MockObject&JwtSigner */
        $signer = $this->getMockBuilder(JwtSigner::class)->getMock();

        $profile = new JwtProfileBase(
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
        /** @var MockObject&JwtDecoder */
        $decoder = $this->getMockBuilder(JwtDecoder::class)->getMock();
        /** @var MockObject&JwtEncoder */
        $encoder = $this->getMockBuilder(JwtEncoder::class)->getMock();
        /** @var MockObject&JwtBuilder */
        $builder = $this->getMockBuilder(JwtBuilder::class)->getMock();
        /** @var MockObject&JwtValidator */
        $validator = $this->getMockBuilder(JwtValidator::class)->getMock();
        /** @var MockObject&JwtSigner */
        $signer = $this->getMockBuilder(JwtSigner::class)->getMock();

        $profile = new JwtProfileBase(
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
        /** @var MockObject&JwtDecoder */
        $decoder = $this->getMockBuilder(JwtDecoder::class)->getMock();
        /** @var MockObject&JwtEncoder */
        $encoder = $this->getMockBuilder(JwtEncoder::class)->getMock();
        /** @var MockObject&JwtBuilder */
        $builder = $this->getMockBuilder(JwtBuilder::class)->getMock();
        /** @var MockObject&JwtValidator */
        $validator = $this->getMockBuilder(JwtValidator::class)->getMock();
        /** @var MockObject&JwtSigner */
        $signer = $this->getMockBuilder(JwtSigner::class)->getMock();

        $profile = new JwtProfileBase(
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
        /** @var MockObject&JwtDecoder */
        $decoder = $this->getMockBuilder(JwtDecoder::class)->getMock();
        /** @var MockObject&JwtEncoder */
        $encoder = $this->getMockBuilder(JwtEncoder::class)->getMock();
        /** @var MockObject&JwtBuilder */
        $builder = $this->getMockBuilder(JwtBuilder::class)->getMock();
        /** @var MockObject&JwtValidator */
        $validator = $this->getMockBuilder(JwtValidator::class)->getMock();
        /** @var MockObject&JwtSigner */
        $signer = $this->getMockBuilder(JwtSigner::class)->getMock();

        $profile = new JwtProfileBase(
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
        /** @var MockObject&JwtDecoder */
        $decoder = $this->getMockBuilder(JwtDecoder::class)->getMock();
        /** @var MockObject&JwtEncoder */
        $encoder = $this->getMockBuilder(JwtEncoder::class)->getMock();
        /** @var MockObject&JwtBuilder */
        $builder = $this->getMockBuilder(JwtBuilder::class)->getMock();
        /** @var MockObject&JwtValidator */
        $validator = $this->getMockBuilder(JwtValidator::class)->getMock();
        /** @var MockObject&JwtSigner */
        $signer = $this->getMockBuilder(JwtSigner::class)->getMock();

        $profile = new JwtProfileBase(
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

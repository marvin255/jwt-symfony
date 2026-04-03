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

/**
 * @internal
 */
final class JwtProfileBaseTest extends BaseCase
{
    public function testGetName(): void
    {
        $name = 'name';

        $decoder = $this->createStub(JwtDecoder::class);
        $encoder = $this->createStub(JwtEncoder::class);
        $builder = $this->createStub(JwtBuilder::class);
        $validator = $this->createStub(JwtValidator::class);
        $signer = $this->createStub(JwtSigner::class);

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

        $decoder = $this->createStub(JwtDecoder::class);
        $encoder = $this->createStub(JwtEncoder::class);
        $builder = $this->createStub(JwtBuilder::class);
        $validator = $this->createStub(JwtValidator::class);
        $signer = $this->createStub(JwtSigner::class);

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

        $decoder = $this->createStub(JwtDecoder::class);
        $encoder = $this->createStub(JwtEncoder::class);
        $builder = $this->createStub(JwtBuilder::class);
        $validator = $this->createStub(JwtValidator::class);
        $signer = $this->createStub(JwtSigner::class);

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

        $decoder = $this->createStub(JwtDecoder::class);
        $encoder = $this->createStub(JwtEncoder::class);
        $validator = $this->createStub(JwtValidator::class);
        $signer = $this->createStub(JwtSigner::class);
        $builder = $this->getMockBuilder(JwtBuilder::class)->getMock();
        $builder->expects($this->once())
            ->method('signWith')
            ->with($this->identicalTo($signer));

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

        $decoder = $this->createStub(JwtDecoder::class);
        $encoder = $this->createStub(JwtEncoder::class);
        $builder = $this->createStub(JwtBuilder::class);
        $validator = $this->createStub(JwtValidator::class);
        $signer = $this->createStub(JwtSigner::class);

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

        $decoder = $this->createStub(JwtDecoder::class);
        $encoder = $this->createStub(JwtEncoder::class);
        $builder = $this->createStub(JwtBuilder::class);
        $validator = $this->createStub(JwtValidator::class);
        $signer = $this->createStub(JwtSigner::class);

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

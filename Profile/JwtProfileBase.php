<?php

declare(strict_types=1);

namespace Marvin255\Jwt\Symfony\Profile;

use Marvin255\Jwt\JwtBuilder;
use Marvin255\Jwt\JwtDecoder;
use Marvin255\Jwt\JwtEncoder;
use Marvin255\Jwt\JwtSigner;
use Marvin255\Jwt\JwtValidator;

/**
 * Object that stores profile for set JWT.
 *
 * @internal
 */
final class JwtProfileBase implements JwtProfile
{
    public function __construct(
        private readonly string $name,
        private readonly JwtDecoder $decoder,
        private readonly JwtEncoder $encoder,
        private readonly JwtBuilder $builder,
        private readonly JwtValidator $validator,
        private readonly ?JwtSigner $signer = null
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * {@inheritDoc}
     */
    public function getEncoder(): JwtEncoder
    {
        return $this->encoder;
    }

    /**
     * {@inheritDoc}
     */
    public function getDecoder(): JwtDecoder
    {
        return $this->decoder;
    }

    /**
     * {@inheritDoc}
     */
    public function getBuilder(): JwtBuilder
    {
        if ($this->signer !== null) {
            $this->builder->signWith($this->signer);
        }

        return $this->builder;
    }

    /**
     * {@inheritDoc}
     */
    public function getValidator(): JwtValidator
    {
        return $this->validator;
    }

    /**
     * {@inheritDoc}
     */
    public function getSigner(): ?JwtSigner
    {
        return $this->signer;
    }
}

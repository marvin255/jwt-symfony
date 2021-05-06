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
 */
class JwtProfile
{
    private string $name;

    private JwtDecoder $decoder;

    private JwtEncoder $encoder;

    private JwtBuilder $builder;

    private JwtValidator $validator;

    private ?JwtSigner $signer;

    public function __construct(
        string $name,
        JwtDecoder $decoder,
        JwtEncoder $encoder,
        JwtBuilder $builder,
        JwtValidator $validator,
        ?JwtSigner $signer = null
    ) {
        $this->name = $name;
        $this->decoder = $decoder;
        $this->encoder = $encoder;
        $this->builder = $builder;
        $this->validator = $validator;
        $this->signer = $signer;
    }

    /**
     * Returns name for this profile.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Returns encoder associated to this profile.
     *
     * @return JwtEncoder
     */
    public function getEncoder(): JwtEncoder
    {
        return $this->encoder;
    }

    /**
     * Returns decoder associated to this profile.
     *
     * @return JwtDecoder
     */
    public function getDecoder(): JwtDecoder
    {
        return $this->decoder;
    }

    /**
     * Returns decoder associated to this profile.
     *
     * @return JwtBuilder
     */
    public function getBuilder(): JwtBuilder
    {
        if ($this->signer !== null) {
            $this->builder->signWith($this->signer);
        }

        return $this->builder;
    }

    /**
     * Returns validator associated to this profile.
     *
     * @return JwtValidator
     */
    public function getValidator(): JwtValidator
    {
        return $this->validator;
    }

    /**
     * Returns signer associated to this profile.
     *
     * @return JwtSigner
     */
    public function getSigner(): ?JwtSigner
    {
        return $this->signer;
    }
}

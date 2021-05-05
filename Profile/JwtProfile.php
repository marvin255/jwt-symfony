<?php

declare(strict_types=1);

namespace Marvin255\Jwt\Symfony\Profile;

use Marvin255\Jwt\JwtBuilder;
use Marvin255\Jwt\JwtDecoder;
use Marvin255\Jwt\JwtEncoder;
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

    public function __construct(
        string $name,
        JwtDecoder $decoder,
        JwtEncoder $encoder,
        JwtBuilder $builder,
        JwtValidator $validator
    ) {
        $this->name = $name;
        $this->decoder = $decoder;
        $this->encoder = $encoder;
        $this->builder = $builder;
        $this->validator = $validator;
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
}

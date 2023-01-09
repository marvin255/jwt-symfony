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
interface JwtProfile
{
    /**
     * Returns name for this profile.
     */
    public function getName(): string;

    /**
     * Returns encoder associated to this profile.
     */
    public function getEncoder(): JwtEncoder;

    /**
     * Returns decoder associated to this profile.
     */
    public function getDecoder(): JwtDecoder;

    /**
     * Returns decoder associated to this profile.
     */
    public function getBuilder(): JwtBuilder;

    /**
     * Returns validator associated to this profile.
     */
    public function getValidator(): JwtValidator;

    /**
     * Returns signer associated to this profile.
     */
    public function getSigner(): ?JwtSigner;
}

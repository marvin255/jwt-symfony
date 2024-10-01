<?php

declare(strict_types=1);

namespace Marvin255\Jwt\Symfony\Profile;

/**
 * Object that stores all JWT profiles.
 */
final class JwtProfileManager
{
    /**
     * @var JwtProfile[]
     */
    private readonly array $profiles;

    public function __construct(iterable $profiles = [])
    {
        $returnProfiles = [];
        foreach ($profiles as $profile) {
            if (!($profile instanceof JwtProfile)) {
                throw new \InvalidArgumentException('JWT profile must implements ' . JwtProfile::class);
            }
            $returnProfiles[$profile->getName()] = $profile;
        }

        $this->profiles = $returnProfiles;
    }

    /**
     * Returns profile by set name or first profile if name is omitted.
     *
     * @throws \InvalidArgumentException
     */
    public function profile(?string $name = null): JwtProfile
    {
        $defaultKey = array_key_first($this->profiles);

        $profile = null;
        if ($name === null && $defaultKey !== null) {
            $profile = $this->profiles[$defaultKey];
        } elseif (isset($this->profiles[$name])) {
            $profile = $this->profiles[$name];
        }

        if (!($profile instanceof JwtProfile)) {
            throw new \InvalidArgumentException("Can't find profile with name {$name}");
        }

        return $profile;
    }
}

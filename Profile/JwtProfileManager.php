<?php

declare(strict_types=1);

namespace Marvin255\Jwt\Symfony\Profile;

use InvalidArgumentException;

/**
 * Object that stores all JWT profiles.
 */
class JwtProfileManager
{
    /**
     * @var JwtProfile[]
     */
    private array $profiles;

    public function __construct(iterable $profiles = [])
    {
        $this->profiles = [];
        foreach ($profiles as $profile) {
            if (!($profile instanceof JwtProfile)) {
                $message = sprintf('JWT profile must implements %s.', JwtProfile::class);
                throw new InvalidArgumentException($message);
            }
            $this->profiles[$profile->getName()] = $profile;
        }
    }

    /**
     * Returns profile by set name or first profile if name is omitted.
     *
     * @param string|null $name
     *
     * @return JwtProfile
     *
     * @throws InvalidArgumentException
     */
    public function profile(?string $name = null): JwtProfile
    {
        $profile = null;
        if ($name === null) {
            $profile = reset($this->profiles);
        } elseif (isset($this->profiles[$name])) {
            $profile = $this->profiles[$name];
        }

        if (!($profile instanceof JwtProfile)) {
            $message = sprintf("Can't find profile with name '%s'.", (string) $name);
            throw new InvalidArgumentException($message);
        }

        return $profile;
    }
}

<?php

namespace App\Enum\SelfDisclosure;

use App\Traits\HasValues;

enum SelfDisclosureStep: string
{
    use HasValues;

    case PERSONAL = 'personal';
    case FAMILY = 'family';
    case ADDRESS = 'address';
    case HOME = 'home';
    case GARDEN = 'garden';
    case EXPERIENCES = 'experiences';
    case ELIGIBILITY = 'eligibility';
    case SPECIFIC = 'specific';
    case CONFIRMATION = 'confirmation';

    function previous(): ?SelfDisclosureStep
    {
        return match ($this) {
            self::FAMILY => self::PERSONAL,
            self::ADDRESS => self::FAMILY,
            self::HOME => self::ADDRESS,
            self::GARDEN => self::HOME,
            self::EXPERIENCES => self::GARDEN,
            self::ELIGIBILITY => self::EXPERIENCES,
            self::SPECIFIC => self::ELIGIBILITY,
            self::CONFIRMATION => self::SPECIFIC,
            default => null,
        };
    }

    function next(): ?SelfDisclosureStep
    {
        return match ($this) {
            self::PERSONAL => self::FAMILY,
            self::FAMILY => self::ADDRESS,
            self::ADDRESS => self::HOME,
            self::HOME => self::GARDEN,
            self::GARDEN => self::EXPERIENCES,
            self::EXPERIENCES => self::ELIGIBILITY,
            self::ELIGIBILITY => self::SPECIFIC,
            self::SPECIFIC => self::CONFIRMATION,
            default => null,
        };
    }

    function route(): string
    {
        return match ($this) {
            self::PERSONAL => 'self-disclosure.personal.show',
            self::FAMILY => 'self-disclosure.family.show',
            self::ADDRESS => 'self-disclosure.address.show',
            self::HOME => 'self-disclosure.home.show',
            self::GARDEN => 'self-disclosure.garden.show',
            self::EXPERIENCES => 'self-disclosure.experiences.show',
            self::ELIGIBILITY => 'self-disclosure.eligibility.show',
            self::SPECIFIC => 'self-disclosure.specific.show',
            self::CONFIRMATION => 'self-disclosure.confirmation.show',
        };
    }
}

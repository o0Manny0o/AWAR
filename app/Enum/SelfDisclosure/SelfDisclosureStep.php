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
    case COMPLETE = 'complete';

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
            self::CONFIRMATION => self::COMPLETE,
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
            self::COMPLETE => 'self-disclosure.complete',
        };
    }

    function index(): int
    {
        return match ($this) {
            self::PERSONAL => 0,
            self::FAMILY => 1,
            self::ADDRESS => 2,
            self::HOME => 3,
            self::GARDEN => 4,
            self::EXPERIENCES => 5,
            self::ELIGIBILITY => 6,
            self::SPECIFIC => 7,
            self::CONFIRMATION => 8,
            self::COMPLETE => 9,
        };
    }

    static function formSteps(): array
    {
        return [
            self::PERSONAL,
            self::FAMILY,
            self::ADDRESS,
            self::HOME,
            self::GARDEN,
            self::EXPERIENCES,
            self::ELIGIBILITY,
            self::SPECIFIC,
            self::CONFIRMATION,
        ];
    }

    static function formStepValues(): array
    {
        return [
            self::PERSONAL->value,
            self::FAMILY->value,
            self::ADDRESS->value,
            self::HOME->value,
            self::GARDEN->value,
            self::EXPERIENCES->value,
            self::ELIGIBILITY->value,
            self::SPECIFIC->value,
            self::CONFIRMATION->value,
        ];
    }
}

<?php

namespace App\Enum;

class UserGenderEnum
{
    public const MAN = 'man';
    public const WOMAN = 'woman';
    public const OTHER = 'other';

    public static function fromString(string $gender): string
    {
        return match ($gender) {
            self::MAN => self::MAN,
            self::WOMAN => self::WOMAN,
            self::OTHER => self::OTHER,
            default => throw new \InvalidArgumentException('Gender value is not valid.'),
        };
    }
}

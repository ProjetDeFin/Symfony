<?php

namespace App\Enum;

enum UserGenderEnum: string
{
    case MAN = 'man';
    case WOMAN = 'woman';
    case OTHER = 'other';

    public static function fromString(string $gender): UserGenderEnum
    {
        return match ($gender) {
            'man' => self::MAN,
            'woman' => self::WOMAN,
            'other' => self::OTHER,
            default => throw new \InvalidArgumentException('Gender value is not valid.'),
        };
    }
}

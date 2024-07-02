<?php

namespace App\Enum;

enum TypeEnum: string
{
    case INTERNSHIP = 'stage';
    case ALTERNATION = 'alternance';

    public static function fromString(string $status): TypeEnum
    {
        return match ($status) {
            'pending' => self::INTERNSHIP,
            'accepted' => self::ALTERNATION,
            default => throw new \InvalidArgumentException('Status value is not valid.'),
        };
    }

    public function toString(): string
    {
        return match ($this) {
            self::INTERNSHIP => 'Stage',
            self::ALTERNATION => 'Alternance',
        };
    }
}

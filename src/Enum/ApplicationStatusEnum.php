<?php

namespace App\Enum;

enum ApplicationStatusEnum: string
{
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case REFUSED = 'refused';
    case CANCELLED = 'cancelled';

    public static function fromString(string $status): ApplicationStatusEnum
    {
        return match ($status) {
            'pending' => self::PENDING,
            'accepted' => self::ACCEPTED,
            'refused' => self::REFUSED,
            'cancelled' => self::CANCELLED,
            default => throw new \InvalidArgumentException('Status value is not valid.'),
        };
    }
}

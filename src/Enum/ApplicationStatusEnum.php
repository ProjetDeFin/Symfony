<?php

namespace App\Enum;

enum ApplicationStatusEnum: string
{
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case REFUSED = 'refused';
    case CANCELLED = 'cancelled';

    case APPLICATION = 'application';

    public static function fromString(string $status): ApplicationStatusEnum
    {
        return match ($status) {
            'pending' => self::PENDING,
            'accepted' => self::ACCEPTED,
            'refused' => self::REFUSED,
            'cancelled' => self::CANCELLED,
            'application' => self::APPLICATION,
            default => throw new \InvalidArgumentException('Status value is not valid.'),
        };
    }
}

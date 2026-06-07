<?php

declare(strict_types=1);

namespace App\Enums;

enum CategoryStatus: string
{
    case Online = 'online';
    case Disabled = 'disabled';
    case Archived = 'archived';

    public function label(): string
    {
        return match ($this) {
            self::Online => 'En ligne',
            self::Disabled => 'Désactivée',
            self::Archived => 'Archivée',
        };
    }
}

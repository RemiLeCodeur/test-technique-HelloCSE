<?php

declare(strict_types=1);

namespace App\Enums;

enum ProductStatus: string
{
    case Online = 'online';
    case Draft = 'draft';
    case Disabled = 'disabled';

    public function label(): string
    {
        return match ($this) {
            self::Online => 'En ligne',
            self::Draft => 'Brouillon',
            self::Disabled => 'Désactivée',
        };
    }
}

<?php

namespace App\Support;

enum PropertyRelationType: string
{
    case Owner = 'owner';
    case Tenant = 'tenant';
    case Vacant = 'vacant';

    public function label(): string
    {
        return match ($this) {
            self::Owner => 'مالك',
            self::Tenant => 'مستأجر',
            self::Vacant => 'فروغ',
        };
    }

    /**
     * @return array<string, string>
     */
    public static function options(): array
    {
        $options = [];

        foreach (self::cases() as $case) {
            $options[$case->value] = $case->label();
        }

        return $options;
    }

    public static function labelFor(?string $value): string
    {
        if ($value === null || $value === '') {
            return '—';
        }

        return self::tryFrom($value)?->label() ?? $value;
    }
}

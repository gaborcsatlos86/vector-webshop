<?php

declare(strict_types=1);

namespace App\Enums;

enum ProductStoreAction: string
{
    case Init = 'init';
    case Add = 'add';
    case Remove = 'remove';
    
    public static function getItems(): array
    {
        return [
            self::Init->value => self::Init->value,
            self::Add->value => self::Add->value,
            self::Remove->value => self::Remove->value,
        ];
    }
    
    public static function findByValue(string $value): ?self
    {
        foreach (self::cases() as $productStoreAction) {
            if ($productStoreAction->value == $value) {
                return $productStoreAction;
            }
        }
        return null;
    }
}

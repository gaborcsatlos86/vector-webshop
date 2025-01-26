<?php

declare(strict_types=1);

namespace App\Enums;

enum OrderState: string
{
    case Created = 'created';
    case InProcess = 'in-process';
    case WaitingForDelivery = 'waiting-for-delivery';
    case UnderDelivery = 'under-delivery';
    case Closed = 'closed';
    case Failed = 'failed';
    
    public static function getItems(): array
    {
        return [
            self::Created->value => self::Created->value,
            self::InProcess->value => self::InProcess->value,
            self::WaitingForDelivery->value => self::WaitingForDelivery->value,
            self::UnderDelivery->value => self::UnderDelivery->value,
            self::Closed->value => self::Closed->value,
            self::Failed->value => self::Failed->value,
        ];
    }
    
    public static function findByValue(string $value): ?self
    {
        foreach (self::cases() as $orderState) {
            if ($orderState->value == $value) {
                return $orderState;
            }
        }
        return null;
    }
}

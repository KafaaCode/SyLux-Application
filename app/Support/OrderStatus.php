<?php

namespace App\Support;

class OrderStatus
{
    public const PENDING = 'pending';
    public const PROCESSING = 'processing';
    public const PARTIAL_DELIVERY = 'partial_delivery';
    public const DELIVERED = 'delivered';
    public const COMPLETED = 'completed';
    public const CANCELLED = 'cancelled';

    public static function all(): array
    {
        return [
            self::PENDING,
            self::PROCESSING,
            self::PARTIAL_DELIVERY,
            self::DELIVERED,
            self::COMPLETED,
            self::CANCELLED,
        ];
    }

    public static function labels(): array
    {
        return [
            self::PENDING => 'قيد الانتظار',
            self::PROCESSING => 'قيد التجهيز',
            self::PARTIAL_DELIVERY => 'تسليم جزئي',
            self::DELIVERED => 'تم التسليم',
            self::COMPLETED => 'مكتمل',
            self::CANCELLED => 'ملغى',
        ];
    }

    public static function label(?string $status): string
    {
        if (!$status) {
            return 'غير محدد';
        }

        $normalized = self::normalize($status);

        return self::labels()[$normalized] ?? $status;
    }

    public static function badgeClass(?string $status): string
    {
        return match (self::normalize($status)) {
            self::PENDING => 'bg-warning text-dark',
            self::PROCESSING => 'bg-info',
            self::PARTIAL_DELIVERY => 'bg-primary',
            self::DELIVERED => 'bg-success',
            self::COMPLETED => 'bg-success',
            self::CANCELLED => 'bg-danger',
            default => 'bg-secondary',
        };
    }

    public static function normalize(?string $status): string
    {
        $map = [
            'pending' => self::PENDING,
            'Pending' => self::PENDING,
            'جديد' => self::PENDING,
            'processing' => self::PROCESSING,
            'delivery' => self::DELIVERED,
            'partial delivery' => self::PARTIAL_DELIVERY,
            'Partial Delivery' => self::PARTIAL_DELIVERY,
            'delivered' => self::DELIVERED,
            'completed' => self::COMPLETED,
            'Completed' => self::COMPLETED,
            'مقبول' => self::PROCESSING,
            'canceled' => self::CANCELLED,
            'cancelled' => self::CANCELLED,
            'مرفوض' => self::CANCELLED,
        ];

        return $map[$status] ?? strtolower(str_replace(' ', '_', $status ?? ''));
    }
}

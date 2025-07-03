<?php
namespace App\Enums;

enum PostStatus: int
{
    case PENDING = 0;
    case APPROVE = 1;
    case DENY = 2;

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Đang chờ duyệt',
            self::APPROVE => 'Đã duyệt',
            self::DENY => 'Bị từ chối',
        };
    }
}
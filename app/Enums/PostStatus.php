<?php
namespace App\Enums;

enum PostStatus: int
{
    case NEW = 0;
    case UPDATE = 1;

    public function label(): string
    {
        return match ($this) {
            self::NEW => 'Bài viết mới',
            self::UPDATE => 'Được cập nhật'
        };
    }
}
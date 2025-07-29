<?php

use Carbon\Carbon;
use Illuminate\Support\Str;

function FormatDateTime($datetime, $format = 'd/m/Y H:i'): string
{
    if (!$datetime) {
        return '';
    }

    return Carbon::parse($datetime)->format($format);
}

function UniqueSlug(string $title): string
{
    $slug = Str::slug($title);
    $hashSlug = substr(md5(uniqid($slug, true)), 0, 6);
    return "{$slug}-{$hashSlug}";
}

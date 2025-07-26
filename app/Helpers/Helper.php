<?php

use Carbon\Carbon;
use Illuminate\Support\Str;

function format_datetime($datetime, $format = 'd/m/Y H:i'): string
{
    if (!$datetime) {
        return '';
    }

    return Carbon::parse($datetime)->format($format);
}

function generate_unique_slug(string $title): string
{
    $slug = Str::slug($title);
    $hashSlug = substr(md5(uniqid($slug, true)), 0, 6);
    return "{$slug}-{$hashSlug}";
}

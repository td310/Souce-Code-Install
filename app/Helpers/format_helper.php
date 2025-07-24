<?php

use Carbon\Carbon;

function format_datetime($datetime, $format = 'd/m/Y H:i'): string
{
    if (!$datetime) {
        return '';
    }

    return Carbon::parse($datetime)->format($format);
}

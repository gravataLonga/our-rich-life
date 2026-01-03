<?php

if( !function_exists('clamp')) {
    function clamp(int|float|\Closure $current, int|float $min, int|float $max): int|float
    {
        $current = value($current);
        return match (true) {
            $current < $min => $min,
            $current > $max => $max,
            default => $current,
        };
    }
}

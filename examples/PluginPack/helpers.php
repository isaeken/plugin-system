<?php

if (! function_exists('subtotal')) {
    /**
     * @param  array<float>  $prices
     * @return float
     */
    function subtotal(array $prices): float
    {
        return array_sum($prices);
    }
}

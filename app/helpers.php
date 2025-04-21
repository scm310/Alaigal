if (!function_exists('calculateMarketplacePrice')) {
    function calculateMarketplacePrice($cart) {
        $base = $cart['marketplace_plan'] == 5 ? 1000 : 2000;
        $extra = (($cart['product_count'] - 5) / 5) * 100;
        return number_format($base + $extra, 2);
    }
}
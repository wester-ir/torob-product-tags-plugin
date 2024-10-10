<?php

if (! defined('LARAVEL_START')) {
    exit(0);
}

if (request()->routeIs('client.product.index')) {
    pluginRepository()->addAction(
        hookName: 'head',
        callback: function () {
            $product = \View::getShared()['product'] ?? null;
            
            if ($product) {
                $html = '
            
                    <!-- Torob Tags -->
                    <meta name="product_id" content="'. $product->id .'">
                    <meta name="product_name" content="'. e($product->title) .'">
                    <meta name="product_price" content="'. $product->final_price .'">
                    <meta name="product_old_price" content="'. $product->price .'">
                    <meta name="availability" content="'. ($product->is_quantity_unlimited || $product->quantity > 0 ? 'instock' : 'outofstock') .'">
                
                ';

                if ($product->image) {
                    $html .= '<meta property="og:image" content="'. $product->image->url['medium'] .'">';
                }

                return $html;
            }
        },
    );
}

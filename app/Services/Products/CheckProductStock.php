<?php

namespace App\Services\Products;

use App\Models\Product;

class CheckProductStock
{
    /**
     * Check product stock 
     *
     * @param array $param
     * @return boolean
     */
    public function execute($param)
    {
        $product = Product::find($param["product_id"]);

        if ($product->available_stock == 0) {
            return false;
        }else if (($product->available_stock - (int)$param["quantity"]) < 0) {
            return false;
        }else{
            return true;
        }
    }
}

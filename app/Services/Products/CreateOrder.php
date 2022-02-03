<?php

namespace App\Services\Products;

use App\Models\OrderedProduct;

class CreateOrder
{
    /**
     * check product stock
     *
     * @var class
     */
    private $checkProductStock;

    public function __construct(CheckProductStock $checkProductStock)
    {
        $this->checkProductStock = $checkProductStock;
    }

    /**
     * Create order
     *
     * @param array $param
     * @return void
     */
    public function execute($param)
    {
        $isAvailable = $this->checkProductStock->execute($param);

        if (!$isAvailable) {
            return $isAvailable;
        }
        
        $orderedProductCreated = OrderedProduct::create($param);

        $orderedProductCreated->product->available_stock -= $param["quantity"];
        
        $orderedProductCreated->product->save();

        return $orderedProductCreated;

    }
}

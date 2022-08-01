<?php

namespace App\Common;

use Error;

class ProductChecker {
    
    /**
     * Check in the list of product contain new product or not.
     * A product is consider as new when it does not have id.
     * @param $productList is a list of product in associated array
     * @return Boolean
     */
    public function isContainNewProduct($productList) {
        if (! is_array($productList)) {
            throw new Error("Passing parameter is not an array");
        }

        foreach ($productList as $product) {
            if (!array_key_exists("id", $product) || (array_key_exists("id", $product) && $product["id"] ==NULL )) {
                return TRUE;
            }
        }

        return FALSE;
    }

    /**
     * 
     */
    public function isProductUpdated($product) {
        if (! is_array($product)) {
            throw new Error("Passing parameter is not an array");
        }

        return $product["created_at"] !== $product["updated_at"];
    }
}
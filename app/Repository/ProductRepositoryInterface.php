<?php

namespace App\Repository;


interface ProductRepositoryInterface{

    // Get All Products
    public function getAllProducts();

    //Store Product
    public function storeProduct($request);

    //Get specific Product
    public function getOneProduct($product);

    //Update Product
    public function updateProduct($request , $product);

    //Delete Product
    public function deleteProduct($product);

}

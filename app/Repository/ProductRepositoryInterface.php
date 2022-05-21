<?php

namespace App\Repository;


interface ProductRepositoryInterface{

    // Get All Products
    public function getAllProducts();

    //Store Product
    public function storeProduct($request);

    //Get One Product By ID
    public function getOneProduct($id);

    //Update Product By ID
    public function updateProduct($request , $id);

    //Delete Product By ID
    public function deleteProduct($id);

}

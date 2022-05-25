<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\ApiResponseTrait;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Repository\ProductRepositoryInterface;


class ProductsController extends Controller
{
    use ApiResponseTrait;

    protected $Product;
    public function __construct(ProductRepositoryInterface $Product){

        $this->Product = $Product;

    }

    //Get All Products
    public function index(){

        return $this->Product->getAllProducts();

    }

    //Store Products
    public function store(Request $request){

        return $this->Product->storeProduct($request);

    }

    //Get specific Product
    public function show(Product $product){

        return $this->Product->getOneProduct($product);

    }

    //Update Product
    public function update(Request $request , Product $product){

        return $this->Product->updateProduct($request , $product);

    }

    //Delete Product
    public function destroy(Product $product){

        return $this->Product->deleteProduct($product);

    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\ApiResponseTrait;
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

    //Get specific Product By ID
    public function show($id){

        return $this->Product->getOneProduct($id);

    }

    //Update One Product By ID
    public function update(Request $request , $id){

        return $this->Product->updateProduct($request , $id);

    }

    //Delete Product By ID
    public function destroy($id){

        return $this->Product->deleteProduct($id);

    }
}

<?php

namespace App\Repository;
use App\Http\Controllers\Api\ApiResponseTrait;
use App\Http\Resources\ProductsResource;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductRepository implements ProductRepositoryInterface{
    use ApiResponseTrait;

    // Get All Products
    public function getAllProducts(){

        $products = ProductsResource::collection(Product::get());
        return $this->ApiResponse($products,'Ok',200);

    }

    //Store Product
    public function storeProduct($request){

        $validator = Validator::make($request->all(), [
            'product_name' => 'required|unique:products|max:99',
            'description' => 'required',
            'image' => 'nullable|mimes:jpeg,png,jpg',
        ]);

        if ($validator->fails()) {

            return $this->ApiResponse(null,$validator->errors(),400);

        }

        else{

            $product = new Product();
            $product->product_name = $request->product_name;
            $product->description = $request->description;
            if ($request->image && $request->image->isValid()){

                //Get Random Name With Original Extension
                $file_name = $request->file('image');
                $image = rand() . '.' . $file_name->getClientOriginalExtension();

                // Move Image
                $request->image->move(public_path('Products_Image/'), $image);
                $product->image = $image;

            }
            $product->save();

            return $this->ApiResponse(new ProductsResource($product),'The Product Created!',201);

        }

    }

    //Get specific Product
    public function getOneProduct($product)
    {

        if($product){

            return $this->ApiResponse(new ProductsResource($product),'Ok',200);

        }
        return $this->ApiResponse(null,'The Product Not Found!',404);
    }

    //Update Product
    public function updateProduct($request, $product)
    {

        if(!$product){

            return $this->ApiResponse(null,'The Product Not Found!',404);

        }

        $validator = Validator::make($request->all(), [
            'product_name' => 'required|max:99|unique:products,product_name,'. $product->id .',id',
            'description' => 'required',
            'image' => 'nullable|mimes:jpeg,png,jpg',
        ]);

        if ($validator->fails()) {

            return $this->ApiResponse(null,$validator->errors(),400);

        }

        else{

            $product->product_name = $request->product_name;
            $product->description = $request->description;

            if ($request->image && $request->image->isValid()){

                //Delete Old Image
                Storage::disk('public_uploads')->delete("$product->image");

                //Get Random Name With Original Extension
                $file_name = $request->file('image');
                $image = rand() . '.' . $file_name->getClientOriginalExtension();
                $product->image = $image;

                // Move Image
                $request->image->move(public_path('Products_Image/'), $image);

            }
            $product->update();

            return $this->ApiResponse(new ProductsResource($product),'The Product Updated!',201);

        }
    }

    //Delete Product
    public function deleteProduct($product)
    {

        if(!$product){

            return $this->ApiResponse(null,'The Product Not Found!',404);

        }

        $product->delete();
        //Delete Image From Storage
        Storage::disk('public_uploads')->delete("$product->image");

        return $this->ApiResponse(new ProductsResource($product),'The Product Deleted!',201);

    }

}

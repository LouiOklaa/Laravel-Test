<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ProductApiTest extends TestCase
{
    use WithoutMiddleware;
    use RefreshDatabase;

    /**
     * A basic functional test example.
     *
     * @return void
     */
    //Get All Product Test
    public function test_can_get_all_products()
    {

        $this->json('GET', "api/products")->assertStatus(200);

    }

    //Get One Product Test
    public function test_can_get_one_product()
    {

        $product = Product::factory()->make();
        $product->save();

        $this->json('GET', "api/products/$product->id")->assertStatus(200);

    }

    //Create Product Test
    public function test_can_create_product()
    {

        $Data = [

            'product_name' => 'First Product',
            'description' => 'First Product Description',
            'image'=> UploadedFile::fake()->image('avatar.jpg'),

        ];

        $this->json('POST', "api/products/create" ,$Data)->assertStatus(201);

    }

    //Update Product Test
    public function test_can_update_product()
    {

        $product = Product::factory()->make();
        $product->save();

        $UpdatedData = [

            'product_name' => 'product update',
            'description' => 'product description update',
            'image'=> UploadedFile::fake()->image('avatar.jpg'),

        ];

        $this->json('POST', "api/products/update/$product->id" , $UpdatedData)->assertStatus(201);

    }

    //Delete Product Test
    public function test_can_delete_product()
    {

        $product = Product::factory()->make();
        $product->save();

        $this->json('POST', "api/products/destroy/$product->id" , [$product])->assertStatus(201);

    }

}

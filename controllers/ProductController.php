<?php

class ProductController extends Controller
{
    public function getAllProduct()
    {
        $this->model("product");
        $products = $this->product->findAll();

        $this->ok($products);
    }

    public function getProductById($id)
    {
        $this->model("product");
        $products = $this->product->findById($id);

        $this->ok($products);
    }

    public function getAllProductByUserId($userId)
    {
        $this->model("product");
        $products = $this->product->findByUserId($userId);

        $this->ok($products);
    }

    public function createProduct()
    {
        $request = file_get_contents("php://input");
        $body = json_decode($request, true);

        $data = [
            'name' => $body['name'],
            'price' => $body['price'],
            'photo_url' => $body['photo_url'],
            'user_id' => $body['user_id'],
        ];

        $this->model('product');
        $result = $this->product->save($data);

        $this->ok($result);
    }
}
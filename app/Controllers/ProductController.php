<?php

namespace App\Controllers;

use App\Repository\ProductRepository;
use Libs\Controller;

class ProductController extends Controller
{

    private $productRepository;

    public function __construct()
    {
        $this->productRepository = new ProductRepository();
    }

    public function getAllProduct()
    {
        $products = $this->productRepository->findAll();
        $this->ok($products);
    }

    public function getProductById($id)
    {
        $products = $this->productRepository->findById($id);
        $this->ok($products);
    }

    public function getAllProductByUserId($userId)
    {
        $products = $this->productRepository->findByUserId($userId);
        $this->ok($products);
    }

    public function createProduct()
    {
        $targetDir = 'public/';
        $targetFile = $targetDir . basename($_FILES["photo"]["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $extensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($imageFileType, $extensions)) {
            if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile)) {
                $data = [
                    'name' => $_POST['name'],
                    'price' => $_POST['price'],
                    'description' => $_POST['description'],
                    'photo' => basename($_FILES["photo"]["name"])
                ];

                $data = $this->productRepository->save($data);
                $this->ok($data);
            }
        }
    }

    public function updateProduct($id)
    {
        if ($_FILES['photo']['size'] == 0) {
            $data = [
                'id' => $id,
                'name' => $_POST['name'],
                'price' => $_POST['price'],
                'description' => $_POST['description'],
            ];

            $data = $this->productRepository->updateWithoutPhoto($data);
            $this->ok($data);
        } else {
            $targetDir = 'public/';
            $targetFile = $targetDir . basename($_FILES["photo"]["name"]);
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $extensions = ['jpg', 'jpeg', 'png', 'gif'];
            if (in_array($imageFileType, $extensions)) {
                if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile)) {
                    $data = [
                        'id' => $id,
                        'name' => $_POST['name'],
                        'price' => $_POST['price'],
                        'description' => $_POST['description'],
                        'photo' => basename($_FILES["photo"]["name"])
                    ];

                    $data = $this->productRepository->update($data);
                    $this->ok($data);
                }
            }
        }
    }

    public function deleteProduct($id)
    {
        $validate = $this->productRepository->findById($id);
        if (count($validate) === 0) {
            $this->badRequest([
                'id' => 'Id ' . $id . ' Not Found'
            ]);
        } else {
            $this->productRepository->delete($id);
            $this->ok(null);
        }
    }
}
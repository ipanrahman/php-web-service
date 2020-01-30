<?php

namespace App\Controllers;

use Libs\Controller;
use App\Models\User;

class UserController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = new User();
    }

    public function index()
    {
        $users = $this->model->findAll();

        $this->ok($users);
    }

    public function getUserById($id)
    {
        $this->model('user');
        $user = $this->user->findById($id);

        $this->ok($user);
    }

    public function createUser()
    {
        $request = file_get_contents("php://input");
        $body = json_decode($request, true);

        $data = [
            'first_name' => $body['first_name'],
            'last_name' => $body['last_name'],
            'gender' => $body['gender'],
            'birth_date' => $body['birth_date'],
            'place_of_birth' => $body['place_of_birth'],
            'email' => $body['email'],
            'phone_number' => $body['phone_number']
        ];

        $this->model('user');
        $result = $this->user->save($data);

        $this->ok($result);
    }

    public function updateUser($id)
    {
        $request = file_get_contents("php://input");
        $body = json_decode($request, true);

        $data = [
            'id' => $id,
            'first_name' => $body['first_name'],
            'last_name' => $body['last_name'],
            'gender' => $body['gender'],
            'birth_date' => $body['birth_date'],
            'place_of_birth' => $body['place_of_birth'],
            'email' => $body['email'],
            'phone_number' => $body['phone_number']
        ];

        $this->model('user');
        $result = $this->user->update($data);

        $this->ok($result);
    }

    public function deleteUser($id)
    {
        $this->model('user');
        $validate = $this->user->findById($id);
        if (count($validate) === 0) {
            $this->badRequest([
                'id' => 'Id ' . $id . ' Not Found'
            ]);
        } else {
            $this->user->delete($id);
            $this->ok(null);
        }
    }

}
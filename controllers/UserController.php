<?php

class UserController extends Controller
{
    public function index()
    {
        $this->model('user');
        $users = $this->user->findAll();

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
        $data = [
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name'],
            'email' => $_POST['email'],
            'phone_number' => $_POST['phone_number']
        ];

        $this->model('user');
        $result = $this->user->save($data);

        $this->ok($result);
    }

}
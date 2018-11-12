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

    public function createUser($data)
    {

    }

}
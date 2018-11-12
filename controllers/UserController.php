<?php

class UserController extends Controller
{
    public function index()
    {
        $this->model('user');
        $users = $this->user->findAll();

        header('Content-type:application/json');

        echo json_encode($users);
    }

    public function getUserById($id)
    {
        $this->model('user');
        $user = $this->user->findById($id);

        $this->ok($user);
    }

}
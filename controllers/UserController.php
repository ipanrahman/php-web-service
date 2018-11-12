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
        $request = file_get_contents("php://input");
        $body = json_decode($request, true);

        $data = [
            'first_name' => $body['first_name'],
            'last_name' => $body['last_name'],
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
            $this->notFound('User Id' . $id . ' Not Found');
        } else {
            $this->user->delete($id);
            $this->ok(null);
        }
    }

}
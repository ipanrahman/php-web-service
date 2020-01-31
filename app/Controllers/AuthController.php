<?php

namespace App\Controllers;

use App\Models\User;
use App\Repository\UserRepository;
use Libs\Bcrypt;
use Libs\Controller;
use Carbon\Carbon;

class AuthController extends Controller
{
    private $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function login()
    {
        $request = file_get_contents("php://input");
        $body = json_decode($request, true);

        $username = $body['username'];
        $password = $body['password'];

        if ($username == 'admin' && $password == 'admin') {
            $result = [
                'access_token' => base64_encode(Carbon::now())
            ];
            $this->ok($result);
        }
    }

    public function register()
    {
        $request = file_get_contents("php://input");
        $body = json_decode($request, true);

        $password = Bcrypt::hashPassword($body['password'], 10);

        $user = new User();
        $user->setName($body['name']);
        $user->setPhoneNumber($body['phone_number']);
        $user->setEmail($body['email']);
        $user->setPassword($password);
        $user = $this->userRepository->save($user);
        return $this->ok($user);
    }
}
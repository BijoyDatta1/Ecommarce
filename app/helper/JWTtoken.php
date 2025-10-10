<?php

namespace App\helper;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTtoken
{
    public static function createToken($id,$email,$role,$time = 60){
        $key = env('JWT_KEY');
        $payload = [
            'iss' => 'laravel-token',
            'iat' => time(),
            'exp' => time() + (60 * $time),
            'user_id' => $id,
            'email' => $email,
            'role' => $role,
        ];
        $token = JWT::encode($payload, $key, 'HS256');
        return $token;
    }
    public static function varifyToken($token){
        try {
            if ($token != null) {
                $key = env('JWT_KEY');
                $result = JWT::decode($token,new Key($key, 'HS256'));
                return $result;
            }else{
                return 'Unauthorized';
            }
        }catch (\Exception $e){
            return 'Unauthorized';
        }

    }
}

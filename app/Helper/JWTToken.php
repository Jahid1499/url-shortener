<?php

namespace App\Helper;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTToken
{
    public static function CreateToken($userEmail,$userID):string
    {
        $key =env('JWT_KEY');
        $payload=[
            'iss'=>'user-token',
            'iat'=>time(),
            'exp'=>time()+60*60,
            'email'=>$userEmail,
            'id'=>$userID
        ];
        return JWT::encode($payload,$key,'HS256');
    }

    public static function VerifyToken($token):string|object
    {
        try {
            if($token==null){
                return 'unauthorised';
            }
            else{
                $key =env('JWT_KEY');
                $decode=JWT::decode($token,new Key($key,'HS256'));
                return $decode;
            }
        }
        catch (Exception $e){
            return 'unauthorised';
        }
    }
}

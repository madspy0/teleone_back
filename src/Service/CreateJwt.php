<?php


namespace App\Service;

use Ahc\Jwt\JWT;

class CreateJwt
{
    public function newToken($username): string
    {
        $jwt = new JWT('secret', 'HS256', 3600, 10);
        $header = [
            "typ" => "JWT",
            "alg" => "HS256"
        ];
        $payload = [
            'uid' => 1,
            'aud' => 'http://site.com',
            'scopes' => [$username],
            'iss' => 'http://api.mysite.com',
        ];
        $data = rtrim(strtr(base64_encode(json_encode($header)), '+/', '-_'), '=');
        $token = $jwt->encode((array)$data); //. "." . base64_encode(json_encode($payload)));
        return ($token);
    }

}
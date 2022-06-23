<?php

namespace App\Service;

use Ahc\Jwt\JWT;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

class CreateJwt implements LoggerAwareInterface
{
    private $logger;

    public function newToken($username): string
    {
        $jwt = new JWT('!ChangeMe!', 'HS256', 60, 10);
        $header = [
            "typ" => "JWT",
            "alg" => "HS256"
        ];
//        $payload = [
//            'uid' => 1,
//            'aud' => 'http://site.com',
//            'scopes' => [$username],
//            'iss' => 'http://api.mysite.com',
//        ];
        $payload = [
            "mercure" => [
                "publish" => [
                    "*"
                ],
                "subscribe" => [
                    explode("@", $username)[0],
                    "{scheme}://{+host}/demo/books/{id}.jsonld",
                    "/.well-known/mercure/subscriptions{/topic}{/subscriber}"
                ],
                "payload" => [
                    "user" => $username,
                    "remoteAddr" => "127.0.0.1"
                ]
            ]
        ];
        $token = $jwt->encode($payload, $header);
        return ($token);
    }

    public function getEmail($token)
    {
        try {
            $payload = (new JWT('!ChangeMe!', 'HS256', 60, 10))->decode($token);
            return ($payload['mercure']->payload->user);
        } catch (\Exception $e) {
            $this->logger->info($e->getMessage() . ' ' . $e->getCode());
        }
    }

    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }
}

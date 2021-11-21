<?php declare(strict_types=1);

namespace App\Http\Services\Auth;

use App\Exceptions\InvalidTokenException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class TokenService
{
    const METHOD = "AES-256-CBC";
    const SECRET_KEY =  'Laboras4741148551';
    const SECRET_IV = "laboras4.";

    public function encryptToken(string $data): string
    {
        $key = self::SECRET_KEY;
        $payload = array(
            "data" => $data,
        );

        /**
         * IMPORTANT:
         * You must specify supported algorithms for your application. See
         * https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40
         * for a list of spec-compliant algorithms.
         */
        $jwt = JWT::encode($payload, $key, 'HS256');

        return $jwt;
    }

    public function decryptToken(string $token): array
    {
        try {
            $decoded = JWT::decode($token, new Key(self::SECRET_KEY, 'HS256'));
        } catch (\Exception $e) {
            throw new InvalidTokenException("Provided token is not valid");
        }

        $decodedString = $decoded;

        $data = json_decode($decodedString->data, true);
        if (!$data) {
            throw new InvalidTokenException("Provided token is not valid");
        }

        if ($data['expire'] < time()) {
            throw new InvalidTokenException("Token expired");
        }

        return $data;
    }
}

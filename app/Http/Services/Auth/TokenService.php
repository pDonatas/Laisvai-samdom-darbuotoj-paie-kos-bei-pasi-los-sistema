<?php declare(strict_types=1);

namespace App\Http\Services\Auth;

use App\Exceptions\InvalidTokenException;

class TokenService
{
    protected const METHOD = "AES-256-CBC";
    protected const SECRET_KEY =  'Laboras4741148551';
    protected const SECRET_IV = "laboras4.";

    public function encryptToken(string $data): string
    {
        $key = hash('sha256', self::SECRET_KEY);
        $iv = substr(hash('sha256', self::SECRET_IV), 0, 16);
        $output = openssl_encrypt($data, self::METHOD, $key, 0, $iv);

        return base64_encode($output);
    }

    public function decryptToken(string $token): array
    {
        $key = hash('sha256', self::SECRET_KEY);
        $iv = substr(hash('sha256', self::SECRET_IV), 0, 16); // sha256 is hash_hmac_algo

        $decodedString = openssl_decrypt(base64_decode($token), self::METHOD, $key, 0, $iv);

        if (!$decodedString) {
            throw new InvalidTokenException("Provided token is not valid");
        }

        $data = json_decode($decodedString, true);
        if (!$data) {
            throw new InvalidTokenException("Provided token is not valid");
        }

        if ($data['expire'] < time()) {
            throw new InvalidTokenException("Token expired");
        }

        return $data;
    }
}

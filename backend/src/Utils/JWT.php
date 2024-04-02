<?php

namespace Utils;

use Exception;
use Exceptions\HttpExceptions\InvalidTokenException;

class JWT
{
    /**
     * Encode a payload into a JWT token
     * @param array $payload The payload to encode
     * @param string $secretKey The secret key to use to encode the JWT
     * @return string The JWT token
     */
    public static function encode($payload, $secretKey): string
    {
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        $payload = json_encode($payload);

        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $secretKey, true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        return $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
    }
    /**
     * Decode a JWT token
     * @param string $jwt The JWT token to decode
     * @param string $secretKey The secret key to use to decode the JWT
     * @return array The decoded payload
     * @throws InvalidTokenException
     */
    public static function decode($jwt, $secretKey)
    {
        [$header, $payload, $signature] = explode('.', $jwt);

        $base64UrlHeader = base64_decode(str_replace(['-', '_'], ['+', '/'], $header));
        $base64UrlPayload = base64_decode(str_replace(['-', '_'], ['+', '/'], $payload));
        $base64UrlSignature = base64_decode(str_replace(['-', '_'], ['+', '/'], $signature));

        $payloadArray = json_decode($base64UrlPayload, true);

        $valid = hash_hmac('sha256', $header . "." . $payload, $secretKey, true);
        $validBase64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($valid));

        if ($signature !== $validBase64UrlSignature) { // This can happen if the signature is invalid, that is, if the secret key is different from the one used to encode the JWT
            throw new InvalidTokenException();
        }

        return $payloadArray;
    }
}
<?php

namespace Authentication;

use Database\TableManagers\UserTableManager;
use Exception;
use Exceptions\HttpExceptions\HttpException;
use Exceptions\HttpExceptions\InvalidTokenException;
use Models\User;
use Utils\JWT;

class AuthKeyGenerator
{
    public static function encodeJWK($user, $exp = 3600): string
    {
        $config = include __DIR__ . '/../config/keys.php';
        $secretKey = $config['secret_key'];

        $payload = array(
            "userId" => $user->getId(),
            "username" => $user->getUsername(),
            "email" => $user->getEmail(),
            "iat" => time(),
            "exp" => time() + $exp

        );

        return JWT::encode($payload, $secretKey);
    }

    /**
     * Decodes a JWK token.
     *
     * @param string $jwk The JWK token to decode.
     * @return array The decoded JWK token.
     * @throws HttpException
     */
    public static function decodeJWK(string $jwk): array
    {
        $config = include __DIR__ . '/../config/keys.php';
        $secretKey = $config['secret_key'];

        try {
            $decoded = JWT::decode($jwk, $secretKey);

            return (array)$decoded;
        } catch (Exception $e) {
            throw new InvalidTokenException();
        }
    }



    /**
     * @throws HttpException
     * @throws InvalidTokenException
     */
    public static function getUserFromToken(string $jwk): User
    {
        $decoded = self::decodeJWK($jwk);
        $userId = $decoded['userId'];
        $username = $decoded['username'];
        $email = $decoded['email'];

        // Fetch the user from the database
        $userTableManager = UserTableManager::GetInstance();
        $user = $userTableManager::getUserById($userId);

        // If the user was not found, throw an exception
        if ($user === null || $user->getUsername() !== $username || $user->getEmail() !== $email) {
            throw new InvalidTokenException();
        }
        if (time() > $decoded['exp']) {
            throw new InvalidTokenException("Token expired");
        }


        return $user;
    }


}
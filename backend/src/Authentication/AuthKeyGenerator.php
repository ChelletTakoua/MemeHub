<?php

namespace Authentication;

use Database\TableManagers\UserTableManager;
use Exception;
use Exceptions\HttpExceptions\ExpiredTokenException;
use Exceptions\HttpExceptions\HttpException;
use Exceptions\HttpExceptions\InvalidTokenException;
use Models\User;
use Utils\JWT;

class AuthKeyGenerator
{
    /**
     * Encodes a JWK token.
     * @param User $user The user to encode in the JWK token.
     * @param int $exp The expiration time of the token in seconds.
     * @return string The encoded JWK token.
     */
    public static function encodeJWK(User $user, int $exp = 3600): string
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
     * Fetches the user from the database using the JWK token.
     * @throws HttpException
     * @throws InvalidTokenException
     */
    public static function getUserFromToken(string $jwk, bool $expires = true): User
    {
        $decoded = self::decodeJWK($jwk);
        $userId = $decoded['userId'];
        $username = $decoded['username'];
        $email = $decoded['email'];
        $userTableManager = UserTableManager::GetInstance();
        $user = $userTableManager::getUserById($userId);
        if ($user === null || $user->getUsername() !== $username || $user->getEmail() !== $email) {
            throw new InvalidTokenException();
        }
        if ($expires && $decoded['exp'] < time()) {
            throw new ExpiredTokenException();
        }
        return $user;
    }
}

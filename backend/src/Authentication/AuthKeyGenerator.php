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
        // Include the keys configuration file and retrieve the secret key
        $config = include __DIR__ . '/../config/keys.php';
        $secretKey = $config['secret_key'];
        // Create a payload array containing the user's ID, username, email, the current time, and the expiration time
        $payload = array(
            "userId" => $user->getId(),
            "username" => $user->getUsername(),
            "email" => $user->getEmail(),
            "iat" => time(),
            "exp" => time() + $exp
        );
        // Encode the payload into a JWK using the secret key and return the JWK
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
        // Include the keys configuration file and retrieve the secret key
        $config = include __DIR__ . '/../config/keys.php';
        $secretKey = $config['secret_key'];
        try {
            // Try to decode the JWK using the secret key
            $decoded = JWT::decode($jwk, $secretKey);
            // If the decoding is successful, return the decoded JWK as an array
            return (array)$decoded;
        } catch (Exception $e) {
            // If the decoding fails, throw an InvalidTokenException
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
        // Decode the JWK into an array
        $decoded = self::decodeJWK($jwk);
        // Extract the user ID, username, and email from the decoded JWK
        $userId = $decoded['userId'];
        $username = $decoded['username'];
        $email = $decoded['email'];
        // Fetch the user from the database
        $userTableManager = UserTableManager::GetInstance();
        $user = $userTableManager::getUserById($userId);
        // If the user was not found, or the username or email does not match the one in the JWK, throw an InvalidTokenException
        if ($user === null || $user->getUsername() !== $username || $user->getEmail() !== $email) {
            throw new InvalidTokenException();
        }
        // If the token has expired, throw an ExpiredTokenException
        if ($expires && $decoded['exp'] < time()) {
            throw new ExpiredTokenException();
        }
        // Return the user
        return $user;
    }
}

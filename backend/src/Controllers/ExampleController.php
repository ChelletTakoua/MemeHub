<?php

namespace Controllers;

require_once '../src/Exceptions/HttpExceptions/UnauthorizedException.php';
require_once '../src/Exceptions/HttpExceptions/HttpException.php';
use Exception;
use Exceptions\HttpExceptions\HttpException;
use Exceptions\HttpExceptions\UnauthorizedException;

class ExampleController
{

    /**
     * @throws HttpException
     */
    public function example($exampleParam)
    {
        // Handle GET request

        $post = [
            "id" => 1,
            "title" => "Sample Post",
            "content" => "This is a sample post content.",
            "params" => $exampleParam,
        ];

        header('Content-Type: application/json');
        throw new HttpException("Unauthorized", 401);
        // Set the Content-Type header


        // Convert the post data to JSON
        //echo json_encode($post);

        // Handle GET request

    }
}
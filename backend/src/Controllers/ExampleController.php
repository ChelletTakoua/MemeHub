<?php

namespace Controllers;

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
        header('Content-Type: application/json');


        $meme = [
            "id" => 1,
            "title" => "Sample Post",
            "content" => "This is a sample post content.",
            "params" => $exampleParam,
        ];
        throw new UnauthorizedException();



        echo json_encode($meme);


        // Set the Content-Type header


        // Convert the post data to JSON
        echo json_encode($post);

        // Handle GET request

    }
}
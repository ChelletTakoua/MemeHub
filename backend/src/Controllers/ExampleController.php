<?php

namespace Controllers;

use Authentication\Auth;
use Exception;
use Exceptions\HttpExceptions\HttpException;
use Exceptions\HttpExceptions\UnauthorizedException;
use Utils\ApiResponseBuilder;

class ExampleController
{

public function referenceMethod()
    {
        //Auth::requireAdminAccess(); //if only admin can access this method
        //Auth::requireLogin(); //if only logged in users can access this method
        header('Content-Type: application/json'); // if you want to return json

        // your code logic goes here

        $exempleObjectToReturn = [
            "id" => 1,
            "title" => "Sample Post",
            "content" => "This is a sample post content."
        ];


        $response = ApiResponseBuilder::buildSuccessResponse($exempleObjectToReturn); // to build the response
        echo json_encode($response); // to send the response

        // any error thrown and not caught will be handled by the error handler
        // HttpException is a custom exception that can be thrown to return a specific HTTP status code
        // you don't need to manually set the status code, it will be done by the error handler
        // exemple:
        //      throw new HttpException('Not Found', 404);
        //  or a more specific exception:
        //      throw new UnauthorizedException();
        // you can create your own exceptions by extending the HttpException class and setting the status code (and message) in the constructor
    }

    public function example($exampleParam)
    {
        Auth::requireAdminAccess();
        header('Content-Type: application/json');


        $meme = [
            "id" => 1,
            "title" => "Sample Post",
            "content" => "This is a sample post content.",
            "params" => $exampleParam,
        ];


        echo json_encode($meme);

    }
}
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

        // your code logic goes here

        $exempleObjectToReturn = [
            "id" => 1,
            "title" => "Sample Post",
            "content" => "This is a sample post content."
        ];
        //throw new UnauthorizedException();


        $response = ApiResponseBuilder::buildSuccessResponse($exempleObjectToReturn); // to build the response
        echo json_encode($response); // to send the response

    }

    public function exampleWithParams($exampleParam)
    {
        Auth::requireAdminAccess();
        header('Content-Type: application/json');


        $meme = [
            "id" => 1,
            "title" => "Sample Post",
            "content" => "This is a sample post content.",
            "params" => $exampleParam,
        ];


        $response = ApiResponseBuilder::buildSuccessResponse($meme);
        echo json_encode($response);

    }
}
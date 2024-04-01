<?php

namespace Controllers;

use Database\TableManagers\MemeTableManager;
use Database\TableManagers\LikeTableManager;
use Database\TableManagers\ReportTableManager;
use Database\TableManagers\TemplateTableManager;
use Database\TableManagers\TextBlockTableManager;
use Utils\RequestHandler;
use Utils\ApiResponseBuilder;
use Exceptions\HttpExceptions\NotFoundException;
use Exceptions\HttpExceptions\BadRequestException;
use Exceptions\HttpExceptions\NotLoggedInException;
use Models\Meme;
use Models\Report;
use Exceptions\HttpExceptions\Exception;

class MemeController
{
    /**
     * Function: getAllMemes
     *
     * Retrieves all memes from the database, processes each meme to create an associative array of meme data, and outputs a JSON response.
     *
     * @return void Outputs a JSON response containing an array of all memes' data under the "memes" key.
     * @throws BadRequestException If there is an error while retrieving a meme's data from the database, a BadRequestException with a 500 status code is thrown.
     */
    public function getAllMemes()
    {
        // Retrieve all memes from the database
        $memes = MemeTableManager::getMeme();
        $memesArray = [];
        try {
                
                // Iterate over each meme
                foreach ($memes as $meme) {
                    // Retrieve likes for the meme
                    $likes = LikeTableManager::getLikeByMemeId($meme->getId());
                    // Create an array to store like IDs and user IDs
                    $likeData = [];
                    foreach ($likes as $like) {
                        $likeData[] = [
                            "id" => $like->getId(),
                            "user_id" => $like->getUserId()
                        ];
                    }
                // Create an associative array with the meme's data
                $memeData = [
                    "id" => $meme->getId(),
                    "url" => (TemplateTableManager::getTemplateById($meme->getTemplateId()))->getUrl(),
                    "user_id" => $meme->getUserId(),
                    "nb_likes" => $likeData,
                    "creation_date" => $meme->getCreationDate(),
                    "text_blocks" => TextBlockTableManager::getTextBlockByMemeId($meme->getId()),
                    "result_img" => $meme->getResultImg(),
                ];
                // Add the meme's data to the memes array
                $memesArray[] = $memeData;
            }
                
                
            } catch (\Exception $e) {
                // If there's an error while retrieving the meme's data, throw a BadRequestException
                throw new BadRequestException('Failed to get meme from the database', 500);
            }
        // Build a success response with the memes array
        $response = ApiResponseBuilder::buildSuccessResponse(["memes" => $memesArray]);
        echo json_encode($response);
    }

    /**
     * The getMemeById function retrieves a meme from the database by its ID, processes the meme to create an associative array of meme data, and returns a JSON response.
     *
     * @param int $id The ID of the meme to retrieve.
     * @return void This function does not return a value; it directly outputs the JSON response.
     * @throws BadRequestException If there is an error while retrieving the meme's data from the database, a BadRequestException is thrown with a 500 status code.
     * @throws NotFoundException If no meme with the given ID is found in the database, a NotFoundException is thrown.
     */
    public function getMemeById($id)
    {
        $meme = MemeTableManager::getMemeById($id);
        if(!isset($meme)) {
            throw new NotFoundException("Meme not found");
        }
        $response = ApiResponseBuilder::buildSuccessResponse(["meme" => $meme]);
        echo json_encode($response);
    }

    /**
     * The getUserMemes function retrieves all memes from the database associated with a specific user ID, processes each meme to create an associative array of meme data, and returns a JSON response.
     *
     * @param int $id The ID of the user whose memes are to be retrieved.
     * @return void This function does not return a value; it directly outputs the JSON response.
     * @throws BadRequestException If there is an error while retrieving a meme's data from the database, a BadRequestException is thrown with a 500 status code.
     */
    public function getUserMemes($id)
    {
        // Retrieve all memes from the database associated with the user ID
        $memes = MemeTableManager::getMemeByUserId($id);
        $memesArray = [];
            try {
                foreach ($memes as $meme) {
                    // Retrieve likes for the meme
                    $likes = LikeTableManager::getLikeByMemeId($meme->getId());
                    // Create an array to store like IDs and user IDs
                    $likeData = [];
                    foreach ($likes as $like) {
                        $likeData[] = [
                            "id" => $like->getId(),
                            "user_id" => $like->getUserId()
                        ];
                    }
                // Create an associative array with the meme's data
                $memeData = [
                    "id" => $meme->getId(),
                    "url" => (TemplateTableManager::getTemplateById($meme->getTemplateId()))->getUrl(),
                    "user_id" => $meme->getUserId(),
                    "nb_likes" => $likeData,
                    "creation_date" => $meme->getCreationDate(),
                    "text_blocks" => TextBlockTableManager::getTextBlockByMemeId($meme->getId()),
                    "result_img" => $meme->getResultImg(),
                ];
                // Add the meme's data to the memes array
                $memesArray[] = $memeData;
            }
                
            } catch (\Exception $e) {
                // If there's an error while retrieving the meme's data, throw a BadRequestException
                throw new BadRequestException('Failed to get meme from the database', 500);
            }
        
        // Build a success response with the memes array
        $response = ApiResponseBuilder::buildSuccessResponse(["memes" => $memesArray]);
        // Encode the response as JSON and output it
        echo json_encode($response);
    }


    /**
     * The addMeme function attempts to add a new meme to the database. It retrieves the request body as JSON, checks if it contains a 'template_id' key and if the user is logged in, and then tries to add the meme to the database. If successful, it returns a JSON response with the new meme's data.
     *
     * @return void This function does not return a value; it directly outputs the JSON response.
     * @throws BadRequestException If the request body is invalid or if there is an error while adding the meme to the database, a BadRequestException is thrown with a 400 or 500 status code, respectively.
     * @throws NotLoggedInException If the user is not logged in, a NotLoggedInException is thrown.
     */
    public function addMeme()
    {
        // Retrieve the JSON request body
        $requestBody = RequestHandler::getJsonRequestBody();
        // Check if the request body is not empty, contains a 'template_id' key 'result_img'  attribute  and an array containing the textBlocks, and if the user is logged in
        if (!empty($requestBody) && isset($requestBody['template_id']) && isset($_SESSION['user_id']) && isset($requestBody['text_blocks']) && isset($requestBody['result_img'])) {
            // Try to add the meme to the database
            $meme = MemeTableManager::addMeme($requestBody['template_id'], "", $_SESSION['user_id'],$requestBody['result_img']);
            //add the text blocks

            foreach ($requestBody['text_blocks'] as $textBlock) {
                $textBlock=TextBlockTableManager::addTextBlock($textBlock['text'], $textBlock['x'], $textBlock['y'], $textBlock['font_size'], $meme->getId());
            }
            // Check if the meme was successfully added
            if (!empty($meme)) {
                // Build a success response with the new meme's data
                $response = ApiResponseBuilder::buildSuccessResponse();
                // Encode the response as JSON and output it
                echo json_encode($response);
            } else {
                // If the meme was not added successfully, throw a BadRequestException
                throw new BadRequestException('Failed to add meme to the database', 500);
            }
        } else if (!isset($_SESSION['user_id'])) {
            // If the user is not logged in, throw a NotLoggedInException
            throw new NotLoggedInException('User not logged in');
        } else {
            // If the request body is invalid, throw a BadRequestException
            throw new BadRequestException('Invalid request body', 400);
        }
    }
    public function modifyMeme($id)
    {
        // Retrieve the JSON request body
        $requestBody = RequestHandler::getJsonRequestBody();
        // Check if the request body is not empty if the user is logged in
        if (!empty($requestBody) && isset($_SESSION['user_id'])&& isset($requestBody['result_img']) && isset($requestBody['text_blocks'])){
            //add the text blocks
            TextBlockTableManager::deleteTextBlockByMemeId($id);
            foreach ($requestBody['text_blocks'] as $textBlock) {
                $textBlock=TextBlockTableManager::addTextBlock($textBlock['text'], $textBlock['x'], $textBlock['y'], $textBlock['font_size'], $id);
            }
            // Try to update the meme to the database
            $meme = MemeTableManager::updateMemeResultImg($id,$requestBody['result_img'] );
            
            // Check if the meme was successfully added
            if (!empty($meme)) {
                // Build a success response with the new meme's data
                $response = ApiResponseBuilder::buildSuccessResponse();
                // Encode the response as JSON and output it
                echo json_encode($response);
            } else {
                // If the meme was not mofified successfully, throw a BadRequestException
                throw new BadRequestException('Failed to modify meme to the database', 500);
            }
        } else if (!isset($_SESSION['user_id'])) {
            // If the user is not logged in, throw a NotLoggedInException
            throw new NotLoggedInException('User not logged in');
        } else {
            // If the request body is invalid, throw a BadRequestException
            throw new BadRequestException('Invalid request body', 400);
        }
    }

    /**
     * The likeMeme function attempts to add a like to a meme in the database. It checks if the user is logged in, and then tries to add the like to the database. If successful, it returns a JSON response with the new like's data.
     *
     * @param int $id The ID of the meme to be liked.
     * @return void This function does not return a value; it directly outputs the JSON response.
     * @throws BadRequestException If there is an error while adding the like to the database, a BadRequestException is thrown with a 500 status code.
     * @throws NotLoggedInException If the user is not logged in, a NotLoggedInException is thrown.
     */
    public function likeMeme($id)
    {
        // Check if the user is logged in
        if (isset($_SESSION['user_id'])) {
            // Try to add a like to the meme in the database
            $like = LikeTableManager::addLike($id, $_SESSION['user_id']);
            // Check if the like was successfully added
            if (!empty($like)) {
                // Build a success response with the new like's data
                $response = ApiResponseBuilder::buildSuccessResponse(["like" => $like]);
                // Encode the response as JSON and output it
                echo json_encode($response);
            } else {
                // If the like was not added successfully, throw a BadRequestException
                throw new BadRequestException('Failed to add like to the database', 500);
            }
        } else {
            // If the user is not logged in, throw a NotLoggedInException
            throw new NotLoggedInException('User not logged in');
        }
    }

    /**
     * The dislikeMeme function attempts to remove a like from a meme in the database. It checks if the user is logged in, and then tries to remove the like from the database. If successful, it returns a JSON response.
     *
     * @param int $id The ID of the meme from which the like is to be removed.
     * @return void This function does not return a value; it directly outputs the JSON response.
     * @throws BadRequestException If there is an error while removing the like from the database, a BadRequestException is thrown with a 500 status code.
     * @throws NotLoggedInException If the user is not logged in, a NotLoggedInException is thrown.
     */
    public function dislikeMeme($id)
    {
        // Check if the user is logged in
        if (isset($_SESSION['user_id'])) {
            // Try to remove a like from the meme in the database
            $dislike = LikeTableManager::deleteLikeByMemeIdAndUserId($id, $_SESSION['user_id']);
            // Check if the like was successfully removed
            if (!empty($dislike)) {
                // Build a success response
                $response = ApiResponseBuilder::buildSuccessResponse([]);
                // Encode the response as JSON and output it
                echo json_encode($response);
            } else {
                // If the like was not removed successfully, throw a BadRequestException
                throw new BadRequestException('Failed to remove like from the database', 500);
            }
        } else {
            // If the user is not logged in, throw a NotLoggedInException
            throw new NotLoggedInException('User not logged in');
        }
    }

    /**
     * The reportMeme function attempts to report a meme in the database. It retrieves the request body as JSON, checks if it contains a 'report_reason' key and if the user is logged in, and then tries to add the report to the database. If successful, it returns a JSON response with the new report's data.
     *
     * @param int $id The ID of the meme to be reported.
     * @return void This function does not return a value; it directly outputs the JSON response.
     * @throws BadRequestException If the request body is invalid or if there is an error while adding the report to the database, a BadRequestException is thrown with a 400 or 500 status code, respectively.
     * @throws NotLoggedInException If the user is not logged in, a NotLoggedInException is thrown.
     */
    public function reportMeme($id)
    {
        // Retrieve the JSON request body
        $requestBody = RequestHandler::getJsonRequestBody();
        // Check if the request body is not empty, contains a 'report_reason' key, and if the user is logged in
        if (!empty($requestBody) && isset($requestBody['report_reason']) && isset($_SESSION['user_id'])) {
            // Try to add the report to the database
            $report = ReportTableManager::addReport($requestBody['report_reason'], $id, $_SESSION['user_id']);
            // Check if the report was successfully added
            if (!empty($report)) {
                // Build a success response with the new report's data
                $response = ApiResponseBuilder::buildSuccessResponse(["report" => $report]);
                // Encode the response as JSON and output it
                echo json_encode($response);
            } else {
                // If the report was not added successfully, throw a BadRequestException
                throw new BadRequestException('Failed to report meme to the database', 500);
            }
        } else if (!isset($_SESSION['user_id'])) {
            // If the user is not logged in, throw a NotLoggedInException
            throw new NotLoggedInException('User not logged in');
        } else {
            // If the request body is invalid, throw a BadRequestException
            throw new BadRequestException('Invalid request body', 400);
        }
    }

    /**
     * The deleteMeme function attempts to delete a meme from the database. It does not check if the deletion was successful, and always returns a JSON response indicating success.
     *
     * @param int $id The ID of the meme to be deleted.
     * @return void This function does not return a value; it directly outputs the JSON response.
     */
    public function deleteMeme($id)
    {
        // Delete the meme from the database
        MemeTableManager::deleteMeme($id);
        // Build a success response
        $response = ApiResponseBuilder::buildSuccessResponse([]);
        // Encode the response as JSON and output it
        echo json_encode($response);
    }
}

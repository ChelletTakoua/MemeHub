<?php

namespace Controllers;

use Authentication\Auth;
use Database\TableManagers\MemeTableManager;
use Database\TableManagers\LikeTableManager;
use Database\TableManagers\ReportTableManager;
use Database\TableManagers\TemplateTableManager;
use Database\TableManagers\TextBlockTableManager;
use Exceptions\HttpExceptions\MethodNotAllowedException;
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
        $memes = MemeTableManager::getMeme();
        usort($memes, function ($a, $b) {
            return $b->getCreationDate() <=> $a->getCreationDate();
        });

        $response = ApiResponseBuilder::buildSuccessResponse(["memes" => $memes]);

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
        if (!isset($meme)) {
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
        $memes = MemeTableManager::getMemeByUserId($id);
        usort($memes, function ($a, $b) {
            return $b->getCreationDate() <=> $a->getCreationDate();
        });

        $response = ApiResponseBuilder::buildSuccessResponse(["memes" => $memes]);
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
        $requestBody = RequestHandler::getJsonRequestBody();
        if (!isset($_SESSION['user_id'])) {
            throw new NotLoggedInException('User not logged in');
        }
        if (empty($requestBody) || !isset($requestBody['template_id']) || !isset($requestBody['text_blocks']) || !isset($requestBody['result_img'])) {
            throw new BadRequestException('Invalid request body', 400);
        }

        $meme = MemeTableManager::addMeme($requestBody['template_id'], "", $_SESSION['user_id'], $requestBody['result_img']);
        if (empty($meme)) {
            throw new BadRequestException('Failed to add meme to the database', 500);
        }

        foreach ($requestBody['text_blocks'] as $textBlock) {
            $textBlock = TextBlockTableManager::addTextBlock($textBlock['text'], $textBlock['x'], $textBlock['y'], $textBlock['font_size'], $meme->getId());
        }

        $response = ApiResponseBuilder::buildSuccessResponse();
        echo json_encode($response);
    }

    /**
     * The modifyMeme function attempts to modify a meme in the database. It retrieves the request body as JSON, checks if it contains 'result_img' and 'text_blocks' keys, and then tries to modify the meme in the database. If successful, it returns a JSON response.
     *
     * @param int $id The ID of the meme to be modified.
     * @return void This function does not return a value; it directly outputs the JSON response.
     * @throws BadRequestException If the request body is invalid or if there is an error while modifying the meme in the database, a BadRequestException is thrown with a 400 or 500 status code, respectively.
     * @throws NotLoggedInException If the user is not logged in, a NotLoggedInException is thrown.
     */
    public function modifyMeme($id)
    {
        $requestBody = RequestHandler::getJsonRequestBody();
        if (!isset($_SESSION['user_id'])) {
            throw new NotLoggedInException('User not logged in');
        }
        if (empty($requestBody) ||  !isset($requestBody['result_img']) || !isset($requestBody['text_blocks'])) {
            throw new BadRequestException('Invalid request body', 400);
        }

        TextBlockTableManager::deleteTextBlockByMemeId($id);
        foreach ($requestBody['text_blocks'] as $textBlock) {
            $textBlock = TextBlockTableManager::addTextBlock($textBlock['text'], $textBlock['x'], $textBlock['y'], $textBlock['font_size'], $id);
        }

        $meme = MemeTableManager::updateMemeResultImg($id, $requestBody['result_img']);
        if (empty($meme)) {
            throw new BadRequestException('Failed to modify meme to the database', 500);
        }

        $response = ApiResponseBuilder::buildSuccessResponse();
        echo json_encode($response);
    }

    /**
     * The likeMeme function attempts to add a like to a meme in the database. It checks if the user is logged in, and then tries to add the like to the database. If successful, it returns a JSON response with the new like's data.
     *
     * @param int $id The ID of the meme to be liked.
     * @return void This function does not return a value; it directly outputs the JSON response.
     */
    public function likeMeme($id)
    {
        try {
            $like = LikeTableManager::addLike($id, Auth::getActiveUserId());
        } catch (MethodNotAllowedException $e) {
        }

        $nbLikes = MemeTableManager::getMemeNbLikes($id);
        $isLiked = LikeTableManager::likeExistsByMemeIdAndUserId($id, Auth::GetActiveUserId());

        if (empty($like)) {
            $response = ApiResponseBuilder::buildErrorResponse('Meme already liked', 400, ["nbLikes" => $nbLikes, "liked" => $isLiked]);
        } else {
            $response = ApiResponseBuilder::buildSuccessResponse(["nbLikes" => $nbLikes, "liked" => $isLiked]);
        }
        echo json_encode($response);
    }

    /**
     * The dislikeMeme function attempts to remove a like from a meme in the database. It checks if the user is logged in, and then tries to remove the like from the database. If successful, it returns a JSON response.
     *
     * @param int $id The ID of the meme from which the like is to be removed.
     * @return void This function does not return a value; it directly outputs the JSON response.
     */
    public function dislikeMeme($id)
    {
        $dislike = LikeTableManager::deleteLikeByMemeIdAndUserId($id, $_SESSION['user_id']);

        $nbLikes = MemeTableManager::getMemeNbLikes($id);
        $isLiked = LikeTableManager::likeExistsByMemeIdAndUserId($id, Auth::GetActiveUserId());

        if (empty($dislike)) {
            $response = ApiResponseBuilder::buildErrorResponse('Meme not liked', 400, ["nbLikes" => $nbLikes, "liked" => $isLiked]);
        } else {
            $response = ApiResponseBuilder::buildSuccessResponse(["nbLikes" => $nbLikes, "liked" => $isLiked]);
        }
        echo json_encode($response);
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
        $requestBody = RequestHandler::getJsonRequestBody();

        if (empty($requestBody) || !isset($requestBody['report_reason'])) {
            throw new BadRequestException('Invalid request body', 400);
        }
        $report = ReportTableManager::addReport($requestBody['report_reason'], $id, $_SESSION['user_id']);

        $response = ApiResponseBuilder::buildSuccessResponse(["report" => $report]);
        echo json_encode($response);
    }

    /**
     * The deleteMeme function attempts to delete a meme from the database. It does not check if the deletion was successful, and always returns a JSON response indicating success.
     *
     * @param int $id The ID of the meme to be deleted.
     * @return void This function does not return a value; it directly outputs the JSON response.
     */
    public function deleteMeme($id)
    {
        MemeTableManager::deleteMeme($id);
        $response = ApiResponseBuilder::buildSuccessResponse([]);
        echo json_encode($response);
    }

    public function getMemeNbLikes($meme_id)
    {
        $nbLikes = MemeTableManager::getMemeNbLikes($meme_id);
        $isLiked = Auth::isLoggedIn() && LikeTableManager::likeExistsByMemeIdAndUserId($meme_id, Auth::GetActiveUserId());
        $response = ApiResponseBuilder::buildSuccessResponse(["nbLikes" => $nbLikes, "liked" => $isLiked]);
        echo json_encode($response);
    }
}

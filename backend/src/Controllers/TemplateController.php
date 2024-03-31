<?php

namespace Controllers;

use Database\TableManagers\TemplateTableManager;
use Utils\ApiResponseBuilder;
use Exceptions\HttpExceptions\NotFoundException;
use Models\Template;

class TemplateController
{
    /**
     * Get all templates in the database
     */
    public function getAllTemplates()
    {
        $templates = TemplateTableManager::getTemplate();
        $response = ApiResponseBuilder::buildSuccessResponse(["templates" => $templates]);
        echo json_encode($response);
    }

    /**
     * Get template by id
     * @param $id
     * @throws NotFoundException
     */
    public function getTemplateById($id)
    {
        $template = TemplateTableManager::getTemplateById($id);
        if ($template) {
            $response = ApiResponseBuilder::buildSuccessResponse(["template" => $template]);
            echo json_encode($response);
        } else {
            throw new NotFoundException("Template not found");
        }
    }

    /**
     * Get template by url
     * @param $url
     * @throws NotFoundException
     */
    public function getTemplateByUrl($url)
    {
        $template = TemplateTableManager::getTemplateByUrl($url);
        if ($template) {
            $response = ApiResponseBuilder::buildSuccessResponse(["template" => $template]);
            echo json_encode($response);
        } else {
            throw new NotFoundException("Template not found");
        }
    }
}
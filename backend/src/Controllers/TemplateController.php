<?php

namespace Controllers;

use Database\TableManagers\TemplateTableManager;
use Utils\ApiResponseBuilder;
use Exceptions\HttpExceptions\NotFoundException;
use Models\Template;

class TemplateController
{
    public function getAllTemplates()
    {
        $templates = TemplateTableManager::getTemplate();
        $response = ApiResponseBuilder::buildSuccessResponse(["templates" => $templates]);
        echo json_encode($response);
    }

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
}
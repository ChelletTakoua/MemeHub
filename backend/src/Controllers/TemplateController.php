<?php

namespace Controllers;

class TemplateController
{
    public function getAllTemplates()
    {
        echo "Get all templates";
    }

    public function getTemplateById($id)
    {
        echo "Get template with id $id";
    }

    public function addTemplate()
    {
        echo "Add a template";
    }

    public function deleteTemplate($id)
    {
        echo "Delete template with id $id";
    }


}
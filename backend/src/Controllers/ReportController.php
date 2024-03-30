<?php

namespace Controllers;

class ReportController
{

    public function getAllReports()
    {
        echo "Get all reports";
    }

    public function resolveReport($id)
    {
        echo "Resolve report with id $id";
    }

    public function ignoreReport($id)
    {
        echo "Ignore report with id $id";
    }

    public function deleteReport($id)
    {
        echo "Delete report with id $id";
    }


}
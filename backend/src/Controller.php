<?php

use Authentication\Auth;

class Controller {
    public function handleRequest() {
        $method = $_SERVER['REQUEST_METHOD'];
        switch($method) {
            case 'GET':
                $this->get();
                break;
            case 'POST':
                $this->post();
                break;
            // Add other cases as needed
            default:
                http_response_code(405);
                echo json_encode(['error' => 'Method not allowed']);
        }
    }

    private function get() {
        if (!Auth::isLoggedIn() || !Auth::hasPermission('read')) {
            http_response_code(403);
            echo json_encode(['error' => 'Forbidden']);
            return;
        }

        // Handle GET request
    }

    private function post() {
        if (!Auth::isLoggedIn() || !Auth::hasPermission('write')) {
            http_response_code(403);
            echo json_encode(['error' => 'Forbidden']);
            return;
        }

        // Handle POST request
    }
}
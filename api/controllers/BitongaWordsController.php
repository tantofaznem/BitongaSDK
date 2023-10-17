<?php
class BitongaWordsController {
    private $db;
    private $requestMethod;
    private $bitongaWordId;

    public function __construct($db, $requestMethod, $bitongaWordId) {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->bitongaWordId = $bitongaWordId;
    }

    public function processRequest() {
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->bitongaWordId) {
                    $response = $this->getBitongaWord($this->bitongaWordId);
                } else {
                    $response = $this->getAllBitongaWords();
                }
                break;
            case 'POST':
                $response = $this->createBitongaWord();
                break;
            case 'PUT':
                $response = $this->updateBitongaWord($this->bitongaWordId);
                break;
            case 'DELETE':
                $response = $this->deleteBitongaWord($this->bitongaWordId);
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }
        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }

    private function getAllBitongaWords() {
        $query = "SELECT * FROM bitonga_words";
        $result = mysqli_query($this->db, $query);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode(mysqli_fetch_all($result, MYSQLI_ASSOC));
        return $response;
    }

    private function getBitongaWord($id) {
        $query = "SELECT * FROM bitonga_words WHERE id = " . $id;
        $result = mysqli_query($this->db, $query);
        if (!$result) {
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode(mysqli_fetch_assoc($result));
        return $response;
    }

    private function createBitongaWord() {
        $input = json_decode(file_get_contents('php://input'), true);
        if (!$this->validateBitongaWord($input)) {
            return $this->unprocessableEntityResponse();
        }
        $query = "INSERT INTO bitonga_words (word, translation) VALUES ('" . $input['word'] . "', '" . $input['translation'] . "')";
        if (mysqli_query($this->db, $query)) {
            $response['status_code_header'] = 'HTTP/1.1 201 Created';
            $response['body'] = null;
        } else {
            return $this->unprocessableEntityResponse();
        }
        return $response;
    }

    private function updateBitongaWord($id) {
        $input = json_decode(file_get_contents('php://input'), true);
        if (!$this->validateBitongaWord($input)) {
            return $this->unprocessableEntityResponse();
        }
        $query = "UPDATE bitonga_words SET word = '" . $input['word'] . "', translation = '" . $input['translation'] . "' WHERE id = " . $id;
        if (mysqli_query($this->db, $query)) {
            $response['status_code_header'] = 'HTTP/1.1 204 No Content';
            $response['body'] = null;
        } else {
            return $this->unprocessableEntityResponse();
        }
        return $response;
    }

    private function deleteBitongaWord($id) {
        $query = "DELETE FROM bitonga_words WHERE id = " . $id;
        if (mysqli_query($this->db, $query)) {
            $response['status_code_header'] = 'HTTP/1.1 204 No Content';
            $response['body'] = null;
        } else {
            return $this->notFoundResponse();
        }
        return $response;
    }

    private function validateBitongaWord($bitongaWord) {
        return isset($bitongaWord['word']) && isset($bitongaWord['translation']);
    }

    private function unprocessableEntityResponse() {
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = json_encode(['error' => 'Invalid input']);
        return $response;
    }

    private function notFoundResponse() {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = null;
        return $response;
    }
}

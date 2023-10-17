<?php

class BitongaDictionarySDK {
    private $apiUrl;
    private $apiKey;


    public function __construct($apiUrl, $apiKey) {
        $this->apiUrl = $apiUrl;
        $this->apiKey = $apiKey;
    }

    public function getBitongaWords() {
        $url = $this->apiUrl . '/api/bitonga-words';
        return $this->sendRequest($url, 'GET');
    }

    public function getBitongaWord($id) {
        $url = $this->apiUrl . '/api/bitonga-words/' . $id;
        return $this->sendRequest($url, 'GET');
    }

    public function addBitongaWord($wordData) {
        $url = $this->apiUrl . '/api/bitonga-words';
        $data = json_encode($wordData);
        return $this->sendRequest($url, 'POST', $data);
    }

    public function updateBitongaWord($id, $wordData) {
        $url = $this->apiUrl . '/api/bitonga-words/' . $id;
        $data = json_encode($wordData);
        return $this->sendRequest($url, 'PUT', $data);
    }

    public function deleteBitongaWord($id) {
        $url = $this->apiUrl . '/api/bitonga-words/' . $id;
        return $this->sendRequest($url, 'DELETE');
    }

    private function sendRequest($url, $method, $data = null) {
        $headers = array(
            'Authorization: Bearer ' . $this->apiKey,
            'Content-Type: application/json',
        );

        $options = array(
            'http' => array(
                'header' => implode("\r\n", $headers),
                'method' => $method,
                'content' => $data,
            ),
        );

        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);

        if ($response === false) {
            return false;
        }

        return json_decode($response, true);
    }
}
?>

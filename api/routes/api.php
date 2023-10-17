<?php
require_once('../controllers/BitongaWordsController.php');

// Initialize the BitongaWordsController
$bitongaController = new BitongaWordsController();

// Define your API routes
$router->get('/api/bitonga-words', function () use ($bitongaController) {
    return $bitongaController->getAllWords();
});

$router->get('/api/bitonga-words/{id}', function ($id) use ($bitongaController) {
    return $bitongaController->getWordById($id);
});

$router->post('/api/bitonga-words', function () use ($bitongaController) {
    return $bitongaController->addWord();
});

$router->put('/api/bitonga-words/{id}', function ($id) use ($bitongaController) {
    return $bitongaController->updateWord($id);
});

$router->delete('/api/bitonga-words/{id}', function ($id) use ($bitongaController) {
    return $bitongaController->deleteWord($id);
});

?>

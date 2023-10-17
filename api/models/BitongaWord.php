<?php
class BitongaWord {
    private $id;
    private $word;
    private $translation;

    public function __construct($id, $word, $translation) {
        $this->id = $id;
        $this->word = $word;
        $this->translation = $translation;
    }

    public function getId() {
        return $this->id;
    }

    public function getWord() {
        return $this->word;
    }

    public function setWord($word) {
        $this->word = $word;
    }

    public function getTranslation() {
        return $this->translation;
    }

    public function setTranslation($translation) {
        $this->translation = $translation;
    }
}

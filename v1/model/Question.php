<?php

class QuestionException extends Exception {}

class Question {

    private $_id;
    private $_text;
    private $_tags = array();
    private $_lang;
    private $_confirmed;
    private $_userName;
    private $_dateOfAdding;

    public function __construct($id, $text, $tags, $lang, $confirmed, $userName, $dateOfAdding){
        $this->setID($id);
        $this->setText($text);
        $this->addTag($tags);
        $this->setLang($lang);
        $this->setConfirmed($confirmed);
        $this->setUserName($userName);
        $this->setDateOfAdding($dateOfAdding);
    }

    public function getID(){
        return $this->_id;
    }

    public function getText(){
        return $this->_text;
    }

    public function getTags(){
        return $this->_tags;
    }

    public function getLanguage(){
        return $this->_lang;
    }

    public function isConfirmed(){
        return $this->_confirmed;
    }

    public function getUserName(){
        return $this->_userName;
    }

    public function getDateOfAdding(){
        return $this->_dateOfAdding;
    }

    public function setID($id){
        if(($id !== null) && (!is_numeric($id) || $id <= 0 || $id > 9223372036854775807 || $this->_id !== null )){
            throw new QuestionException("Question ID error");
        }

        $this->_id = $id;
    }

    public function setText($text){
        if(strlen($text) < 0 || strlen($text) > 5000){
            throw new QuestionException("Question text error");
        }

        $this->_text = $text;
    }

    public function addTag($tag){
        if(strlen($tag) < 0 || strlen($tag) > 256){
            throw new QuestionException("Question tag error");
        }
        $this->_tags[] = $tag;
    }

    public function setLang($lang_id){
        if(($lang_id !== null) && (!is_numeric($lang_id) || $lang_id <= 0 || $lang_id > 9223372036854775807 || $this->_lang !== null )){
            throw new QuestionException("Question language id error");
        }

        $this->_lang = $lang_id;
    }

    public function setConfirmed($confirmed){
        if(strtoupper($confirmed) !== 'Y' && strtoupper($confirmed) !== 'N'){
            throw new QuestionException("Question confirmation error");
        }

        $this->_confirmed = $confirmed;
    }

    public function setUserName($userName){
        if(strlen($userName) < 0 || strlen($userName) > 5000){
            throw new QuestionException("Question user name error");
        }

        $this->_userName = $userName;
    }

    public function setDateOfAdding($dateOfAdding){

        if((dateOfAdding !== null) && date_format(date_create_from_format('d/m/Y H:i', $dateOfAdding), 'd/m/Y H:i') != $dateOfAdding){
            throw new QuestionException("Question date of addition error");
        }

        $this->_dateOfAdding = $dateOfAdding;
    }

    public function returnQuestionAsArray(){
        $question = array();
        $question['id'] = $this->getID();
        $question['text'] = $this->getText();
        $question['tags'] = $this->getTags();
        $question['language'] = $this->getLanguage();
        $question['confirmed'] = $this->isConfirmed();
        $question['userName'] = $this->getUserName();
        $question['dateOfAdding'] = $this->getDateOfAdding();
        return $question;
    }
}
<?php

require_once('Question.php');

try{
    $question = new Question(1, "New question", array("dupa"), 1, "N", "Kamil", "01/12/2021 12:00");
    header('Content-type: application/json;charset=UTF-8');
    echo json_encode($question->returnQuestionAsArray());
}catch(QuestionException $ex){
    echo "Error: ".$ex->getMessage();
}
<?php

require_once('db.php');
require_once('../model/Question.php');
require_once('../model/Response.php');

try{
    $writeDB = DB::connectWriteDB();
    $readDB = DB::connectReadDB();
}catch(PDOException $ex) {
    error_log("DB connection error - ".$ex, 0);
    $response = new Response();
    $response->setHttpStatusCode(500);
    $response->setSuccess(false);
    $response->addMessage("Database connection error");
    $response->send();
    exit();
}

if(array_key_exists("questionid", $_GET)){
    $questionid = $_GET['questionid'];

    if($questionid == '' || !is_numeric($questionid)){
        $response = new Response();
        $response->setHttpStatusCode(400);
        $response->setSuccess(false);
        $response->addMessage("Question ID cannot be blank or be numeric");
        $response->send();
        exit();
    }

    if($_SERVER['REQUEST_METHOD'] === 'GET'){

        try{
            $querry = $readDB->prepare('select id, text, lang_id, confirmed, user_name, DATE_FORMAT(date_of_adding, "%d/%m/%Y %H:%i") as date_of_adding from questions where id = :questionid');
            $querry->bindParam(':questionid', $questionid, PDO::PARAM_INT);
            $querry->execute();

            $rowCount = $querry->rowCount();

            if($rowCount === 0){
                $response = new Response();
                $response->setHttpStatusCode(404);
                $response->setSuccess(false);
                $response->addMessage("Question not found");
                $response->send();
                exit();               
            }

            
            while($row = $querry->fetch(PDO::FETCH_ASSOC)){
                $tags = array($row['tags']);
                $question = new Question($row['id'], $row['text'], $tags, $row['lang_id'], $row['confirmed'], $row['user_name'], $row['date_of_adding']);

                $questionArray[] = $question->returnQuestionAsArray();
            }

            $returnData = array();
            $returnData['rows_returned'] = $rowCount;
            $returnData['questions'] = $questionArray;

            $response = new Response();
            $response->setHttpStatusCode(200);
            $response->setSuccess(true);
            $response->toCache(true);
            $response->setData($returnData);
            $response->send();
            exit();


        }catch(QuestionException $ex){
            $response = new Response();
            $response->setHttpStatusCode(500);
            $response->setSuccess(false);
            $response->addMessage($ex->getMessage());
            $response->send();
            exit();    
        }catch(PDOException $ex){
            error_log("DB querry error - ".$ex, 0);
            $response = new Response();
            $response->setHttpStatusCode(500);
            $response->setSuccess(false);
            $response->addMessage("Failed to get Question");
            $response->send();
            exit();  
        }
         
    }elseif($_SERVER['REQUEST_METHOD'] === 'DELETE') {

        try{
            $querry = $writeDB->prepare('DELERE FROM questions WHERE id = :questionid');
            $querry->bindParam(':questionid', $questionid, PDO::PARAM_INT);
            $querry->execute();

            $rowCount = $querry->rowCount();

            if($rowCount === 0){
                $response = new Response();
                $response->setHttpStatusCode(404);
                $response->setSuccess(false);
                $response->addMessage("Question not found");
                $response->send();
                exit();               
            }

            
            while($row = $querry->fetch(PDO::FETCH_ASSOC)){
                $tags = array($row['tags']);
                $question = new Question($row['id'], $row['text'], $tags, $row['lang_id'], $row['confirmed'], $row['user_name'], $row['date_of_adding']);

                $questionArray[] = $question->returnQuestionAsArray();
            }

            $returnData = array();
            $returnData['rows_returned'] = $rowCount;
            $returnData['questions'] = $questionArray;

            $response = new Response();
            $response->setHttpStatusCode(200);
            $response->setSuccess(true);
            $response->addMessage('Question deleted');
            $response->send();
            exit();


        }catch(QuestionException $ex){
            $response = new Response();
            $response->setHttpStatusCode(500);
            $response->setSuccess(false);
            $response->addMessage($ex->getMessage());
            $response->send();
            exit();    
        }catch(PDOException $ex){
            error_log("DB querry error - ".$ex, 0);
            $response = new Response();
            $response->setHttpStatusCode(500);
            $response->setSuccess(false);
            $response->addMessage("Failed to get Question");
            $response->send();
            exit();  
        }

    }elseif($_SERVER['REQUEST_METHOD'] === 'PATCH') {
        
    }else{
        $response = new Response();
        $response->setHttpStatusCode(405);
        $response->setSuccess(false);
        $response->addMessage("Request method not allowed");
        $response->send();
        exit();       
    }
}

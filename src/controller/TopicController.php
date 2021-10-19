<?php

namespace App\controller;

use App\model\dao\DAOFactory;
use App\model\dao\TopicDAO;

class TopicController
{
    private TopicDAO $topicDAO;

    public function __construct()
    {
        $this->topicDAO = DAOFactory::getTopicDAO();
    }

    public function getTopic($id)
    {
        $topic = $this->topicDAO->selectById($id);
        if(!$topic)
        {
            http_response_code(404);
            echo "Topic not found";
        } else {
            http_response_code(200);
            echo json_encode($topic->ToString());
        }
    }

    public function getAllTopic()
    {
        $topic = $this->topicDAO->selectAll();
        if(!$topic)
        {
            http_response_code(404);
            echo "Error while retrieving topics data";
        } else {
            http_response_code(200);
            echo json_encode($topic);
        }
    }

    public function postTopic()
    {
        $result = $this->topicDAO->insert($_POST);

        if(!$result)
        {
            //FAILED
            http_response_code(404);
        } else {
            //CREATED
            http_response_code(201);
            echo json_encode(
                $result
            );
        }

    }

    public function putTopic($id)
    {
        //NO PHP PUT METHOD, so, DIY, retrieve data string (from the put request) and convert to array
        $putData = json_decode(file_get_contents('php://input'), true);
        $putData["id"] = $id;

        $topic = $this->topicDAO->update($putData);

        if(!$topic)
        {
            http_response_code(404);
            echo "Unable to update Topic: Invalid data";
        } else {
            http_response_code(200);
            echo json_encode(
                $topic
            );
        }


    }

    public function deleteTopic($id)
    {
        $topic = $this->topicDAO->delete($id);
        if(!$topic)
        {
            http_response_code(404);
            echo "Topic does not exist";
        } else {
            http_response_code(200);
            echo "Topic deleted";
        }
    }
}
<?php

namespace App\controller;

use App\model\dao\DAOFactory;
use App\model\dao\PostDAO;

class PostController
{
    private PostDAO $postDAO;

    public function __construct()
    {
        $this->postDAO = DAOFactory::getPostDAO();
    }

    public function getPost($id)
    {
        $post = $this->postDAO->selectById($id)->ToString();
        if(!$post)
        {
            http_response_code(404);
            echo "Post not found";
        } else {
            http_response_code(200);
            echo json_encode($post);
        }
    }

    public function getAllPosts()
    {
        $post = $this->postDAO->selectAll();
        if(!$post)
        {
            http_response_code(404);
            echo "Error while retrieving posts data";
        } else {
            http_response_code(200);
            echo json_encode($post);
        }
    }

    public function createPost()
    {
        $result = $this->postDAO->insert($_POST);

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

    public function putPost($id)
    {
        //NO PHP PUT METHOD, so, DIY, retrieve data string (from the put request) and convert to array
        $putData = json_decode(file_get_contents('php://input'), true);
        $putData["id"] = $id;

        $post = $this->postDAO->update($putData);

        if(!$post)
        {
            http_response_code(404);
            echo "Unable to update Post: Invalid data";
        } else {
            http_response_code(200);
            echo json_encode(
                $post
            );
        }


    }

    public function deletePost($id)
    {
        $post = $this->postDAO->delete($id);
        if(!$post)
        {
            http_response_code(404);
            echo "Post does not exist";
        } else {
            http_response_code(200);
            echo "Post deleted";
        }
    }
}
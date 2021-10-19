<?php

namespace App\controller;
use App\model\dao\DAOFactory;

class UserController
{
    private \App\model\dao\UserDAO $userDAO;

    public function __construct()
    {
        $this->userDAO = DAOFactory::getUserDAO();
    }

    public function getUser($id)
    {
        $user = $this->userDAO->selectById($id)->ToString();
        if(!$user)
        {
            http_response_code(404);
            echo "User not found";
        } else {
            http_response_code(200);
            echo json_encode($user);
        }
    }

    public function getAllUsers()
    {
        $users = $this->userDAO->selectAll();
        if(!$users)
        {
            http_response_code(404);
            echo "Error while retrieving users data";
        } else {
            http_response_code(200);
            echo json_encode($users);
        }
    }

    public function postUser()
    {
        $result = $this->userDAO->insert($_POST);

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

    public function putUser($id)
    {
        //NO PHP PUT METHOD, so, DIY, retrieve data string (from the put request) and convert to array
        $putData = json_decode(file_get_contents('php://input'), true);
        $putData["id"] = $id;

        $user = $this->userDAO->update($putData);

        if(!$user)
        {
            http_response_code(404);
            echo "Unable to update User: Invalid data";
        } else {
            http_response_code(200);
            echo json_encode(
                $user
            );
        }


    }

    public function deleteUser($id)
    {
        $user = $this->userDAO->delete($id);
        if(!$user)
        {
            http_response_code(404);
            echo "User does not exist";
        } else {
            http_response_code(200);
            echo "User deleted";
        }
    }
}
<?php

namespace App\controller;
use App\model\dal\DAOFactory;

class UserController
{
    private $userDAO;

    public function __construct()
    {
        $this->userDAO = DAOFactory::getUserDAO();
    }

    public function getUser($id)
    {
        echo json_encode($this->userDAO->selectById($id));
    }

    public function postUser()
    {
        echo "PostData";
    }

    public function putUser($id)
    {
        echo "Update User ".$id;
    }

    public function deleteUser($id)
    {
        echo "Delete user ".$id;
    }
}
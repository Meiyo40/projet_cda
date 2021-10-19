<?php

namespace App\controller;

use App\model\dao\CategoryDAO;
use App\model\dao\DAOFactory;

class CategoryController
{
    private CategoryDAO $categoryDAO;

    public function __construct()
    {
        $this->categoryDAO = DAOFactory::getCategoryDAO();
    }

    public function getCategory($id)
    {
        $category = $this->categoryDAO->selectById($id)->ToString();
        if(!$category)
        {
            http_response_code(404);
            echo "Category not found";
        } else {
            http_response_code(200);
            echo json_encode($category);
        }
    }

    public function getAllCategory()
    {
        $category = $this->categoryDAO->selectAll();
        if(!$category)
        {
            http_response_code(404);
            echo "Error while retrieving categories data";
        } else {
            http_response_code(200);
            echo json_encode($category);
        }
    }

    public function createCategory()
    {
        $result = $this->categoryDAO->insert($_POST);

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

    public function updateCategory($id)
    {
        //NO PHP PUT METHOD, so, DIY, retrieve data string (from the put request) and convert to array
        $putData = json_decode(file_get_contents('php://input'), true);
        $putData["id"] = $id;

        $category = $this->categoryDAO->update($putData);

        if(!$category)
        {
            http_response_code(404);
            echo "Unable to update Category: Invalid data";
        } else {
            http_response_code(200);
            echo json_encode(
                $category
            );
        }


    }

    public function deleteCategory($id)
    {
        $category = $this->categoryDAO->delete($id);
        if(!$category)
        {
            http_response_code(404);
            echo "Category does not exist";
        } else {
            http_response_code(200);
            echo "Category deleted";
        }
    }
}
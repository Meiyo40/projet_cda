<?php


namespace App\model\dao;


use App\model\database\Database;
use App\model\entity\Category;

class CategoryDAO implements EntityDAOImpl
{

    public function insert($entity)
    {
        if(!empty($entity) && !empty($entity["label"]))
        {
            $category = new Category();
            $category->setLabel($entity["label"]);

            $db = Database::connect();

            $statement = $db->prepare(
                "INSERT INTO `category` (label)
                            VALUES (?)"
            );

            $result = $statement->execute(array($category->getLabel()));

            if($result)
            {
                $category->setId($db->lastInsertId());
                return $category->ToString();
            }
        }
        return false;
    }

    public function update($entity)
    {
        if(!empty($entity) && !empty($entity["id"]) && !empty($entity["label"]))
        {
            $category = $this->selectById($entity["id"]);

            if(!($category instanceof Category))
                return false; //N'existe pas, on return false au controller qui retournera un 404


            //On ne part du principe que seul le label peut etre modifie et pas le reste
            $category->setLabel($entity["label"]);

            $db = Database::connect();

            $statement = $db->prepare(
                "UPDATE `category` SET `label` = ? WHERE `id` = ?"
            );

            $result = $statement->execute(array($category->getLabel(), $category->getId()));

            if($result)
            {
                return $category->ToString();
            }
        }
        return false;
    }

    public function delete($id)
    {
        $db = Database::connect();

        $statement = $db->prepare("DELETE FROM `category` WHERE `id` = ?");
        $result = $statement->execute(array($id));

        if($result)
        {
            return "Category successfully deleted";
        }

        return false;
    }

    public function selectById(int $id)
    {
        $db = Database::connect();

        $statement = $db->prepare("SELECT*FROM `category` WHERE `id` = ?");
        $statement->execute(array($id));

        $result = $statement->fetch(\PDO::FETCH_ASSOC);

        if($result)
        {
            $category = new Category();
            $category->setId($result["id"]);
            $category->setLabel($result["label"]);
            $category->setTopics(
                DAOFactory::getTopicDAO()->selectByCategoryId($result["id"])
            );

            return $category;
        }

        return false;
    }

    public function selectAll()
    {
        $db = Database::connect();

        $statement = $db->prepare("SELECT*FROM `category`");
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        if(sizeof($result) > 0)
        {
            $categories = array();

            foreach ($result as $r)
            {
                $category = new Category();
                $category->setId($r["id"]);
                $category->setLabel($r["label"]);
                $category->setTopics(
                    DAOFactory::getTopicDAO()->selectByCategoryId($r["id"])
                );

                array_push($categories, $category->ToString());
            }

            return $categories;
        }

        return false;
    }
}
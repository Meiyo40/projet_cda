<?php


namespace App\model\dao;


use App\model\database\Database;
use App\model\entity\Topic;

class TopicDAO implements EntityDAOImpl
{

    public function insert($entity)
    {
        if(!empty($entity) && !empty($entity["title"]) && !empty($entity["category_id"])&& !empty($entity["user_id"]))
        {
            $topic = new Topic();
            $topic->setTitle($entity["title"]);
            $topic->setUserId($entity["user_id"]);
            $topic->setCategoryId($entity["category_id"]);

            $db = Database::connect();

            $statement = $db->prepare(
                "INSERT INTO `topic` (title, user_id, category_id)
                            VALUES (?,?,?)"
            );
            $result = $statement->execute(array($topic->getTitle(), $topic->getUserId(), $topic->getCategoryId()));
            $statement->closeCursor();
            Database::disconnect();

            if($result)
            {
                $topic->setId($db->lastInsertId());
                return $topic->ToString();
            }
        }
        return false;
    }

    public function update($entity)
    {
        if(!empty($entity) && !empty($entity["id"]) && !empty($entity["title"]) && !empty($entity["category_id"]))
        {
            $topic = $this->selectById($entity["id"]);

            if(!($topic instanceof Topic))
                return false; //N'existe pas, on return false au controller qui retournera un 404

            $topic->setTitle($entity["title"]);
            $topic->setCategoryId($entity["category_id"]);

            $db = Database::connect();

            $statement = $db->prepare(
                "UPDATE `topic` SET `title` = ?, `category_id` = ? WHERE `id` = ?"
            );

            $result = $statement->execute(array($topic->getTitle(), $topic->getCategoryId(), $topic->getId()));
            $statement->closeCursor();
            Database::disconnect();

            if($result)
            {
                return $topic->ToString();
            }
        }
        return false;
    }

    public function delete($id)
    {
        $db = Database::connect();

        $statement = $db->prepare("DELETE FROM `topic` WHERE `id` = ?");
        $result = $statement->execute(array($id));
        $statement->closeCursor();
        Database::disconnect();

        if($result)
        {
            return "Topic successfully deleted";
        }

        return false;
    }

    public function selectById(int $id)
    {
        $db = Database::connect();

        $statement = $db->prepare("SELECT*FROM `topic` WHERE `id` = ?");
        $statement->execute(array($id));
        $result = $statement->fetch(\PDO::FETCH_ASSOC);
        $statement->closeCursor();
        Database::disconnect();

        if($result)
        {
            $topic = new Topic();
            $topic->setId($result["id"]);
            $topic->setTitle($result["title"]);
            $topic->setUserId($result["user_id"]);
            $topic->setCategoryId($result["category_id"]);
            $topic->setPosts(
                DAOFactory::getPostDAO()->selectAllByTopicId($result["id"])
            );

            return $topic;
        }

        return false;
    }


    /**
     * Return all the topics link to the given UserId
     * @param int $userId
     * @return array|bool
     */
    public function selectByUserId(int $userId)
    {
        $db = Database::connect();

        $statement = $db->prepare("SELECT*FROM `topic` WHERE `user_id` = ?");
        $statement->execute(array($userId));
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $statement->closeCursor();
        Database::disconnect();

        if(sizeof($result) > 0)
        {
            $topics = array();
            foreach ($result as $r)
            {
                $topic = new Topic();
                $topic->setId($r["id"]);
                $topic->setTitle($r["title"]);
                $topic->setUserId($r["user_id"]);
                $topic->setCategoryId($r["category_id"]);
                $topic->setPosts(
                    DAOFactory::getPostDAO()->selectAllByTopicId($r["id"])
                );

                array_push($topics, $topic->ToString());
            }

            return $topics;
        }

        return array();
    }

    /**
     * Return all topic link to the given categoryId
     * @param int $categoryId
     * @return array
     */
    public function selectByCategoryId(int $categoryId): array
    {
        $db = Database::connect();

        $statement = $db->prepare("SELECT*FROM `topic` WHERE `category_id` = ?");
        $statement->execute(array($categoryId));
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $statement->closeCursor();
        Database::disconnect();

        if(sizeof($result) > 0)
        {
            $topics = array();
            foreach ($result as $r)
            {
                $topic = new Topic();
                $topic->setId($r["id"]);
                $topic->setTitle($r["title"]);
                $topic->setUserId($r["user_id"]);
                $topic->setCategoryId($r["category_id"]);
                $topic->setPosts(
                    DAOFactory::getPostDAO()->selectAllByTopicId($r["id"])
                );

                array_push($topics, $topic->ToString());
            }

            return $topics;
        }

        return array();
    }

    public function selectAll()
    {
        $db = Database::connect();

        $statement = $db->prepare("SELECT*FROM `topic`");
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $statement->closeCursor();
        Database::disconnect();

        if(sizeof($result) > 0)
        {
            $topics = array();
            foreach ($result as $r)
            {
                $topic = new Topic();
                $topic->setId($r["id"]);
                $topic->setTitle($r["title"]);

                array_push($topics, $topic->ToString());
            }

            return $topics;
        }

        return false;
    }
}
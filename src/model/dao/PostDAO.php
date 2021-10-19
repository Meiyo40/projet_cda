<?php


namespace App\model\dao;


use App\model\database\Database;
use App\model\entity\Post;

class PostDAO implements EntityDAOImpl
{

    public function insert($entity)
    {
        if(!empty($entity) && !empty($entity["post_date"]) && !empty($entity["content"])
            && !empty($entity["user_id"]) && !empty($entity["topic_id"]))
        {
            $post = new Post();
            $post->setContent($entity["content"]);
            $post->setUserId($entity["user_id"]);
            $post->setTopicId($entity["topic_id"]);
            $post->setPostDate($entity["post_date"]);

            $db = Database::connect();

            $statement = $db->prepare(
                "INSERT INTO `post` (post_date, content, topic_id, user_id)
                            VALUES (?,?,?,?)"
            );

            $result = $statement->execute(array($post->getPostDate(), $post->getContent(), $post->getTopicId(), $post->getUserId()));

            if($result)
            {
                $post->setId($db->lastInsertId());
                return $post->ToString();
            }
        }
        return false;
    }

    public function update($entity)
    {
        if(!empty($entity) && !empty($entity["id"]) && !empty($entity["content"]) && !empty($entity["topic_id"]))
        {
            $post = $this->selectById($entity["id"]);

            if(!($post instanceof Post))
                return false; //N'existe pas, on return false au controller qui retournera un 404


            //On ne part du principe que seul le contenu et le topic peuvent etre modifie et pas le reste
            $post->setTopicId($entity["topic_id"]);
            $post->setContent($entity["content"]);

            $db = Database::connect();

            $statement = $db->prepare(
                "UPDATE `post` SET `content` = ?, `topic_id` = ? WHERE `id` = ?"
            );

            $result = $statement->execute(array($post->getContent(), $post->getTopicId(), $post->getId()));

            if($result)
            {
                return $post->ToString();
            }
        }
        return false;
    }

    public function delete($id)
    {
        $db = Database::connect();

        $statement = $db->prepare("DELETE FROM `post` WHERE `id` = ?");
        $result = $statement->execute(array($id));

        if($result)
        {
            return "Post successfully deleted";
        }

        return false;
    }

    public function selectById(int $id)
    {
        $db = Database::connect();

        $statement = $db->prepare("SELECT*FROM `post` WHERE `id` = ?");
        $statement->execute(array($id));
        $result = $statement->fetch(\PDO::FETCH_ASSOC);

        if($result)
        {
            $post = new Post();
            $post->setId($result["id"]);
            $post->setPostDate($result["post_date"]);
            $post->setContent($result["content"]);
            $post->setTopicId($result["topic_id"]);
            $post->setUserId($result["user_id"]);

            return $post;
        }

        return false;
    }


    /**
     * Return all the posts link to the given UserId
     * @param int $userId
     * @return array|bool
     */
    public function selectByUserId(int $userId)
    {
        $db = Database::connect();

        $statement = $db->prepare("SELECT*FROM `post` WHERE `user_id` = ?");
        $statement->execute(array($userId));
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        if(sizeof($result) > 0)
        {
            $posts = array();
            foreach ($result as $r)
            {
                $post = new Post();
                $post->setId($r["id"]);
                $post->setPostDate($r["post_date"]);
                $post->setContent($r["content"]);
                $post->setTopicId($r["topic_id"]);
                $post->setUserId($r["user_id"]);

                array_push($posts, $post->ToString());
            }

            return $posts;
        }

        return false;
    }

    /**
     * Return all posts link to the given topic_id
     * @param int $categoryId
     * @return array|bool
     */
    public function selectByCategoryId(int $categoryId)
    {
        $db = Database::connect();

        $statement = $db->prepare("SELECT*FROM `post` WHERE `topic_id` = ?");
        $statement->execute(array($categoryId));
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        if(sizeof($result) > 0)
        {
            $posts = array();
            foreach ($result as $r)
            {
                $post = new Post();
                $post->setId($r["id"]);
                $post->setPostDate($r["post_date"]);
                $post->setContent($r["content"]);
                $post->setTopicId($r["topic_id"]);
                $post->setUserId($r["user_id"]);

                array_push($posts, $post->ToString());
            }

            return $posts;
        }

        return false;
    }

    public function selectAll()
    {
        $db = Database::connect();

        $statement = $db->prepare("SELECT*FROM `post`");
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        if(sizeof($result) > 0)
        {
            $posts = array();

            foreach ($result as $r)
            {
                $post = new Post();
                $post->setId($r["id"]);
                $post->setPostDate($r["post_date"]);
                $post->setContent($r["content"]);
                $post->setTopicId($r["topic_id"]);
                $post->setUserId($r["user_id"]);

                array_push($posts, $post->ToString());
            }

            return $posts;
        }

        return false;
    }
}
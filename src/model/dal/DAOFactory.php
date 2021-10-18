<?php
namespace App\model\dal;

class DAOFactory
{
    public static function getUserDAO() : UserDAO {
        return new UserDAO();
    }

    public static function getPostDAO() : PostDAO {
        return new PostDAO();
    }

    public static function getTopicDAO() : TopicDAO {
        return new TopicDAO();
    }

    public static function getCategoryDAO() : CategoryDAO {
        return new CategoryDAO();
    }
}
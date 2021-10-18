<?php


namespace Loicd\ProjetCda\model\dal;


use Loicd\ProjetCda\model\entity\Category;

class DAOFactory
{
    public static function getUserDao() : UserDAO {
        return new UserDAO();
    }

    public static function getPostDao() : PostDAO {
        return new PostDAO();
    }

    public static function getTopicDao() : TopicDAO {
        return new TopicDAO();
    }

    public static function getCategoryDao() : CategoryDAO {
        return new CategoryDAO();
    }
}
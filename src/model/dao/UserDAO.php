<?php


namespace App\model\dao;


use App\model\database\Database;
use App\model\entity\User;

class UserDAO implements EntityDAOImpl
{

    public function insert($entity)
    {
        if(!empty($entity) && !empty($entity["email"]) && !empty($entity["password"]) && !empty($entity["birth_date"]))
        {
            $user = new User();
            $user->setEmail($entity["email"]);
            $user->setPassword(
                password_hash($entity["password"], PASSWORD_BCRYPT)
            );
            $user->setBirthDate($entity["birth_date"]);

            $db = Database::connect();

            $statement = $db->prepare(
                "INSERT INTO `user` (email, password, birth_date)
                            VALUES (?,?,?)"
            );
            $result = $statement->execute(array($user->getEmail(), $user->getPassword(), $user->getBirthDate()));
            if($result)
            {
                $user->setId($db->lastInsertId());
                return $user->ToString();
            }
        }
        return false;
    }

    public function update($entity)
    {
        if(!empty($entity) && !empty($entity["id"]) && !empty($entity["email"]) && !empty($entity["password"]) && !empty($entity["birth_date"]))
        {
            $user = $this->selectById($entity["id"]);

            if(!($user instanceof User))
                return "Unable to update User: User not reachable.";

            $user->setEmail($entity["email"]);
            $user->setBirthDate($entity["birth_date"]);
            $user->setPassword(password_hash($entity["password"], PASSWORD_BCRYPT));

            $db = Database::connect();

            $statement = $db->prepare(
                "UPDATE `user` SET `email` = ?, `password` = ?, `birth_date` = ? WHERE `id` = ?"
            );
            $result = $statement->execute(array($user->getEmail(), $user->getPassword(), $user->getBirthDate(), $user->getId()));
            if($result)
            {
                return $user->ToString();
            }
        }
        return false;
    }

    public function delete($id)
    {
        $db = Database::connect();

        $statement = $db->prepare("DELETE FROM `user` WHERE `id` = ?");
        $result = $statement->execute(array($id));

        if($result)
        {
            return "User successfully deleted";
        }

        return false;
    }

    public function selectById(int $id)
    {
        $db = Database::connect();

        $statement = $db->prepare("SELECT*FROM `user` WHERE `id` = ?");
        $statement->execute(array($id));
        $result = $statement->fetch(\PDO::FETCH_ASSOC);

        if($result)
        {
            $user = new User();
            $user->setId($result["id"]);
            $user->setEmail($result["email"]);
            $user->setPassword($result["password"]);
            $user->setBirthDate($result["birth_date"]);

            return $user;
        }

        return false;
    }

    public function selectAll()
    {
        $db = Database::connect();

        $statement = $db->prepare("SELECT*FROM `user`");
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        if(sizeof($result) > 0)
        {
            $users = array();
            foreach ($result as $r)
            {
                $user = new User();
                $user->setId($r["id"]);
                $user->setEmail($r["email"]);
                $user->setPassword($r["password"]);
                $user->setBirthDate(new \DateTime($r["birth_date"]));

                array_push($users, $user->ToString());
            }

            return $users;
        }

        return false;
    }
}
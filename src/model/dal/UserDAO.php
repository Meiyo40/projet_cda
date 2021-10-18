<?php


namespace App\model\dal;


use App\model\entity\User;
use Cassandra\Date;

class UserDAO implements EntityDAOImpl
{

    public function insert($entity)
    {
        // TODO: Implement insert() method.
    }

    public function update($entity)
    {
        // TODO: Implement update() method.
    }

    public function delete($entity)
    {
        // TODO: Implement delete() method.
    }

    public function selectById(int $id)
    {
        // TODO: Implement selectById() method.
        $user = new User();
        $user->setId($id);
        $user->setEmail("test@test.com");
        $user->setPassword("coconuts");
        $user->setBirthDate(new \DateTime());

        return $user->ToString();
    }

    public function selectAll()
    {
        // TODO: Implement selectAll() method.
    }
}
<?php

namespace App\model\dao;

interface EntityDAOImpl
{
    public function insert($entity);
    public function update($entity);
    public function delete($entity);
    public function selectById(int $id);
    public function selectAll();
}
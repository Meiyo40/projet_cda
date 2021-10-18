<?php


namespace Loicd\ProjetCda\model\entity;


class User
{
    private int $id;
    private string $email;
    private string $password;
    private \DateTime $birthDate;

    private $posts;
    private $topic;
}
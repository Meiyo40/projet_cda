<?php


namespace App\model\entity;


class User
{
    private int $id;
    private string $email;
    private string $password;
    private string $birthDate;

    private array $posts;
    private array $topics;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getBirthDate(): string
    {
        return $this->birthDate;
    }

    /**
     * @param string $birthDate
     */
    public function setBirthDate(string $birthDate): void
    {
        $this->birthDate = $birthDate;
    }

    /**
     * @return mixed
     */
    public function getPosts(): array
    {
        return $this->posts;
    }

    /**
     * @param mixed $posts
     */
    public function setPosts($posts): void
    {
        $this->posts = $posts;
    }

    /**
     * @return mixed
     */
    public function getTopics(): array
    {
        return $this->topics;
    }

    /**
     * @param mixed $topics
     */
    public function setTopics($topics): void
    {
        $this->topics = $topics;
    }

    public function ToString()
    {
        return array("id" => $this->id,
            "email" => $this->email,
            //"password" => $this->password,
            "birth_date" => $this->birthDate, //->format("d-m-Y")
            "topics" => $this->topics,
            "posts" => $this->posts
        );
    }
}
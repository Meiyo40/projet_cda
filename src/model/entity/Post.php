<?php


namespace App\model\entity;


class Post
{
    private int $id;
    private string $post_date;
    private string $content;
    private int $userId;
    private int $topicId;

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
    public function getPostDate(): string
    {
        return $this->post_date;
    }

    /**
     * @param string $post_date
     */
    public function setPostDate(string $post_date): void
    {
        $this->post_date = $post_date;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return int
     */
    public function getTopicId(): int
    {
        return $this->topicId;
    }

    /**
     * @param int $topicId
     */
    public function setTopicId(int $topicId): void
    {
        $this->topicId = $topicId;
    }
    public function ToString()
    {
        return array("id" => $this->id,
            "postDate" => $this->post_date,
            "content" => $this->content);
    }
}
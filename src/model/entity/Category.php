<?php


namespace App\model\entity;


class Category
{
    private int $id;
    private string $label;
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
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    /**
     * @return array
     */
    public function getTopics(): array
    {
        return $this->topics;
    }

    /**
     * @param array $topics
     */
    public function setTopics(array $topics): void
    {
        $this->topics = $topics;
    }

    public function ToString()
    {
        return array("id" => $this->id,
            "label" => $this->label,
            "topics" => $this->topics
        );
    }
}
<?php

class Category {

    private int $id;
    private string $name;

    public function __construct(string $name, int $id = 0)
    {
        $this->name = $name;
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}

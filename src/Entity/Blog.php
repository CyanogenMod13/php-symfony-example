<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'blog_blogs')]
class Blog
{
    #[ORM\Id]
    #[ORM\Column(type: 'guid')]
    private string $id;

    #[ORM\Column]
    private string $name;

    #[ORM\Column]
    private string $alias;

    #[ORM\ManyToOne]
    private Category $category;

    #[ORM\OneToOne(cascade: ["persist", "remove"])]
    private Author $author;

    public function __construct(
        string $id,
        string $name,
        string $alias,
        string $authorId,
        string $authorFirstName,
        string $authorLastName,
        string $authorPenName,
        Category $category
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->alias = $alias;
        $this->author = new Author($authorId, $authorFirstName, $authorLastName, $authorPenName, $this);
        $this->category = $category;
    }

    /**
     * @param string $name
     * @param string $alias
     * @return void
     */
    public function edit(string $name, string $alias): void
    {
        $this->name = $name;
        $this->alias = $alias;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getAlias(): string
    {
        return $this->alias;
    }

    /**
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * @return Author
     */
    public function getAuthor(): Author
    {
        return $this->author;
    }
}
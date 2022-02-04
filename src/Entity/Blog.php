<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
#[ORM\Table(name: 'blog_blogs')]
class Blog
{
    #[ORM\Id]
    #[ORM\Column(type: 'guid')]
    private string $id;

    #[ORM\Column]
	#[Groups('rest')]
    private string $name;

    #[ORM\Column]
	#[Groups('rest')]
    private string $alias;

    #[ORM\ManyToOne]
	#[Groups('rest')]
    private Category $category;

    #[ORM\OneToOne(cascade: ["persist", "remove"])]
	#[Groups('rest')]
    private Author $author;

    public function __construct(
        string $id,
        string $name,
        string $alias,
        string $authorId,
        AuthorInfo $authorName,
        Category $category
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->alias = $alias;
        $this->author = new Author($authorId, $authorName, $this);
        $this->category = $category;
    }

    public function edit(string $name, string $alias, Category $category): void
    {
        $this->name = $name;
        $this->alias = $alias;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAlias(): string
    {
        return $this->alias;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function getAuthor(): Author
    {
        return $this->author;
    }
}
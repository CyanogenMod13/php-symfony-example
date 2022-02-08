<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
#[ORM\Table(name: 'blog_blogs')]
class Blog
{
    #[ORM\Id]
    #[ORM\Column(type: 'guid')]
	#[Groups('rest')]
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

	#[ORM\OneToMany(mappedBy: 'blog', targetEntity: 'Article', cascade: ['all'])]
	private Collection $articles;

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
		$this->articles = new ArrayCollection();
    }

    public function edit(string $name, string $alias, Category $category): void
    {
        $this->name = $name;
        $this->alias = $alias;
		$this->category = $category;
    }

	public function publishNewArticle(string $title, string $content, Author $creator): Article
	{
		$newArticle = new Article(Uuid::uuid4()->toString(), $title, $content, $creator, $this);
		$this->articles->add($newArticle);
		return $newArticle;
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

	public function getArticles(): array
	{
		return $this->articles->toArray();
	}
}
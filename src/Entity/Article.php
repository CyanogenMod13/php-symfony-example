<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

#[ORM\Entity]
#[ORM\Table('blog_articles')]
class Article
{
	#[ORM\Id]
	#[ORM\Column(type: 'guid')]
	private string $id;
	#[ORM\Column]
	private string $title;
	#[ORM\Column]
	private string $content;
	#[ORM\ManyToOne]
	private Author $author;
	#[ORM\OneToMany(mappedBy: 'article', targetEntity: 'Comment', cascade: ['all'])]
	private Collection $comments;
	#[ORM\OneToMany(mappedBy: 'article', targetEntity: 'Like', cascade: ['all'])]
	private Collection $likes;

	public function __construct(string $id, string $title, string $content, Author $author)
	{
		$this->id = $id;
		$this->title = $title;
		$this->content = $content;
		$this->author = $author;
		$this->comments = new ArrayCollection();
		$this->likes = new ArrayCollection();
	}

	public function acceptComment(string $content, Author $creator): void
	{
		$this->comments->add(new Comment(Uuid::uuid4()->toString(), $content, $creator));
	}

	public function doLike(Author $author): void
	{
		$this->likes->add(new Like(Uuid::uuid4()->toString(), $author));
	}

	public function getId(): string
	{
		return $this->id;
	}

	public function getTitle(): string
	{
		return $this->title;
	}

	public function getContent(): string
	{
		return $this->content;
	}

	public function getAuthor(): Author
	{
		return $this->author;
	}

	/**
	 * @return Comment[]
	 */
	public function getComments(): array
	{
		return $this->comments->toArray();
	}

	/**
	 * @return Like[]
	 */
	public function getLikes(): array
	{
		return $this->likes->toArray();
	}
}
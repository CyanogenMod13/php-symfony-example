<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table('blog_likes')]
class Like
{
	#[ORM\Id]
	#[ORM\Column(type: 'guid')]
	private string $id;
	#[ORM\ManyToOne]
	private Author $author;
	#[ORM\ManyToOne]
	private Article $article;

	public function __construct(string $id, Author $author, Article $article)
	{
		$this->id = $id;
		$this->article = $article;
		$this->author = $author;
	}

	public function getId(): string
	{
		return $this->id;
	}

	public function getAuthor(): Author
	{
		return $this->author;
	}

	public function getArticle(): Article
	{
		return $this->article;
	}
}
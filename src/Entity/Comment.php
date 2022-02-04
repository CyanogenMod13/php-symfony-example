<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table('blog_comments')]
class Comment
{
	#[ORM\Id]
	#[ORM\Column(type: 'guid')]
	private string $id;
	#[ORM\Column]
	private string $content;
	#[ORM\ManyToOne]
	private Author $author;
	#[ORM\ManyToOne]
	private Article $article;

	public function __construct(string $id, string $content, Author $author)
	{
		$this->id = $id;
		$this->content = $content;
		$this->author = $author;
	}

	public function getId(): string
	{
		return $this->id;
	}

	public function getContent(): string
	{
		return $this->content;
	}

	public function getAuthor(): Author
	{
		return $this->author;
	}
}
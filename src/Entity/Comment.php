<?php

declare(strict_types=1);

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity]
#[ORM\Table('blog_comments')]
class Comment
{
	#[ORM\Id]
	#[ORM\Column(type: 'guid')]
	#[Groups('rest')]
	private string $id;

	#[ORM\Column]
	private DateTimeImmutable $time;

	#[ORM\Column]
	#[Groups('rest')]
	private string $content;

	#[ORM\ManyToOne]
	#[Groups('rest')]
	private Author $author;

	#[ORM\ManyToOne]
	private Comment $parent;

	#[ORM\ManyToOne]
	private Article $article;

	#[ORM\OneToMany(mappedBy: 'parent', targetEntity: 'Comment', cascade: ['all'])]
	private Collection $children;

	#[ORM\Column]
	#[Groups('rest')]
	private int $likesNumber;

	public function __construct(string $id, string $content, Author $author)
	{
		$this->id = $id;
		$this->content = $content;
		$this->author = $author;
		$this->children = new ArrayCollection();
		$this->time = new DateTimeImmutable();
	}

	public function reply(string $content, Author $author): Comment
	{
		$replyComment = new self(Uuid::uuid4()->toString(), $content, $author);
		$replyComment->setParent($this);
		$this->children->add($replyComment);
		return $replyComment;
	}

	public function doLike(): void
	{
		$this->likesNumber++;
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

	public function setArticle(Article $article): void
	{
		$this->article = $article;
	}

	public function getArticle(): Article
	{
		return $this->article;
	}

	public function getParent(): Comment
	{
		return $this->parent;
	}

	public function setParent(Comment $parent): void
	{
		$this->parent = $parent;
	}

	public function getLikesNumber(): int
	{
		return $this->likesNumber;
	}

	public function getTime(): DateTimeImmutable
	{
		return $this->time;
	}

	#[Groups('rest')]
	#[SerializedName('time')]
	public function getTimeString(): string
	{
		return $this->time->format('l, d.m.Y H:i');
	}

	/**
	 * @return Comment[]
	 */
	#[Groups('rest')]
	public function getChildren(): array
	{
		return $this->children->toArray();
	}
}
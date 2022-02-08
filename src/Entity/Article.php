<?php

declare(strict_types=1);

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

#[ORM\Entity]
#[ORM\Table('blog_articles')]
class Article
{
	#[ORM\Id]
	#[ORM\Column(type: 'guid')]
	#[Groups('rest')]
	private string $id;

	#[ORM\Column]
	private DateTimeImmutable $time;

	#[ORM\Column]
	#[Groups('rest')]
	private string $title;

	#[ORM\Column]
	#[Groups('rest')]
	private string $content;

	#[ORM\ManyToOne]
	#[Groups('rest')]
	private Author $author;

	#[ORM\ManyToOne]
	#[Groups('rest')]
	#[Context([
		AbstractNormalizer::ATTRIBUTES => ['blog' => ['id']]
	])]
	private Blog $blog;

	#[ORM\OneToMany(mappedBy: 'article', targetEntity: 'Comment', cascade: ['all'])]
	private Collection $comments;

	#[ORM\OneToMany(mappedBy: 'article', targetEntity: 'Like', cascade: ['all'])]
	private Collection $likes;

	public function __construct(string $id, string $title, string $content, Author $author, Blog $blog)
	{
		$this->id = $id;
		$this->title = $title;
		$this->content = $content;
		$this->author = $author;
		$this->blog = $blog;
		$this->comments = new ArrayCollection();
		$this->likes = new ArrayCollection();
		$this->time = new DateTimeImmutable();
	}

	public function addComment(string $content, Author $creator): Comment
	{
		$comment = new Comment(Uuid::uuid4()->toString(), $content, $creator);
		$comment->setArticle($this);
		$this->comments->add($comment);
		return $comment;
	}

	public function doLike(Author $author): void
	{
		$this->likes->add(new Like(Uuid::uuid4()->toString(), $author, $this));
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

	public function getBlog(): Blog
	{
		return $this->blog;
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
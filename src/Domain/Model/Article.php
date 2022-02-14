<?php

declare(strict_types=1);

namespace App\Domain\Model;

use App\Domain\Model\Type\BlogId;
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
	#[ORM\Column(type: 'blog_id')]
	#[Groups('rest')]
	private BlogId $id;

	#[ORM\Column]
	private DateTimeImmutable $publishedAt;

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

	public function __construct(BlogId $id, string $title, string $content, Author $author, Blog $blog)
	{
		$this->id = $id;
		$this->title = $title;
		$this->content = $content;
		$this->author = $author;
		$this->blog = $blog;
		$this->comments = new ArrayCollection();
		$this->likes = new ArrayCollection();
		$this->publishedAt = new DateTimeImmutable();
	}

	public function addComment(string $content, Author $creator): Comment
	{
		$comment = new Comment(Uuid::uuid4()->toString(), $content, $creator);
		$comment->setArticle($this);
		$this->comments->add($comment);
		return $comment;
	}

	public function like(Author $author): void //like
	{
		$this->likes->add(new Like(Uuid::uuid4()->toString(), $author, $this));
	}

	public function getId(): BlogId
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

	public function getPublishedAt(): DateTimeImmutable
	{
		return $this->publishedAt;
	}

	#[Groups('rest')]
	#[SerializedName('time')]
	public function getTimeString(): string
	{
		return $this->publishedAt->format('l, d.m.Y H:i');
	}

	/**
	 * @return Comment[]
	 */
	#[Groups(['rest'])]
	#[SerializedName('comments')]
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
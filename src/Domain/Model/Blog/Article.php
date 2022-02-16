<?php

declare(strict_types=1);

namespace App\Domain\Model\Blog;

use App\Domain\Model\Blog\Type\BlogId;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

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

	#[ORM\Column(nullable: true)]
	private DateTimeImmutable $editedAt;

	#[ORM\Column]
	#[Groups('rest')]
	private string $title;

	#[ORM\Column(type: 'text')]
	#[Groups('rest')]
	private string $content;

	#[ORM\ManyToOne]
	#[Groups('rest')]
	private Author $author;

	#[ORM\OneToMany(mappedBy: 'article', targetEntity: 'Comment', cascade: ['all'])]
	private Collection $comments;

	#[ORM\OneToMany(mappedBy: 'article', targetEntity: 'Like', cascade: ['all'])]
	private Collection $likes;

	public function __construct(BlogId $id, string $title, string $content, Author $author)
	{
		$this->id = $id;
		$this->title = $title;
		$this->content = $content;
		$this->author = $author;
		$this->comments = new ArrayCollection();
		$this->likes = new ArrayCollection();
		$this->publishedAt = new DateTimeImmutable();
	}

	public function addComment(string $content, Author $creator): Comment
	{
		$comment = new Comment(BlogId::generate(), $content, $creator);
		$comment->setArticle($this);
		$this->comments->add($comment);
		return $comment;
	}

	public function like(Author $author): void
	{
		$this->likes->add(new Like(BlogId::generate(), $author, $this));
	}

	public function edit(string $title, string $content): void
	{
		$this->title = $title;
		$this->content = $content;
		$this->editedAt = new DateTimeImmutable();
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

	public function getPublishedAt(): DateTimeImmutable
	{
		return $this->publishedAt;
	}

	#[Groups('rest')]
	#[SerializedName('publishedAt')]
	public function getPublishedAtString(): string
	{
		return $this->publishedAt->format('l, d M Y') . ' at ' . $this->publishedAt->format('H:i');
	}

	#[Groups('rest')]
	#[SerializedName('editedAt')]
	public function getEditedAtString(): string
	{
		return $this->editedAt->format('l, d M Y') . ' at ' . $this->editedAt->format('H:i');
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
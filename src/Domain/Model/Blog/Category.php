<?php
declare(strict_types=1);

namespace App\Domain\Model\Blog;

use App\Domain\Model\Blog\Type\BlogId;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
#[ORM\Table(name: 'blog_category')]
class Category
{
    #[ORM\Id]
    #[ORM\Column(type: 'blog_id')]
	#[Groups('rest')]
    private BlogID $id;

    #[ORM\Column]
	#[Groups('rest')]
    private string $name;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: 'Blog')]
    private Collection $blogs;

    public function __construct(BlogId $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
        $this->blogs = new ArrayCollection();
    }

    public function getId(): BlogId
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

	/**
	 * @return Blog[]
	 */
    public function getBlogs(): array
    {
        return $this->blogs->toArray();
    }
}
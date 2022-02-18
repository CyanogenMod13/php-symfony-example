<?php
declare(strict_types=1);

namespace App\Domain\Model\Blog;

use App\Domain\Model\Blog\Type\BlogId;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
#[ORM\Table(name: 'blog_authors')]
class Author
{
    #[ORM\Id]
    #[ORM\Column(type: 'blog_id')]
    private BlogId $id;

	#[ORM\Embedded(columnPrefix: false)]
    private AuthorInfo $name;

    public function __construct(BlogId $id, AuthorInfo $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

	#[Groups('rest')]
    public function getId(): BlogId
    {
        return $this->id;
    }

	#[Groups('rest')]
    public function getFirstName(): string
    {
        return $this->name->getFirstName();
    }

	#[Groups('rest')]
    public function getLastName(): string
    {
        return $this->name->getLastName();
    }

	#[Groups('rest')]
    public function getPenName(): string
    {
        return $this->name->getPenName();
    }

	public function getName(): AuthorInfo
	{
		return $this->name;
	}
}
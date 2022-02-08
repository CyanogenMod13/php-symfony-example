<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
#[ORM\Table(name: 'blog_authors')]
class Author
{
    #[ORM\Id]
    #[ORM\Column(type: 'guid')]
    private string $id;

	#[ORM\Embedded(columnPrefix: false)]
    private AuthorInfo $name;

    #[ORM\OneToOne(mappedBy: 'author')]
    private Blog $blog;

    public function __construct(
        string $id,
        AuthorInfo $name,
        Blog $blog
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->blog = $blog;
    }

	#[Groups('rest')]
    public function getId(): string
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

    public function getBlog(): Blog
    {
        return $this->blog;
    }
}
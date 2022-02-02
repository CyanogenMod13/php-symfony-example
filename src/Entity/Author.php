<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'blog_authors')]
class Author
{
    #[ORM\Id]
    #[ORM\Column(type: 'guid')]
    private string $id;

    #[ORM\Column]
    private string $firstName;

    #[ORM\Column]
    private string $lastName;

    #[ORM\Column]
    private string $penName;

    #[ORM\OneToOne(mappedBy: 'author')]
    private Blog $blog;

    /**
     * @param string $id
     * @param string $firstName
     * @param string $lastName
     * @param string $penName
     * @param Blog $blog
     */
    public function __construct(
        string $id,
        string $firstName,
        string $lastName,
        string $penName,
        Blog $blog
    )
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->penName = $penName;
        $this->blog = $blog;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getPenName(): string
    {
        return $this->penName;
    }

    /**
     * @return Blog
     */
    public function getBlog(): Blog
    {
        return $this->blog;
    }
}
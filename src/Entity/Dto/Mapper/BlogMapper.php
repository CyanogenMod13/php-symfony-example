<?php

namespace App\Entity\Dto\Mapper;

use App\Entity\Blog;
use App\Entity\Category;
use App\Entity\Dto\AuthorDTO;
use App\Entity\Dto\BlogDTO;

class BlogMapper
{
    /**
     * @param Blog $blog
     * @return BlogDTO
     */
    public function toDto(Blog $blog): BlogDTO
    {
        $author = $blog->getAuthor();
        return new BlogDTO(
            $blog->getName(),
            $blog->getAlias(),
            new AuthorDTO(
                $author->getFirstName(),
                $author->getLastName(),
                $author->getPenName()
            ),
            $blog->getCategory()->getId()
        );
    }

    /**
     * @param string $blogId
     * @param string $authorId
     * @param Category $category
     * @param BlogDTO $blogDTO
     * @return Blog
     */
    public function map(string $blogId, string $authorId, Category $category, BlogDTO $blogDTO): Blog
    {
        return new Blog(
            $blogId,
            $blogDTO->name,
            $blogDTO->alias,
            $authorId,
            $blogDTO->author->firstName,
            $blogDTO->author->lastName,
            $blogDTO->author->penName,
            $category
        );
    }
}
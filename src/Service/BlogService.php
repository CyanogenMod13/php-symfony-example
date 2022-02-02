<?php

namespace App\Service;

use App\Entity\Blog;
use App\Entity\Dto\AuthorDTO;
use App\Entity\Dto\BlogDTO;
use App\Entity\Dto\BlogEditDataDTO;
use App\Entity\Dto\Mapper\BlogMapper;
use App\Repository\AuthorNotFoundException;
use App\Repository\AuthorRepository;
use App\Repository\BlogNotFoundException;
use App\Repository\BlogRepository;
use App\Repository\CategoryNotFoundException;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;

class BlogService
{
    private BlogMapper $blogMapper;

    public function __construct(
        private EntityManagerInterface $entityManager,
        private BlogRepository $blogRepository,
        private CategoryRepository $categoryRepository,
        private AuthorRepository $authorRepository
    )
    {
        $this->blogMapper = new BlogMapper();
    }

    /**
     * @param string $blogId
     * @return BlogDTO
     * @throws BlogNotFoundException
     */
    public function getBlogData(string $blogId): BlogDTO
    {
        $blog = $this->blogRepository->get($blogId);
        return $this->blogMapper->toDto($blog);
    }

    /**
     * @return BlogDTO[]
     */
    public function getAllBlogs(): array
    {
        $blogDTOs = [];
        $blogs = $this->blogRepository->getAll();
        foreach ($blogs as $blog) {
            $blogDTOs[] = $this->blogMapper->toDto($blog);
        }
        return $blogDTOs;
    }

    /**
     * @param string $authorId
     * @return BlogDTO
     * @throws AuthorNotFoundException
     */
    public function getByAuthor(string $authorId): BlogDTO
    {
        $author = $this->authorRepository->get($authorId);
        return $this->blogMapper->toDto(
            $this->blogRepository->getByAuthor($author)
        );
    }

    /**
     * @param string $categoryId
     * @return Blog[]
     * @throws CategoryNotFoundException
     */
    public function getByCategory(string $categoryId): array
    {
        $category = $this->categoryRepository->get($categoryId);
        $blogs = $this->blogRepository->getByCategory($category);
        $blogDTOs = [];
        foreach ($blogs as $blog) {
            $blogDTOs[] = $this->blogMapper->toDto($blog);
        }
        return $blogDTOs;
    }

    /**
     * @param string $userId
     * @param BlogDTO $blogDTO
     * @return string
     * @throws CategoryNotFoundException
     */
    public function saveBlog(string $userId, BlogDTO $blogDTO): string
    {
        $blogId = Uuid::uuid4()->toString();
        $category = $this->categoryRepository->get($blogDTO->categoryId);

        $blog = $this->blogMapper->map($blogId, $userId, $category, $blogDTO);
        $this->blogRepository->add($blog);

        return $blogId;
    }

    /**
     * @param string $blogId
     * @param BlogEditDataDTO $dataDTO
     * @return void
     * @throws BlogNotFoundException
     */
    public function editBlog(string $blogId, BlogEditDataDTO $dataDTO): void
    {
        $blog = $this->blogRepository->get($blogId);
        $blog->edit($dataDTO->name, $dataDTO->alias);
        $this->entityManager->flush();
    }

    /**
     * @param string $blogId
     * @return void
     * @throws BlogNotFoundException
     */
    public function removeBlog(string $blogId): void
    {
        $blog = $this->blogRepository->get($blogId);
        $this->blogRepository->remove($blog);
    }
}
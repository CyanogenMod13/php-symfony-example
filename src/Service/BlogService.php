<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Blog;
use App\Entity\Dto\BlogCreateDTO;
use App\Entity\Dto\BlogDTO;
use App\Entity\Dto\BlogEditDataDTO;
use App\Repository\BlogNotFoundException;
use App\Repository\BlogRepository;
use App\Repository\CategoryNotFoundException;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;

class BlogService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private BlogRepository $blogRepository,
        private CategoryRepository $categoryRepository,
    )
    {}

    /**
     * @param string $blogId
     * @return BlogDTO
     * @throws BlogNotFoundException
     */
    public function getBlogData(string $blogId): BlogDTO
    {
        $blog = $this->blogRepository->get($blogId);
        return BlogDTO::toDto($blog);
    }

    /**
     * @return BlogDTO[]
     */
    public function getAllBlogs(): array
    {
        $blogDTOs = [];
        $blogs = $this->blogRepository->getAll();
        foreach ($blogs as $blog) {
            $blogDTOs[] = BlogDTO::toDto($blog);
        }
        return $blogDTOs;
    }

    /**
     * @param BlogCreateDTO $blogCreateDTO
     * @return string
     * @throws CategoryNotFoundException
     */
    public function saveBlog(BlogCreateDTO $blogCreateDTO): string
    {
        $blogId = Uuid::uuid4()->toString();
        $category = $this->categoryRepository->get($blogCreateDTO->categoryId);

        $blog = new Blog(
            $blogId,
            $blogCreateDTO->name,
            $blogCreateDTO->alias,
            $blogCreateDTO->userId,
            $blogCreateDTO->author->firstName,
            $blogCreateDTO->author->lastName,
            $blogCreateDTO->author->penName,
            $category
        );
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
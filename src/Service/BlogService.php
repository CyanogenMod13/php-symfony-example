<?php
declare(strict_types=1);

namespace App\Service;

use App\Controller\Json\Data\BlogCreateData;
use App\Controller\Json\Data\BlogEditData;
use App\Entity\Blog;
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
    ) {}

    /**
     * @throws BlogNotFoundException
     */
    public function getBlogData(string $blogId): Blog
    {
        return $this->blogRepository->get($blogId);
    }

    /**
     * @return Blog[]
     */
    public function getAllBlogs(): array
    {
        return $this->blogRepository->getAll();
    }

    /**
     * @throws CategoryNotFoundException
     */
    public function saveBlog(BlogCreateData $blogCreateDTO): string
    {
        $blogId = Uuid::uuid4()->toString();
        $category = $this->categoryRepository->get($blogCreateDTO->categoryId);

        $blog = new Blog(
            $blogId,
            $blogCreateDTO->name,
            $blogCreateDTO->alias,
            $blogCreateDTO->userId,
            $blogCreateDTO->author,
            $category
        );
        $this->blogRepository->add($blog);

        return $blogId;
    }

	/**
	 * @throws BlogNotFoundException
	 * @throws CategoryNotFoundException
	 */
    public function editBlog(string $blogId, BlogEditData $dataDTO): void
    {
        $blog = $this->blogRepository->get($blogId);
		$category = $this->categoryRepository->get($dataDTO->categoryId);
        $blog->edit($dataDTO->name, $dataDTO->alias, $category);
        $this->entityManager->flush();
    }

    /**
     * @throws BlogNotFoundException
     */
    public function removeBlog(string $blogId): void
    {
        $blog = $this->blogRepository->get($blogId);
        $this->blogRepository->remove($blog);
    }
}
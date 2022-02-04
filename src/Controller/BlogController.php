<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\Json\Data\BlogCreateData;
use App\Controller\Json\Data\BlogEditData;
use App\Repository\BlogNotFoundException;
use App\Repository\CategoryNotFoundException;
use App\Service\BlogService;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/blog')]
class BlogController extends AbstractController
{
    public function __construct(
        private BlogService $blogService,
        private SerializerInterface $serializer
    ) {}

    #[Route('/', methods: 'GET')]
    public function getAll(): Response
    {
        $blogs = $this->blogService->getAllBlogs();
        return $this->json($blogs, context: ['groups' => ['rest']]);
    }

    #[Route('/create', methods: 'POST')]
    public function createBlog(Request $request): Response
    {
        $blogCreateDTO = $this->serializer->deserialize(
            $request->getContent(),
            BlogCreateData::class,
            'json'
        );

        try {
            $resultBlogId = $this->blogService->saveBlog($blogCreateDTO);
            return $this->json(['blogId' => $resultBlogId], Response::HTTP_CREATED);
        } catch (CategoryNotFoundException $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }

    #[Route('/{id}', methods: 'GET')]
    public function getBlog(string $id): Response
    {
        try {
            $blog = $this->blogService->getBlogData($id);
			return $this->json($blog, context: ['groups' => ['rest']]);
        } catch (BlogNotFoundException $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }

    #[Route('/{id}/edit', methods: 'PUT')]
    public function editBlog(Request $request, string $id): Response
    {
        $blogEditDTO = $this->serializer->deserialize(
            $request->getContent(),
            BlogEditData::class,
            'json'
        );
        try {
            $this->blogService->editBlog($id, $blogEditDTO);
            return $this->json([], Response::HTTP_ACCEPTED);
        } catch (EntityNotFoundException $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }

    #[Route('/{id}/delete', methods: 'DELETE')]
    public function removeBlog(string $id): Response
    {
        try {
            $this->blogService->removeBlog($id);
            return $this->json([]);
        } catch (BlogNotFoundException $e) {
            return $this->json(['warning' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }
}
<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\Json\Data\ArticleCreateData;
use App\Controller\Json\Data\BlogCreateData;
use App\Controller\Json\Data\BlogEditData;
use App\Entity\Author;
use App\Entity\Blog;
use App\Repository\BlogNotFoundException;
use App\Repository\CategoryNotFoundException;
use App\Service\ArticlePublisherService;
use App\Service\BlogService;
use Doctrine\ORM\EntityNotFoundException;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/blog')]
class BlogController extends AbstractController
{
    public function __construct(
        private BlogService $blogService,
		private ArticlePublisherService $articlePublisherService,
        private SerializerInterface $serializer
    ) {}

    #[Route('/', methods: 'GET')]
    public function getAll(): Response
    {
        $blogs = $this->blogService->getAllBlogs();
        return $this->json($blogs, context: [AbstractNormalizer::GROUPS => ['rest']]);
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
			return $this->json($blog, context: [AbstractNormalizer::GROUPS => ['rest']]);
        } catch (BlogNotFoundException $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }

    #[Route('/{id}/edit', methods: 'PUT')]
    public function editBlog(Request $request, string $id): Response
    {
        $blogEditData = $this->serializer->deserialize(
            $request->getContent(),
            BlogEditData::class,
            'json'
        );
        try {
            $this->blogService->editBlog($id, $blogEditData);
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

	#[Route('/{id}/articles', methods: ['GET'])]
	public function getArticles(string $id): Response
	{
		try {
			$blog = $this->blogService->getBlogData($id);
			$articles = $blog->getArticles();
			return $this->json($articles, context: [
				AbstractNormalizer::GROUPS => ['rest'],
				AbstractNormalizer::IGNORED_ATTRIBUTES => ['content']
			]);
		} catch (BlogNotFoundException $e) {
			return $this->json(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
		}
	}

	#[Route('/{id}/publish', methods: ['POST'])]
	public function publishArticle(string $id, Request $request): Response
	{
		try {
			$articleCreateData = $this->serializer->deserialize(
				$request->getContent(),
				ArticleCreateData::class,
				'json');

			$blog = $this->blogService->getBlogData($id);
			$article = $this->articlePublisherService->publishArticle($articleCreateData, $blog);
			return $this->json(['articleId' => $article->getId()], Response::HTTP_CREATED);
		} catch (EntityNotFoundException $e) {
			return $this->json(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
		}
	}
}
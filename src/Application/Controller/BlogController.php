<?php
declare(strict_types=1);

namespace App\Application\Controller;

use App\Application\Commands\ArticlePublishCommand;
use App\Application\Commands\BlogCreateCommand;
use App\Application\Commands\BlogEditCommand;
use App\Application\Commands\Handler\ArticlePublisherHandle;
use App\Application\Commands\Handler\BlogCreateHandler;
use App\Application\Commands\Handler\BlogEditHandler;
use App\Domain\Model\Type\BlogId;
use App\Domain\Repository\BlogRepositoryInterface;
use App\Domain\Repository\Exception\BlogNotFoundException;
use App\Domain\Repository\Exception\CategoryNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/blogs')]
class BlogController extends AbstractController
{
    public function __construct(
		private BlogRepositoryInterface $blogRepository,
        private SerializerInterface $serializer
    ) {}

    #[Route('/', methods: 'GET')]
    public function getAll(): Response
    {
        $blogs = $this->blogRepository->getAll();
        return $this->json($blogs, context: [AbstractNormalizer::GROUPS => ['rest']]);
    }

    #[Route('/create', methods: 'POST')]
    public function createBlog(Request $request, BlogCreateHandler $blogCreateHandler): Response
    {
        $blogCreateCommand = $this->serializer->deserialize(
            $request->getContent(),
            BlogCreateCommand::class,
            'json'
        );

        try {
            $resultBlogId = $blogCreateHandler->handle($blogCreateCommand);
            return $this->json(['blogId' => $resultBlogId], Response::HTTP_CREATED);
        } catch (CategoryNotFoundException $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }

    #[Route('/{id}', methods: 'GET')]
    public function getBlog(string $id): Response
    {
        try {
            $blog = $this->blogRepository->get(BlogId::generate($id));
			return $this->json($blog, context: [AbstractNormalizer::GROUPS => ['rest']]);
        } catch (BlogNotFoundException $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }

    #[Route('/{id}/edit', methods: 'PUT')]
    public function editBlog(string $id, Request $request, BlogEditHandler $blogEditHandler): Response
    {
        $blogEditCommand = $this->serializer->deserialize(
            $request->getContent(),
            BlogEditCommand::class,
            'json'
        );
		$blogEditCommand->blogId = $id;
        try {
            $blogEditHandler->handle($blogEditCommand);
            return $this->json([], Response::HTTP_ACCEPTED);
        } catch (\DomainException $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }

    #[Route('/{id}/delete', methods: 'DELETE')]
    public function removeBlog(string $id): Response
    {
        try {
			$blog = $this->blogRepository->get(BlogID::generate($id));
			$this->blogRepository->remove($blog);
            return $this->json([]);
        } catch (BlogNotFoundException $e) {
            return $this->json(['warning' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }

	#[Route('/{id}/articles', methods: ['GET'])]
	public function getArticles(string $id): Response
	{
		try {
			$blog = $this->blogRepository->get(BlogId::generate($id));
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
	public function publishArticle(string $id, Request $request, ArticlePublisherHandle $articlePublisherHandle): Response
	{
		try {
			$articlePublishCommand = $this->serializer->deserialize(
				$request->getContent(),
				ArticlePublishCommand::class,
				'json');

			$articlePublishCommand->blogId = $id;
			$article = $articlePublisherHandle->handle($articlePublishCommand);
			return $this->json(['articleId' => $article->getId()], Response::HTTP_CREATED);
		} catch (\DomainException $e) {
			return $this->json(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
		}
	}
}
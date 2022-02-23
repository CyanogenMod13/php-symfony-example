<?php
declare(strict_types=1);

namespace App\Application\Controller\Blog;

use App\Application\Commands\BlogCreateCommand;
use App\Application\Commands\BlogEditCommand;
use App\Application\Commands\Handler\BlogCreateHandler;
use App\Application\Commands\Handler\BlogEditHandler;
use App\Domain\Model\Blog\Type\BlogId;
use App\Domain\Repository\BlogRepositoryInterface;
use Psr\Log\LoggerInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route(['/blogs', '/api/blogs'])]
class BlogController extends AbstractController
{
    public function __construct(
		private BlogRepositoryInterface $blogRepository,
        private SerializerInterface $serializer,
		private ValidatorInterface $validator
    ) {}

    #[Route('/', methods: 'GET')]
    public function getAll(LoggerInterface $logger): Response
    {
		$user = $this->getUser();
		if (!is_null($user)) {
			$logger->info($user->getUserIdentifier());
		} else {
			$logger->info('User is null');
		}

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

		$violations = $this->validator->validate($blogCreateCommand);
		if ($violations->count() > 0) {
			throw new BadRequestException();
		}

		$resultBlogId = $blogCreateHandler->handle($blogCreateCommand);
		return $this->json(['blogId' => $resultBlogId], Response::HTTP_CREATED);
    }

    #[Route('/{id}', methods: 'GET')]
    public function getBlog(string $id): Response
    {
		if (!Uuid::isValid($id)) {
			throw new BadRequestException();
		}
		$blog = $this->blogRepository->get(BlogId::generate($id));
		return $this->json($blog, context: [AbstractNormalizer::GROUPS => ['rest']]);
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

		$violations = $this->validator->validate($blogEditCommand);
		if ($violations->count() > 0) {
			throw new BadRequestException();
		}

		$blogEditHandler->handle($blogEditCommand);
		return $this->json([], Response::HTTP_ACCEPTED);
    }

    #[Route('/{id}/delete', methods: 'DELETE')]
    public function removeBlog(string $id): Response
    {
		if (!Uuid::isValid($id)) {
			throw new BadRequestException();
		}

		$blog = $this->blogRepository->get(BlogID::generate($id));
		$this->blogRepository->remove($blog);
		return $this->json([]);
    }

	#[Route('/{id}/articles', methods: ['GET'])]
	public function getArticles(string $id): Response
	{
		if (!Uuid::isValid($id)) {
			throw new BadRequestException();
		}

		$blog = $this->blogRepository->get(BlogId::generate($id));
		$articles = $blog->getArticles();
		return $this->json($articles, context: [
			AbstractNormalizer::GROUPS => ['rest'],
			AbstractNormalizer::IGNORED_ATTRIBUTES => ['content']
		]);
	}
}
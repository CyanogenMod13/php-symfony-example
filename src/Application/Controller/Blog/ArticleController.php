<?php

declare(strict_types=1);

namespace App\Application\Controller\Blog;

use App\Application\Commands\ArticleEditCommand;
use App\Application\Commands\ArticlePublishCommand;
use App\Application\Commands\Handler\ArticleEditHandler;
use App\Application\Commands\Handler\ArticlePublisherHandler;
use App\Domain\Model\Blog\Type\BlogId;
use App\Domain\Repository\ArticleRepositoryInterface;
use OpenApi\Attributes as OA;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/articles')]
class ArticleController extends AbstractController
{
	public function __construct(
		private ArticleRepositoryInterface $articleRepository,
		private SerializerInterface $serializer,
		private ValidatorInterface $validator
	) {}

	#[Route('/', methods: ['GET'])]
	public function getAll(): Response
	{
		return $this->json(
			$this->articleRepository->getAll(),
			context: [
				AbstractNormalizer::GROUPS => ['rest'],
				AbstractNormalizer::IGNORED_ATTRIBUTES => ['content', 'comments']
			]
		);
	}

	#[Route('/{id}', methods: ['GET'])]
	public function getArticle(string $id): Response
	{
		if (!Uuid::isValid($id)) {
			throw new BadRequestException();
		}

		$article = $this->articleRepository->get(BlogId::generate($id));
		return $this->json($article, context: [AbstractNormalizer::GROUPS => ['rest']]);
	}

	#[Route('/{id}/comments', methods: ['GET'])]
	public function getComments(string $id): Response
	{
		if (!Uuid::isValid($id)) {
			throw new BadRequestException();
		}

		$article = $this->articleRepository->get(BlogId::generate($id));
		$comments = $article->getComments();
		return $this->json($comments, context: [AbstractNormalizer::GROUPS => ['rest']]);
	}

	#[Route('/publish', methods: ['POST'])]
	public function publishArticle(Request $request, ArticlePublisherHandler $articlePublisherHandle): Response
	{
		$articlePublishCommand = $this->serializer->deserialize(
			$request->getContent(),
			ArticlePublishCommand::class,
			'json');

		$violations = $this->validator->validate($articlePublishCommand);
		if ($violations->count() > 0) {
			throw new BadRequestException();
		}

		$article = $articlePublisherHandle->handle($articlePublishCommand);
		return $this->json(['articleId' => $article->getId()], Response::HTTP_CREATED);
	}

	#[Route('/{id}/edit', methods: ['PUT'])]
	public function editArticle(string $id, Request $request, ArticleEditHandler $articleEditHandler): Response
	{
		$user = $this->getUser();

		$articleEditCommand = $this->serializer->deserialize(
			$request->getContent(),
			ArticleEditCommand::class,
			'json'
		);
		$articleEditCommand->articleId = $id;

		$violations = $this->validator->validate($articleEditCommand);
		if ($violations->count() > 0) {
			throw new BadRequestException();
		}

		$articleEditHandler->handle($articleEditCommand);
		return $this->json([], Response::HTTP_ACCEPTED);
	}
}
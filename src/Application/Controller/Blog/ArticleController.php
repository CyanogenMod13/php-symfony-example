<?php

declare(strict_types=1);

namespace App\Application\Controller\Blog;

use App\Application\Commands\ArticleEditCommand;
use App\Application\Commands\ArticlePublishCommand;
use App\Application\Commands\Handler\ArticleEditHandler;
use App\Application\Commands\Handler\ArticlePublisherHandler;
use App\Domain\Model\Blog\Article;
use App\Domain\Model\Blog\Type\BlogId;
use App\Domain\Model\Security\User;
use App\Domain\Repository\ArticleRepositoryInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route(['/articles', '/api/articles'])]
class ArticleController extends AbstractController
{
	public function __construct(
		private ArticleRepositoryInterface $articleRepository,
		private SerializerInterface $serializer,
		private ValidatorInterface $validator
	) {}

	#[OA\Response(response: Response::HTTP_OK, description: 'return all existing articles')]
	#[Route('/', methods: ['GET'])]
	public function getAll(): Response
	{
		$response = $this->json(
			$this->articleRepository->getAll(),
			context: [
				AbstractNormalizer::GROUPS => ['rest'],
				AbstractNormalizer::IGNORED_ATTRIBUTES => ['content', 'comments']
			]
		);
		$response->headers->setCookie(
			new Cookie('username', 'user', (new \DateTimeImmutable())->add(\DateInterval::createFromDateString('7 day')))
		);
		return $response;
	}

	#[OA\Response(
		response: Response::HTTP_OK,
		description: 'return article by id',
		content: new OA\JsonContent(example: '{ "id": "e0656882-4a1b-400a-b10a-115eca8957b6", "title": "Article 2020", "content": "Content", "author": { "id": "e7ffab99-b7cb-495f-a608-b3dec3763e30", "firstName": "I", "lastName": "am", "penName": "zxxc" }, "comments": [ { "id": "b101765e-2ef9-44ec-81ef-0c8a0f1828c3", "content": "Cool!", "author": { "id": "e7ffab99-b7cb-495f-a608-b3dec3763e30", "firstName": "I", "lastName": "am", "penName": "zxxc" }, "children": [ { "id": "4beacd34-37dd-4b62-b6e6-8f0e5da1f963", "content": "+", "author": { "id": "70dfd1c2-2c33-453d-bb1f-0fa1effc6dc3", "firstName": "Q", "lastName": "M", "penName": "qwerty3" }, "children": [], "likesNumber": 2, "time": "Tuesday, 08.02.2022 15:35" }, { "id": "4beacd34-37dd-4b62-b6e6-8f0e5db1f963", "content": "++++", "author": { "id": "70dfd1c2-2c33-453d-bb1f-0fa1effc6dc3", "firstName": "Q", "lastName": "M", "penName": "qwerty3" }, "children": [], "likesNumber": 2, "time": "Tuesday, 08.02.2022 15:35" } ], "likesNumber": 2, "time": "Tuesday, 08.02.2022 15:35" }, { "id": "b101765e-2ef9-44ec-81ef-0c8a0f1838c3", "content": "aaaaaaaaaaaa", "author": { "id": "e7ffab99-b7cb-495f-a608-b3dec3763e30", "firstName": "I", "lastName": "am", "penName": "zxxc" }, "children": [], "likesNumber": 2, "time": "Tuesday, 08.02.2022 15:35" } ], "publishedAt": "Tuesday, 08 Feb 2022 at 15:34", "editedAt": "Thursday, 17 Feb 2022 at 13:54" }')
	)]
	#[OA\Parameter(
		name: 'id',
		description: 'id of existing article',
		in: 'path',
		required: true,
		schema: new OA\Schema(type: 'UUID')
	)]
	#[Route('/{id}', methods: ['GET'])]
	public function getArticle(string $id): Response
	{
		if (!Uuid::isValid($id)) {
			throw new BadRequestException();
		}

		$article = $this->articleRepository->get(BlogId::generate($id));
		return $this->json($article, context: [AbstractNormalizer::GROUPS => ['rest']]);
	}

	#[OA\Response(
		response: Response::HTTP_OK,
		description: 'return comments on article in hierarchically order like a tree',
		content: new OA\JsonContent(example: '[ { "id": "b101765e-2ef9-44ec-81ef-0c8a0f1828c3", "content": "Cool!", "author": { "id": "e7ffab99-b7cb-495f-a608-b3dec3763e30", "firstName": "I", "lastName": "am", "penName": "zxxc" }, "children": [ { "id": "4beacd34-37dd-4b62-b6e6-8f0e5da1f963", "content": "+", "author": { "id": "70dfd1c2-2c33-453d-bb1f-0fa1effc6dc3", "firstName": "Q", "lastName": "M", "penName": "qwerty3" }, "children": [], "likesNumber": 2, "time": "Tuesday, 08.02.2022 15:35" }, { "id": "4beacd34-37dd-4b62-b6e6-8f0e5db1f963", "content": "++++", "author": { "id": "70dfd1c2-2c33-453d-bb1f-0fa1effc6dc3", "firstName": "Q", "lastName": "M", "penName": "qwerty3" }, "children": [], "likesNumber": 2, "time": "Tuesday, 08.02.2022 15:35" } ], "likesNumber": 2, "time": "Tuesday, 08.02.2022 15:35" }, { "id": "b101765e-2ef9-44ec-81ef-0c8a0f1838c3", "content": "aaaaaaaaaaaa", "author": { "id": "e7ffab99-b7cb-495f-a608-b3dec3763e30", "firstName": "I", "lastName": "am", "penName": "zxxc" }, "children": [], "likesNumber": 2, "time": "Tuesday, 08.02.2022 15:35" } ]')
	)]
	#[OA\Parameter(
		name: 'id',
		description: 'article id',
		in: 'path',
		required: true,
		schema: new OA\Schema(type: 'UUID')
	)]
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
			'json'
		);

		$user = $this->getUser();
		if (!($user instanceof User)) {
			throw new UnauthorizedHttpException('user-token');
		}

		$articlePublishCommand->authorId = $user->getId();

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
		$articleEditCommand = $this->serializer->deserialize(
			$request->getContent(),
			ArticleEditCommand::class,
			'json'
		);
		$articleEditCommand->articleId = $id;

		$user = $this->getUser();
		if (!($user instanceof User)) {
			throw new UnauthorizedHttpException('user-token');
		}

		$articleEditCommand->authorId = $user->getId();

		$violations = $this->validator->validate($articleEditCommand);
		if ($violations->count() > 0) {
			throw new BadRequestException();
		}

		$articleEditHandler->handle($articleEditCommand);
		return $this->json([], Response::HTTP_ACCEPTED);
	}
}
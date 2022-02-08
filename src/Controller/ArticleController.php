<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Comment;
use App\Repository\ArticleNotFoundException;
use App\Service\ArticleService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

#[Route('/article')]
class ArticleController extends AbstractController
{
	public function __construct(
		private ArticleService $articleService
	) {}

	#[Route('/', methods: ['GET'])]
	public function getAll(): Response
	{
		return $this->json(
			$this->articleService->getAllArticle(),
			context: [
				AbstractNormalizer::GROUPS => ['rest'],
				AbstractNormalizer::IGNORED_ATTRIBUTES => ['content']
			]
		);
	}

	#[Route('/{id}', methods: ['GET'])]
	public function getArticle(string $id): Response
	{
		try {
			$article = $this->articleService->getArticle($id);
			return $this->json($article, context: [AbstractNormalizer::GROUPS => ['rest']]);
		} catch (ArticleNotFoundException $e) {
			return $this->json(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
		}
	}

	#[Route('/{id}/comments', methods: ['GET'])]
	public function getComments(string $id): Response
	{
		try {
			$article = $this->articleService->getArticle($id);
			$comments = $article->getComments();
			return $this->json($comments, context: [AbstractNormalizer::GROUPS => ['rest']]);
		} catch (ArticleNotFoundException $e) {
			return $this->json(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
		}
	}
}
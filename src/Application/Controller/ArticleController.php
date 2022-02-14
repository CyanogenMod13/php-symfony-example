<?php

declare(strict_types=1);

namespace App\Application\Controller;

use App\Domain\Repository\ArticleRepositoryInterface;
use App\Domain\Repository\Exception\ArticleNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

#[Route('/articles')]
class ArticleController extends AbstractController
{
	public function __construct(
		private ArticleRepositoryInterface $articleRepository
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
		try {
			$article = $this->articleRepository->get($id);
			return $this->json($article, context: [AbstractNormalizer::GROUPS => ['rest']]);
		} catch (ArticleNotFoundException $e) {
			return $this->json(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
		}
	}

	#[Route('/{id}/comments', methods: ['GET'])]
	public function getComments(string $id): Response
	{
		try {
			$article = $this->articleRepository->get($id);
			$comments = $article->getComments();
			return $this->json($comments, context: [AbstractNormalizer::GROUPS => ['rest']]);
		} catch (ArticleNotFoundException $e) {
			return $this->json(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
		}
	}
}
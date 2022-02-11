<?php
declare(strict_types=1);

namespace App\Application\Controller;

use App\Domain\Repository\AuthorRepositoryInterface;
use App\Domain\Repository\Exception\AuthorNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

#[Route('/author')]
class AuthorController extends AbstractController
{
	public function __construct(
		private AuthorRepositoryInterface $authorRepository
	) {}

	#[Route('/', methods: ['GET'])]
	public function getAll(): Response
	{
		return $this->json(
			$this->authorRepository->getAll(),
			context: [AbstractNormalizer::GROUPS => ['rest']]
		);
	}

	#[Route('/{id}', methods: ['GET'])]
	public function getAuthor(string $id): Response
	{
		try {
			return $this->json(
				$this->authorRepository->get($id),
				context: [AbstractNormalizer::GROUPS => ['rest']]
			);
		} catch (AuthorNotFoundException $e) {
			return $this->json(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
		}
	}

	#[Route('/{id}/blog', methods: ['GET'])]
	public function getBlog(string $id): Response
	{
		try {
			return $this->json(
				$this->authorRepository->get($id)->getBlog(),
				context: [AbstractNormalizer::GROUPS => ['rest']]
			);
		} catch (AuthorNotFoundException $e) {
			return $this->json(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
		}
	}
}
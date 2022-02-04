<?php
declare(strict_types=1);

namespace App\Controller;

use App\Repository\AuthorNotFoundException;
use App\Service\AuthorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/author')]
class AuthorController extends AbstractController
{
	public function __construct(
		private AuthorService $authorService,
	) {}

	#[Route('/', methods: ['GET'])]
	public function getAll(): Response
	{
		return $this->json($this->authorService->getAllAuthor(), context: ['groups' => ['rest']]);
	}

	#[Route('/{id}', methods: ['GET'])]
	public function getAuthor(string $id): Response
	{
		try {
			return $this->json($this->authorService->getAuthorData($id), context: ['groups' => ['rest']]);
		} catch (AuthorNotFoundException $e) {
			return $this->json(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
		}
	}

	#[Route('/{id}/blog', methods: ['GET'])]
	public function getBlog(string $id): Response
	{
		try {
			return $this->json($this->authorService->getBlogByAuthor($id), context: ['groups' => ['rest']]);
		} catch (AuthorNotFoundException $e) {
			return $this->json(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
		}
	}
}
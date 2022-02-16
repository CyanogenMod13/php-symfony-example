<?php
declare(strict_types=1);

namespace App\Application\Controller\Blog;

use App\Domain\Model\Blog\Type\BlogId;
use App\Domain\Repository\AuthorRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

#[Route('/authors')]
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
		if (!Uuid::isValid($id)) {
			throw new BadRequestException();
		}

		return $this->json(
			$this->authorRepository->get(BlogId::generate($id)),
			context: [AbstractNormalizer::GROUPS => ['rest']]
		);
	}

	#[Route('/{id}/blog', methods: ['GET'])]
	public function getBlog(string $id): Response
	{
		if (!Uuid::isValid($id)) {
			throw new BadRequestException();
		}

		return $this->json(
			$this->authorRepository->get(BlogId::generate($id))->getBlog(),
			context: [AbstractNormalizer::GROUPS => ['rest']]
		);
	}
}
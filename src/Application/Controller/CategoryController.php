<?php
declare(strict_types=1);

namespace App\Application\Controller;

use App\Application\Commands\CategoryCreateCommand;
use App\Application\Commands\Handler\CategoryCreateHandler;
use App\Domain\Repository\CategoryRepositoryInterface;
use App\Domain\Repository\Exception\CategoryNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/category')]
class CategoryController extends AbstractController
{
	public function __construct(
		private CategoryRepositoryInterface $categoryRepository,
		private SerializerInterface $serializer
	) {}

	#[Route('/create', methods: ['POST'])]
	public function createCategory(Request $request, CategoryCreateHandler $categoryCreateHandler): Response
	{
		$categoryData = $this->serializer->deserialize(
			$request->getContent(),
			CategoryCreateCommand::class,
			'json'
		);
		$categoryId = $categoryCreateHandler->handle($categoryData);
		return $this->json(['categoryId' => $categoryId], Response::HTTP_CREATED);
	}

	#[Route('/{id}', methods: ['GET'])]
	public function getCategory(string $id): Response
	{
		try {
			return $this->json(
				$this->categoryRepository->get($id),
				context: [AbstractNormalizer::GROUPS => ['rest']]
			);
		} catch (CategoryNotFoundException $e) {
			return $this->json(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
		}
	}

	#[Route('/', methods: ['GET'])]
	public function getAll(): Response
	{
		return $this->json(
			$this->categoryRepository->getAll(),
			context: [AbstractNormalizer::GROUPS => ['rest']]
		);
	}

	#[Route('/{id}/blog',methods: ['GET'])]
	public function getBlogByCategory(string $id): Response
	{
		try {
			return $this->json(
				$this->categoryRepository->get($id)->getBlogs(),
				context: [AbstractNormalizer::GROUPS => ['rest']]
			);
		} catch (CategoryNotFoundException $e) {
			return $this->json(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
		}
	}
}
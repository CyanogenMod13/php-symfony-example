<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Dto\CategoryDTO;
use App\Repository\CategoryNotFoundException;
use App\Service\CategoryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/category')]
class CategoryController extends AbstractController
{
	public function __construct(
		private CategoryService $categoryService,
		private SerializerInterface $serializer
	)
	{}

	#[Route('/create', methods: ['POST'])]
	public function createCategory(Request $request): Response
	{
		$categoryDTO = $this->serializer->deserialize(
			$request->getContent(),
			CategoryDTO::class,
			'json'
		);
		$categoryId = $this->categoryService->createCategory($categoryDTO);
		return $this->json(['categoryId' => $categoryId], Response::HTTP_CREATED);
	}

	#[Route('/{id}', methods: ['GET'])]
	public function getCategory(string $id): Response
	{
		try {
			return $this->json($this->categoryService->getCategoryData($id));
		} catch (CategoryNotFoundException $e) {
			return $this->json(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
		}
	}

	#[Route('/', methods: ['GET'])]
	public function getAll(): Response
	{
		return $this->json($this->categoryService->getAllCategory());
	}

	#[Route('/{id}/blog',methods: ['GET'])]
	public function getBlogByCategory(string $id): Response
	{
		try {
			return $this->json($this->categoryService->getBlogByCategory($id));
		} catch (CategoryNotFoundException $e) {
			return $this->json(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
		}
	}
}
<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\Json\Data\CategoryCreateData;
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
	) {}

	#[Route('/create', methods: ['POST'])]
	public function createCategory(Request $request): Response
	{
		$categoryData = $this->serializer->deserialize(
			$request->getContent(),
			CategoryCreateData::class,
			'json'
		);
		$categoryId = $this->categoryService->addCategory($categoryData);
		return $this->json(['categoryId' => $categoryId], Response::HTTP_CREATED);
	}

	#[Route('/{id}', methods: ['GET'])]
	public function getCategory(string $id): Response
	{
		try {
			return $this->json($this->categoryService->getCategoryData($id), context: ['groups' => ['rest']]);
		} catch (CategoryNotFoundException $e) {
			return $this->json(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
		}
	}

	#[Route('/', methods: ['GET'])]
	public function getAll(): Response
	{
		return $this->json($this->categoryService->getAllCategory(), context: ['groups' => ['rest']]);
	}

	#[Route('/{id}/blog',methods: ['GET'])]
	public function getBlogByCategory(string $id): Response
	{
		try {
			return $this->json($this->categoryService->getBlogByCategory($id), context: ['groups' => ['rest']]);
		} catch (CategoryNotFoundException $e) {
			return $this->json(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
		}
	}
}
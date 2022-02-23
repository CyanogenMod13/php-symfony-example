<?php
declare(strict_types=1);

namespace App\Application\Controller\Blog;

use App\Application\Commands\CategoryCreateCommand;
use App\Application\Commands\Handler\CategoryCreateHandler;
use App\Domain\Model\Blog\Type\BlogId;
use App\Domain\Repository\CategoryRepositoryInterface;
use Ramsey\Uuid\Nonstandard\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route(['/categories', '/api/categories'])]
class CategoryController extends AbstractController
{
	public function __construct(
		private CategoryRepositoryInterface $categoryRepository,
		private SerializerInterface $serializer,
		private ValidatorInterface $validator
	) {}

	#[Route('/create', methods: ['POST'])]
	public function createCategory(Request $request, CategoryCreateHandler $categoryCreateHandler): Response
	{
		$categoryCreateCommand = $this->serializer->deserialize(
			$request->getContent(),
			CategoryCreateCommand::class,
			'json'
		);

		$violations = $this->validator->validate($categoryCreateCommand);
		if ($violations->count() > 0) {
			throw new BadRequestException();
		}

		$categoryId = $categoryCreateHandler->handle($categoryCreateCommand);
		return $this->json(['categoryId' => $categoryId], Response::HTTP_CREATED);
	}

	#[Route('/{id}', methods: ['GET'])]
	public function getCategory(string $id): Response
	{
		if (!Uuid::isValid($id)) {
			throw new BadRequestException();
		}

		return $this->json(
			$this->categoryRepository->get(BlogId::generate($id)),
			context: [AbstractNormalizer::GROUPS => ['rest']]
		);
	}

	#[Route('/', methods: ['GET'])]
	public function getAll(): Response
	{
		return $this->json(
			$this->categoryRepository->getAll(),
			context: [AbstractNormalizer::GROUPS => ['rest']]
		);
	}

	#[Route('/{id}/blogs',methods: ['GET'])]
	public function getBlogsByCategory(string $id): Response
	{
		if (!Uuid::isValid($id)) {
			throw new BadRequestException();
		}

		return $this->json(
			$this->categoryRepository->get(BlogId::generate($id))->getBlogs(),
			context: [AbstractNormalizer::GROUPS => ['rest']]
		);
	}
}
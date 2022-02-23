<?php

declare(strict_types=1);

namespace App\Application\Controller\Auth;

use App\Domain\Model\Blog\Type\BlogId;
use App\Domain\Model\Security\User;
use App\Domain\Repository\AuthorRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[Route(['/api/profile', '/profile'])]
class UserDetailsController extends AbstractController
{
	public function __construct(
		private AuthorRepositoryInterface $authorRepository
	) {}

	#[Route('/me', methods: ['GET'])]
	public function getUserProfile(): Response
	{
		$user = $this->getUser();
		if (!($user instanceof User)) {
			return $this->json([
				'success' => false,
				'message' => 'Unauthorized'
			], Response::HTTP_UNAUTHORIZED);
		}
		$author = $this->authorRepository->get(BlogId::generate($user->getId()));
		return $this->json($author->getName(), Response::HTTP_OK);
	}
}
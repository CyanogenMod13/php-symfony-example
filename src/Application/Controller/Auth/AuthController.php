<?php

declare(strict_types=1);

namespace App\Application\Controller\Auth;

use App\Application\Commands\Handler\UserRegisterHandler;
use App\Application\Commands\UserRegisterCommand;
use App\Domain\Model\Security\User;
use App\Domain\Service\AccessApiTokenService;
use App\Infrastructure\Persistence\Flusher;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

use function Sodium\add;

#[Route(['/api', '/'])]
class AuthController extends AbstractController
{
	public function __construct(
		private SerializerInterface $serializer,
		private ValidatorInterface $validator,
		private Flusher $flusher
	) {}

	#[Route('/login', name: 'api_login')]
	public function login(AccessApiTokenService $tokenService): Response
	{
		$user = $this->getUser();
		if (!($user instanceof User)) {
			throw new UnauthorizedHttpException('user-token');
		}

		$token = $tokenService->generateToken();
		$user->updateToken($token);
		$this->flusher->flush();

		$response = $this->json(['success' => true]);
		$response->headers->setCookie(
			new Cookie('username', $user->getUserIdentifier(), $user->getTokenExpireAt())
		);
		$response->headers->setCookie(
			new Cookie('token', $user->getToken(), $user->getTokenExpireAt())
		);
		return $response;
	}

	#[Route('/registration', name: 'api_reg', methods: ['POST'])]
	public function registration(Request $request, UserRegisterHandler $handler): Response
	{
		$userRegisterCommand = $this->serializer->deserialize(
			$request->getContent(),
			UserRegisterCommand::class,
			'json'
		);

		$violations = $this->validator->validate($userRegisterCommand);
		if ($violations->count() > 0) {
			throw new BadRequestException();
		}

		$payload = $handler->handle($userRegisterCommand);
		return $this->json($payload);
	}
}
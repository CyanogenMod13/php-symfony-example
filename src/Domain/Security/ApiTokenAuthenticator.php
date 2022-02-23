<?php

declare(strict_types=1);

namespace App\Domain\Security;

use App\Domain\Model\Security\User;
use App\Domain\Service\AccessApiTokenService;
use DateTimeImmutable;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\CustomCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class ApiTokenAuthenticator extends AbstractAuthenticator
{
	public function supports(Request $request): ?bool
	{
		return $request->cookies->has('username') &&
			$request->cookies->has('token') &&
			$request->getRequestUri() !== '/login';
	}

	public function authenticate(Request $request): Passport
	{
		$userIdentity = $request->cookies->get('username');
		$token = $request->cookies->get('token');
		if (is_null($token) && is_null($userIdentity)) {
			throw new AccessDeniedException();
		}

		return new Passport(
			new UserBadge($userIdentity),
			new CustomCredentials($this->getCallbackChecker(), $token)
		);
	}

	public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
	{
		return null;
	}

	public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
	{
		return new JsonResponse([
			'success' => false,
			'message' => 'Unauthorized'
		], Response::HTTP_UNAUTHORIZED);
	}

	private function getCallbackChecker(): callable
	{
		return static function (string $token, UserInterface $userInterface): bool {
			if ($userInterface instanceof User) {
				$tokenExpireAt = $userInterface->getTokenExpireAt();
				$currentDate = new DateTimeImmutable();

				if ($currentDate > $tokenExpireAt) {
					return false;
				}

				$userToken = $userInterface->getToken();
				return $token === $userToken;
			}
			return false;
		};
	}
}
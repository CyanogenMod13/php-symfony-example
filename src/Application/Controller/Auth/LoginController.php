<?php

declare(strict_types=1);

namespace App\Application\Controller\Auth;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
	#[Route('/login', name: 'api_login')]
	public function login(): Response
	{
		return $this->json(['message' => 'Hello ']);
	}

	#[Route('/login_form', name: 'login_form')]
	public function loginForm(AuthenticationUtils $authenticationUtils): Response
	{
		return $this->json([
			'user' => $authenticationUtils->getLastUsername(),
			'message' => $authenticationUtils->getLastAuthenticationError()
		]);
	}
}
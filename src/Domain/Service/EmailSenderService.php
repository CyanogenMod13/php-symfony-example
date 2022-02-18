<?php

declare(strict_types=1);

namespace App\Domain\Service;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailSenderService
{
	public function __construct(
		private MailerInterface $mailer,
		private string $sender
	) {}

	public function sendMail(string $to, string $msg): void
	{
		$email = new Email();
		$email = $email->from($this->sender)
			->html($msg)
			->to($to);
		$this->mailer->send($email);
	}
}
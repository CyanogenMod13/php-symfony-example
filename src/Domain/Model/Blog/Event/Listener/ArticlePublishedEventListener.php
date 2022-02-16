<?php

declare(strict_types=1);

namespace App\Domain\Model\Blog\Event\Listener;

use App\Domain\Model\Blog\Event\ArticlePublishedEvent;
use App\Domain\Service\EmailSenderService;

class ArticlePublishedEventListener
{
	public function __construct(
		private EmailSenderService $sender
	) {}

	public function sendEmailOnPublished(ArticlePublishedEvent $event): void
	{
		$userEmail = 'user@mail.com';
		$authorName = $event->getArticle()->getAuthor()->getPenName();
		$text = "$authorName published new article";

		$this->sender->sendMail($userEmail, $text);
	}
}
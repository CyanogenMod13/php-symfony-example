<?php

declare(strict_types=1);

namespace App\Service;

use App\Controller\Json\Data\ArticleCreateData;
use App\Entity\Article;
use App\Entity\Author;
use App\Entity\Blog;
use App\Repository\ArticleRepository;
use App\Repository\AuthorNotFoundException;
use App\Repository\AuthorRepository;

class ArticlePublisherService
{
	public function __construct(
		private ArticleRepository $articleRepository,
		private AuthorRepository $authorRepository
	) {}

	/**
	 * @throws AuthorNotFoundException
	 */
	public function publishArticle(ArticleCreateData $articleCreateData, Blog $blog): Article
	{
		$author = $this->authorRepository->get($articleCreateData->authorId);
		$article = $blog->publishNewArticle($articleCreateData->title, $articleCreateData->content, $author);
		$this->articleRepository->add($article);
		return $article;
	}
}
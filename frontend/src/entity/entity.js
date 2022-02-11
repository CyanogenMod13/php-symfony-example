export class Category {
	id
	name
}

export class Author {
	id
	firstName
	lastName
	penName
}

export class Blog {
	id
	name
	alias
	category
	author
}

export class Article {
	id
	title
	content
	author
	blog
	time
}
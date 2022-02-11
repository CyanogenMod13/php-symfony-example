import {createRouter, createWebHistory} from 'vue-router'
import HomeView from '../views/HomeView.vue';
import CategoriesView from "../views/CategoriesView.vue";
import BlogsView from "../views/BlogsView.vue";
import ArticlesView from "../views/ArticlesView.vue";
import ArticleView from "../views/ArticleView.vue";


const router = createRouter({
	history: createWebHistory(import.meta.env.BASE_URL),
	routes: [
		{
			path: '/',
			name: 'Home',
			component: HomeView
		},
		{
			path: '/categories',
			name: 'Categories',
			component: CategoriesView
		},
		{
			path: '/blogs',
			name: 'Blogs',
			component: BlogsView
		},
		{
			path: '/articles/:id',
			name: 'Article',
			component: ArticleView
		},
		{
			path: '/articles',
			name: 'Articles',
			component: ArticlesView
		}
	]
})

export default router

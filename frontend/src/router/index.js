import {createRouter, createWebHistory} from 'vue-router'
import HomeView from '../views/HomeView.vue';
import CategoriesView from "../views/List/CategoriesView.vue";
import BlogsView from "../views/List/BlogsView.vue";
import ArticlesView from "../views/List/ArticlesView.vue";
import ArticleView from "../views/Article/ArticleView.vue";
import Login from "../components/Auth/Login.vue";
import Registration from "../components/Auth/Registration.vue";


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
		},
		{
			path: '/login',
			name: 'Login',
			component: Login
		},
		{
			path: '/registration',
			name: 'Registration',
			component: Registration
		}
	]
})

export default router

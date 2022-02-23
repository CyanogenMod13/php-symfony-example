const appRoutes = [
    { path: '/', component: homeTemplate },
    { path: '/blogs', component: blogsTemplate },
    { path: '/categories', component: categoriesTemplate },
    { path: '/articles', component: articlesTemplate }
]

const appRouter = new VueRouter({
    mode: 'history',
    routes: appRoutes
})
<script setup>
</script>

<template>
	<header id="headerNav" class="d-flex border-bottom py-1 px-5" style="background-color: #303b44">
		<a class="fs-4 text-light text-decoration-none me-auto" href="#">My Blog Container</a>
		<ul class="nav nav-pills">
			<li class="nav-item">
				<router-link class="nav-link me-1 text-light" to="/">Home</router-link>
			</li>
			<li class="nav-item">
				<router-link class="nav-link me-1 text-light" to="/categories">Categories</router-link>
			</li>
			<li class="nav-item">
				<router-link class="nav-link me-1 text-light" to="/blogs">Blogs</router-link>
			</li>
			<li class="nav-item">
				<router-link class="nav-link me-1 text-light" to="/articles">Articles</router-link>
			</li>
		</ul>
		<div class="d-flex">
			<button v-on:click="$router.push('/login')" class="btn btn-outline-primary text-light mx-1">Sign in</button>
			<button v-on:click="$router.push('/registration')" class="btn btn-primary mx-1" style="background-color: #548eaa">Sign up</button>
		</div>
	</header>
	<div class="container mb-auto">
		<div class="d-flex p-3">
			<div id="articleArea" class="w-100">
				<router-view>
				</router-view>
			</div>
		</div>
	</div>
	<div class="">
		<footer class="d-flex py-1 px-5 text-muted border-top" style="background-color: #303b44">
			<div class="py-2 me-auto">© My Blog Container, 2021</div>
			<div>
				<ul class="nav nav-pills">
					<li class="nav-item">
						<router-link class="nav-link text-muted" to="/">Home</router-link>
					</li>
					<li class="nav-item">
						<router-link class="nav-link text-muted" to="/categories">Categories</router-link>
					</li>
					<li class="nav-item">
						<router-link class="nav-link text-muted" to="/blogs">Blogs</router-link>
					</li>
					<li class="nav-item">
						<router-link class="nav-link text-muted" to="/articles">Articles</router-link>
					</li>
				</ul>
			</div>
		</footer>
	</div>
</template>

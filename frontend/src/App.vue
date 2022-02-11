<script setup>

</script>

<template>
	<header id="headerNav" class="d-flex border-bottom py-1 bg-light px-5">
		<a class="fs-4 text-dark text-decoration-none me-auto" href="#">My Blog Container</a>
		<ul class="nav nav-pills">
			<li class="nav-item">
				<router-link class="nav-link me-1" to="/">Home</router-link>
			</li>
			<li class="nav-item">
				<router-link class="nav-link me-1" to="/categories">Categories</router-link>
			</li>
			<li class="nav-item">
				<router-link class="nav-link me-1" to="/blogs">Blogs</router-link>
			</li>
			<li class="nav-item">
				<router-link class="nav-link me-1" to="/articles">Articles</router-link>
			</li>
		</ul>
		<form>
			<input class="form-control" placeholder="Search blog or article" type="search">
		</form>
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
		<footer class="d-flex py-1 px-5 text-muted border-top bg-light">
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

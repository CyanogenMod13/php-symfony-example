<template>
	<div v-for="article in articles" class="d-flex flex-row bg-light border-bottom px-3 py-1">
		<div class="d-flex flex-row me-auto">
			<div class="mt-2">
				<object data="svg/newspaper-solid.svg" height="20" width="20"></object>
			</div>
			<div class="ms-3">
				<a class="link-primary text-decoration-none text-black" href="#"> {{ article.title }} </a>
				<div class="text-muted"> {{ article.author.firstName }} {{ article.author.lastName }}</div>
			</div>
		</div>
		<div class="text-muted" style="min-width: 124px">Soon</div>
		<div class="text-muted" style="min-width: 124px">Soon</div>
	</div>
</template>

<script>
export default {
	name: "ArticlesViewComponent"
}
</script>

<style scoped>

</style>
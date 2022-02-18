<template>
	<div v-for="category in categories" class="d-flex flex-row bg-light border-bottom px-3 py-1">
		<div class="d-flex flex-row me-auto">
			<div class="mt-2">
				<img src="@/svg/arrow-alt-circle-right-regular.svg" height="20" width="20">
			</div>
			<div class="ms-3">
				<a class="link-primary text-decoration-none text-black" href="#">{{ category.name }}</a>
			</div>
		</div>
		<div class="text-muted" style="min-width: 124px">Soon</div>
		<div class="text-muted" style="min-width: 124px">Soon</div>
	</div>
</template>

<script>
export default {
	name: "CategoriesViewItem"
}
</script>

<style scoped>

</style>
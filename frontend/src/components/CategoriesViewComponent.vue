<template>
	<div v-for="category in categories" class="d-flex flex-row bg-light border-bottom px-3 py-1">
		<div class="d-flex flex-row me-auto">
			<div class="mt-2">
				<object data="svg/arrow-alt-circle-right-regular.svg" height="20" width="20"></object>
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
	name: "CategoriesViewComponent"
}
</script>

<style scoped>

</style>
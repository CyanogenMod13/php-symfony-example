<template>
	<div class="d-flex flex-row bg-light border-bottom px-3 py-1">
		<div class="d-flex flex-row me-auto">
			<div class="mt-2">
				<img src="@/svg/newspaper-solid.svg" height="20" width="20">
			</div>
			<div class="ms-3">
				<router-link class="link-primary text-decoration-none text-black" v-bind:to="`/articles/${id}`"> {{ title }} </router-link>
				<div class="text-muted"> {{ firstName }} {{ lastName }}</div>
			</div>
		</div>
		<div class="text-muted" style="min-width: 124px">Soon</div>
		<div class="text-muted" style="min-width: 124px">Soon</div>
	</div>
</template>

<script>
export default {
	name: "ArticlesViewItem",
	props: {
		id: String,
		title: String,
		firstName: String,
		lastName: String
	}
}
</script>

<style scoped>

</style>
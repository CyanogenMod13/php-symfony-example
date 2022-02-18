<template>
	<div class="d-flex mb-1">
		<div class="me-1">
			<img src="@/svg/address-card-solid.svg" height="20" width="20">
		</div>
		<div>{{ name }}</div>
		<div class="text-muted ms-1">{{ publishedAt }}</div>
	</div>
	<div>
		{{content}}
	</div>
	<div class="d-flex flex-row">
		<button class="btn d-flex">
			<img src="@/svg/heart-solid.svg" height="20" width="20">
			<div class="ms-1">+34</div>
		</button>
		<button class="btn d-flex ms-1">
			<img src="@/svg/reply-solid.svg" height="20" width="20">
			<div class="ms-1">Reply</div>
		</button>
	</div>
</template>

<script>
export default {
	name: "Comment",
	props: {
		name: String,
		publishedAt: String,
		content: String
	}
}
</script>

<style scoped>

</style>
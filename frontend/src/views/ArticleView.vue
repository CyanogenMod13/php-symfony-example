<template>
	<div class="bg-light p-3">
		<div>
			<div class="d-flex flex-row">
				<div class="me-1">
					<object data="svg/address-card-solid.svg" height="20" width="20"></object>
				</div>
				<div>{{ authorFirstName }} {{ authorLastName }}</div>
				<div class="text-muted ms-1">{{ time }}</div>
			</div>
			<h3>{{ title }}</h3>
		</div>
		<div>{{ content }}</div>
		<div class="d-flex flex-row border-top pt-2">
			<button class="btn btn-primary d-flex">
				<object data="svg/heart-solid.svg" height="20" width="20"></object>
				<div class="ms-1">Like me</div>
			</button>
		</div>
	</div>
	<div id="comments" class="bg-light p-3 mt-2">
		<div class="border-bottom mb-2">
			<p>3 Comments</p>
		</div>
	</div>
</template>

<script>
export default {
	name: "ArticleView",
	data() {
		return {
			authorFirstName: 'J',
			authorLastName: 'A',
			title: 'Art',
			content: 'xxaxas'
		}
	}
}
</script>

<style scoped>

</style>
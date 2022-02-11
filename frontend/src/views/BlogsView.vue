<template>
	<div class="d-flex flex-row bg-light border-bottom px-3 py-1">
		<div class="me-auto">Name</div>
		<div style="min-width: 124px">Category</div>
		<div style="min-width: 124px">Rating</div>
		<div style="min-width: 124px">Subscribers</div>
	</div>
	<LoadSpinnerComponent v-if="blogs == null"/>
	<BlogsViewComponent v-for="blog in blogs" v-else
						v-bind:alias="blog.alias"
						v-bind:category="blog.category.name"
						v-bind:name="blog.name"/>
</template>

<script>
import BlogsViewComponent from "../components/BlogsViewComponent.vue";
import LoadSpinnerComponent from "../components/LoadSpinnerComponent.vue";

export default {
	name: "BlogsView",
	components: {LoadSpinnerComponent, BlogsViewComponent},
	methods: {
		loadContent: function () {
			const view = this
			const request = new XMLHttpRequest()
			request.onload = function () {
				view.blogs = JSON.parse(this.responseText)
			}
			request.open('GET', 'http://192.168.0.7/blog', true)
			request.send()
		}
	},
	data() {
		this.loadContent()
		return {
			blogs: null
		}
	}
}
</script>

<style scoped>

</style>
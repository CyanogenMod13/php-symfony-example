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
import BlogsViewComponent from "../../components/List/BlogsViewItem.vue";
import LoadSpinnerComponent from "../../components/LoadSpinner.vue";
import axios from "axios";

export default {
	name: "BlogsView",
	components: {LoadSpinnerComponent, BlogsViewComponent},
	methods: {
		loadContent: function () {
			axios.get('http://localhost:81/api/blogs').then((response) => {
				this.blogs = response.data
			})
		}
	},
	data() {
		return {
			blogs: null
		}
	},
	mounted() {
		this.loadContent()
	}
}
</script>

<style scoped>

</style>
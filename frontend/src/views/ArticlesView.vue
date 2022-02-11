<template>
	<div class="d-flex flex-row bg-light border-bottom px-3 py-1">
		<div class="me-auto">Name</div>
		<div style="min-width: 124px">Rating</div>
		<div style="min-width: 124px">Blog</div>
	</div>
	<LoadSpinnerComponent v-if="articles == null"/>
	<ArticlesViewComponent v-for="article in articles" v-else
						   v-bind:id="article.id"
						   v-bind:title="article.title"
						   v-bind:first-name="article.author.firstName"
						   v-bind:last-name="article.author.lastName"/>
</template>

<script>
import ArticlesViewComponent from "../components/ArticlesViewComponent.vue";
import LoadSpinnerComponent from "../components/LoadSpinnerComponent.vue";
export default {
	name: "ArticlesView",
	components: {LoadSpinnerComponent, ArticlesViewComponent},
	methods: {
		onLoadContent: function () {
			const view = this
			const request = new XMLHttpRequest()
			request.onload = function () {
				console.log(view.articles = JSON.parse(this.responseText))
			}
			request.open('GET', 'http://192.168.0.7/article', true)
			request.send()
		}
	},
	data() {
		this.onLoadContent()
		return {
			articles: null
		}
	}
}
</script>

<style scoped>

</style>
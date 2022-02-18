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
import ArticlesViewComponent from "../../components/List/ArticlesViewItem.vue";
import LoadSpinnerComponent from "../../components/LoadSpinner.vue";
import axios from "axios";

export default {
	name: "ArticlesView",
	components: {LoadSpinnerComponent, ArticlesViewComponent},
	methods: {
		onLoadContent: function () {
			axios.get('http://localhost:81/articles').then((response) => {
				this.articles = response.data
			})
		}
	},
	data() {
		return {
			articles: null
		}
	},
	mounted() {
		this.onLoadContent()
	}
}
</script>

<style scoped>

</style>
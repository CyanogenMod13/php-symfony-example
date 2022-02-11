<template>
	<LoadSpinnerComponent v-if="article == null"/>
	<div v-else class="bg-light p-3">
		<div>
			<div class="d-flex flex-row">
				<div class="me-1">
					<object data="svg/address-card-solid.svg" height="20" width="20"></object>
				</div>
				<div>{{ article.author.firstName }} {{ article.author.lastName }}</div>
				<div class="text-muted ms-1">{{ article.time }}</div>
			</div>
			<h3>{{ article.title }}</h3>
		</div>
		<div>{{ article.content }}</div>
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
import LoadSpinnerComponent from "../components/LoadSpinnerComponent.vue";
export default {
	name: "ArticleView",
	components: {LoadSpinnerComponent},
	methods: {
		loadArticle: function () {
			const view = this
			const request = new XMLHttpRequest()
			request.onload = function () {
				view.article = JSON.parse(this.responseText)
			}
			request.open('GET', `http://192.168.0.7/article/${this.$route.params.id}`, true)
			request.send()
		}
	},
	data() {
		this.loadArticle()
		return {
			article: null
		}
	}
}
</script>

<style scoped>

</style>
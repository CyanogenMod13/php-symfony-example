<template>
	<LoadSpinnerComponent v-if="article == null"/>
	<div v-else class="bg-light p-3">
		<div>
			<div class="d-flex flex-row">
				<div class="me-1">
					<img src="@/svg/address-card-solid.svg" height="20" width="20">
				</div>
				<div>{{ article.author.firstName }} {{ article.author.lastName }}</div>
				<div class="text-muted ms-1">{{ article.time }}</div>
			</div>
			<h3>{{ article.title }}</h3>
		</div>
		<div v-html="article.content"></div>
		<div class="d-flex flex-row border-top pt-2">
			<button class="btn btn-primary d-flex">
				<img src="@/svg/heart-solid.svg" height="20" width="20">
				<div class="ms-1">Like me</div>
			</button>
		</div>
	</div>
	<div id="comments" class="bg-light p-3 mt-2">
		<div class="border-bottom mb-2">
			<p>{{numberComments}} Comments</p>
		</div>
		<CommentViewer v-bind:comments="article.comments"/>
	</div>
</template>

<script>
import LoadSpinnerComponent from "../../components/LoadSpinner.vue";
import CommentViewer from "./CommentViewer.vue";
import axios from "axios";

export default {
	name: "ArticleView",
	components: {CommentViewer, LoadSpinnerComponent},
	methods: {
		loadArticle: function () {
			axios.get(`http://localhost:81/articles/${this.$route.params.id}`).then((response) => {
				this.article = response.data
			})
		}
	},
	data() {
		return {
			article: null
		}
	},
	mounted() {
		this.loadArticle()
	}
}
</script>

<style scoped>

</style>
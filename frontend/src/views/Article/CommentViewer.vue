<template>
	<ul class="my-2">
		<template v-for="comment in comments">
			<li>
				<CommentComponent v-bind:name="comment.author.penName" v-bind:published-at="comment.time" v-bind:content="comment.content"/>
			</li>
			<li class="dropdown-divider"></li>
			<li v-if="comment.children.length > 0">
				<CommentViewer v-bind:comments="comment.children"/>
			</li>
		</template>
	</ul>
</template>

<script>
import CommentComponent from "../../components/Article/Comment.vue";

export default {
	name: "CommentViewer",
	components: {CommentComponent},
	props: {
		comments: Array
	}
}
</script>

<style scoped>

</style>
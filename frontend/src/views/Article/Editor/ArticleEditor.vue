<template>
	<div class="bg-light">
		<div class="d-flex flex-column p-5">
			<div class="pb-1">
				<input class="input-text w-100 " type="text" name="title" placeholder="Title of article">
			</div>

			<div class="d-flex flex-column" style="min-height: 400px">
				<div role="textbox" contenteditable class="input-text w-100" v-on:mousedown.left="onFocus" v-on:focusout="onFocusout"></div>
				<div class="dropdown insert-element-button" ref="insert-button">
					<button type="button" data-bs-toggle="dropdown" class="insert-element-button" id="ddb">
						<img src="@/svg/plus-solid.svg" height="20" width="20">
					</button>
					<div class="dropdown-menu" aria-labelledby="ddb">
						<button class="dropdown-item">Header</button>
						<button class="dropdown-item">List</button>
						<button class="dropdown-item">Picture</button>
						<button class="dropdown-item">Quote</button>
					</div>
				</div>
			</div>
		</div>
		<div class="dropdown-divider"></div>
		<div class="d-flex p-2">
			<button class="btn btn-outline-success me-2">Ready to publish</button>
			<span class="align-middle">Saved at 15:04</span>
		</div>
	</div>
</template>

<script>
export default {
	name: "ArticleEditor",
	methods: {
		onFocus: function (event) {
			const div = event.target
			const rect = div.getBoundingClientRect()
			const button = this.$refs["insert-button"]
			button.style.left = rect.left - 30 + 'px'
			button.style.top = rect.top + 'px'
			button.style.visibility = 'visible'
		},
		onFocusout: function (event) {
			const button = this.$refs["insert-button"];
			console.log(event.target)
			console.log(button)
			if (event.target.ref === "insert-button") return;
			button.style.visibility = 'hidden'
		}
	},
	data() {
		return {
			content: 'Enter text'
		}
	}
}
</script>

<style scoped>
	.input-text {
		border: none;
		outline: none;
		background: none;
	}

	.input-text[contenteditable]:empty::before {
		content: 'Enter text';
		color: gray;
	}

	.insert-element-button {

		background: none;
		border: none;
		padding: unset;
		position: absolute;
	}
</style>
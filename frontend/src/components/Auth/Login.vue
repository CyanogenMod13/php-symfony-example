<template>
	<div class="mt-4 mx-auto w-50">
		<div v-if="!isCorrect" class="p-2 mb-3 border border-3 border-danger">
			Username or password is invalid
		</div>
		<div class="d-flex flex-column bg-light p-4">
			<strong class="form-label">Login</strong>
			<div class="mt-2">
				<strong>E-mail</strong>
				<input v-model="loginData.username" name="email" class="form-control" type="email" placeholder="your e-mail" required>
			</div>
			<div class="mt-2">
				<strong>Password</strong>
				<input v-model="loginData.password" name="password" class="form-control" type="password" placeholder="enter your password" required>
			</div>
			<div class="dropdown-divider"></div>
			<button class="btn btn-primary" v-on:click="login()" v-bind:disabled="isButtonLoad">
				<span v-if="isButtonLoad" class="spinner-border spinner-border-sm"></span>
				<span v-else>Log in</span>
			</button>
		</div>
	</div>
</template>

<script>
import axios from "axios";
import Cookie from 'js-cookie'

export default {
	name: "Login",
	methods: {
		login: function () {
			this.isButtonLoad = true
			axios.post('http://localhost:81/api/login', this.loginData).then(response => {
				console.log(response)
				console.log(response.headers["set-cookie"])
				this.$router.push('/')
			}).catch((reason => {
				console.log(reason)
				this.failed()
			}))
		},
		failed: function () {
			this.isButtonLoad = false
			this.isCorrect = false
		}
	},
	data() {
		return {
			isButtonLoad: false,
			isCorrect: true,
			loginData: {
				username: '',
				password: ''
			}
		}
	}
}
</script>

<style scoped>

</style>
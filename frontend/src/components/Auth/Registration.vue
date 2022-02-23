<template>
	<div class="mt-4 mx-auto w-50">
		<div class="d-flex flex-column bg-light p-4">
			<strong class="form-label">Registration</strong>
			<div class="mt-2">
				<strong>E-mail</strong>
				<input autocomplete="off" name="email" class="form-control" type="email" placeholder="your e-mail" required>
			</div>
			<div class="mt-2">
				<strong>First Name</strong>
				<input autocomplete="off" name="firstName" class="form-control" type="text" placeholder="your first name" required>
			</div>
			<div class="mt-2">
				<strong>Second Name</strong>
				<input autocomplete="off" name="secondName" class="form-control" type="text" placeholder="your second name" required>
			</div>
			<div class="mt-2">
				<strong>Pen Name</strong>
				<input autocomplete="off" name="penName" class="form-control" type="text" placeholder="your pen name" required>
			</div>
			<div class="mt-2">
				<strong>Password</strong>
				<input autocomplete="off" name="password" class="form-control" type="password" placeholder="enter your password" required>
			</div>
			<div class="mt-2">
				<strong>Repeat Password</strong>
				<input autocomplete="off" name="password" class="form-control" type="password" placeholder="repeat your password" required>
			</div>
			<div class="dropdown-divider"></div>
			<button class="btn btn-primary">Register</button>
		</div>
	</div>
</template>

<script>
export default {
	name: "Registration"
}
</script>

<style scoped>

</style>
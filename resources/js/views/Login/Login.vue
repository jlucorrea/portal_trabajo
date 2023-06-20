<style scoped>
html,
body {
	height: 100%;
}
.form-signin {
	max-width: 330px;
	padding: 1rem;
}
.form-signin .form-floating:focus-within {
	z-index: 2;
}
.form-signin input[type="email"] {
	margin-bottom: -1px;
	border-bottom-right-radius: 0;
	border-bottom-left-radius: 0;
}
.form-signin input[type="password"] {
	margin-bottom: 10px;
	border-top-left-radius: 0;
	border-top-right-radius: 0;
}
</style>

<script>
import { defineComponent, ref } from 'vue'
import axios from 'axios'

export default defineComponent({
	setup() {
		const resource = 'login';
		const form = ref({});
		const initForm = () => {
			form.value = {
				email: null,
				password: null
			}
		}

		const resetForm = () => {
			initForm()
		}

		const login = async () => {
			try {
				const res = await axios.post(`${resource}`, form)
				console.log(res)
				// resetForm()
			} catch (error) {
				console.log(error)
			}
		}

		return {
			form,
			login
		}
	}
})
</script>

<template>
	<main class="form-signin w-100 m-auto mt-5">
		<form autocomplete="off" @submit.prevent="submit">
			<img class="mb-4" src="https://cdn-icons-png.flaticon.com/512/8037/8037350.png" alt="" height="57">
			<h1 class="h3 mb-3 fw-normal">Iniciar Sesión</h1>
			<div class="form-floating">
				<input type="email" v-model="form.email" class="form-control" id="floatingInput" placeholder="Email">
				<label for="floatingInput">Email</label>
			</div>
			<div class="form-floating">
				<input type="password" v-model="form.password" class="form-control" id="floatingPassword"
					placeholder="Contraseña">
				<label for="floatingPassword">Contraseña</label>
			</div>
			<button class="btn btn-primary w-100 py-2" type="submit" @click="login()">Ingresar</button>
			<p class="mt-5 mb-3 text-body-secondary">© <b>JLucorrea</b> 2023</p>
		</form>
	</main>
</template>
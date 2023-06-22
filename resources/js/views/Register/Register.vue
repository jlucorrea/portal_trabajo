<script>
import { defineComponent, reactive, ref } from 'vue'
import axios from 'axios'
import { ElMessage } from 'element-plus'

export default defineComponent({
	setup() {
		const resource = 'postulante';
		const tipo_documentos = reactive([
			{ selected: true, id: 1, nombre: 'Dni' },
			{ id: 2, nombre: 'Ruc' }
		]);
		const errors = ref({});

		const resetForm = () => {
			form.tipo_doc = tipo_documentos.length > 0 ? tipo_documentos[0].id : null;
			form.numero = null;
			form.nombre = null;
			form.apellidos = null;
			form.f_nacimiento = null;
			form.email = null;
			form.password = null;
		}

		const form = reactive({
			tipo_doc: tipo_documentos.length > 0 ? tipo_documentos[0].id : null,
			numero: null,
			nombre: null,
			apellidos: null,
			f_nacimiento: null,
			email: null,
			password: null
		});

		const submit = async () => {
			try {
				const response = await axios.post(`/${resource}/register`, form);
				if (response.data.success) {
					ElMessage.success(response.data.message);
					resetForm()
				} else {
					ElMessage.error(response.data.message);
				}
			} catch (error) {
				if (error.response.status === 422) {
					errors.value = error.response.data.errors
				} else {
					console.log(error);
				}
			}
		}
		return {
			tipo_documentos,
			form,
			errors,
			submit
		}
	}
})
</script>

<template>
	<div class="container">
		<main>
			<div class="py-5 text-center">
				<h2>Datos del Postulante</h2>
			</div>
			<div class="row">
				<div class="col-2"></div>
				<div class="col-8">
					<form class="needs-validation" @submit.prevent="submit">
						<div class="row g-3">
							<div class="col-md-6">
								<label for="tipo_doc" class="form-label">Tipo Documento</label>
								<select class="form-select" v-model="form.tipo_doc" id="tipo_doc" required="">
									<option v-for="tipo in tipo_documentos" :value="tipo.id" :key="tipo.id">{{ tipo.nombre
									}}</option>
								</select>
							</div>
							<div class="col-md-6">
								<label for="numero" class="form-label">Número</label>
								<input type="number" v-model="form.numero" class="form-control" id="numero"
									placeholder="Número Documento">
								<small class="text-danger" v-if="errors.numero" v-text="errors.numero[0]"></small>
							</div>
							<div class="col-sm-6">
								<label for="nombre" class="form-label">Nombre</label>
								<input type="text" v-model="form.nombre" class="form-control" id="nombre" placeholder="">
								<small class="text-danger" v-if="errors.nombre" v-text="errors.nombre[0]"></small>
							</div>

							<div class="col-sm-6">
								<label for="apellidos" class="form-label">Apellidos</label>
								<input type="text" v-model="form.apellidos" class="form-control" id="apellidos"
									placeholder="">
								<small class="text-danger" v-if="errors.apellidos" v-text="errors.apellidos[0]"></small>
							</div>

							<div class="col-sm-6">
								<label for="f_nacimiento" class="form-label">F. Nacimiento</label>
								<input type="date" v-model="form.f_nacimiento" class="form-control" id="f_nacimiento"
									placeholder="">
								<small class="text-danger" v-if="errors.f_nacimiento"
									v-text="errors.f_nacimiento[0]"></small>
							</div>

							<div class="col-sm-6">
								<label for="email" class="form-label">Email</label>
								<input type="email" v-model="form.email" class="form-control" id="email"
									placeholder="postulante@example.com">
								<small class="text-danger" v-if="errors.email" v-text="errors.email[0]"></small>
							</div>

							<div class="col-sm-6">
								<label for="password" class="form-label">Contraseña</label>
								<input type="password" v-model="form.password" class="form-control" id="password"
									placeholder="*****">
								<small class="text-danger" v-if="errors.password" v-text="errors.password[0]"></small>
							</div>
						</div>
						<hr class="my-4">
						<button class="w-100 btn btn-primary btn-lg" type="submit">Registrarme</button>
					</form>
			</div>
			<div class="col-2"></div>
		</div>
	</main>
</div></template>
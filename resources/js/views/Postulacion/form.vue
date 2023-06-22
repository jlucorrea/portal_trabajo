<script>
import { ref, reactive, onMounted, inject, defineComponent } from 'vue';
import axios from 'axios';
import { ElMessage } from 'element-plus';

export default defineComponent({
	props: {
		showDialog: {
			type: Boolean,
			required: true
		},
		recordForm: {
			type: Object,
			required: false
		},
		userData: {
			type: Object,
			required: false
		}
	},
	setup(props, { emit }) {
		const emitter = inject("emitter");
		const resource = 'postulaciones';
		const registerRoute = '/register';
		const errors = ref({});

		const form = reactive({
			descripcion: null,
			postulante_id: !!props.userData ? props.userData.postulante_id : null,
			publicacion_id: !!props.recordForm ? props.recordForm.id : null,
			archivo_pdf: null
		});

		const submit = () => {
			const formData = new FormData();
			formData.append('descripcion', form.descripcion);
			formData.append('postulante_id', form.postulante_id);
			formData.append('publicacion_id', form.publicacion_id);
			if (form.archivo_pdf) {
				formData.append('archivo_pdf', form.archivo_pdf);
			}

			axios.post(`/${resource}`, formData)
				.then((response) => {
					if (response.data.success) {
						ElMessage.success(response.data.message);
						emitter.emit('reloadData')
						close()
					} else {
						ElMessage.error(response.data.message);
					}
				})
				.catch((error) => {
					if (error.response.status === 422) {
						errors.value = error.response.data.errors;
					} else {
						console.log(error);
					}
				});
		};

		const close = () => {
			emit('closeModal');
		};

		const handleFileChange = (file) => {
			form.archivo_pdf = file;
			return false;
		};

		onMounted(() => {

		});

		return {
			form,
			errors,
			submit,
			close,
			handleFileChange,
			registerRoute
		};
	}
});
</script>

<template>
	<el-dialog v-model="showDialog" @close="close">
		<form autocomplete="off" @submit.prevent="submit" v-if="userData">
			<div class="modal-content rounded-4 shadow">
				<div class="modal-body p-5">
					<h2 class="fw-bold mb-0">{{ recordForm.titulo }}</h2>
					<ul class="d-grid gap-4 my-5 list-unstyled small">
						<div class="form-group">
							<label class="control-label">Descripción</label>
							<el-input size="large" v-model="form.descripcion"></el-input>
							<small class="text-danger" v-if="errors.descripcion" v-text="errors.descripcion[0]"></small>
						</div>

						<div class="form-group">
							<label class="control-label">Adjuntar CV</label>
							<el-upload :file-list="[]" :before-upload="handleFileChange" :accept="'application/pdf'">
								<el-button size="small" type="primary">Subir CV</el-button>
							</el-upload>
							<div v-if="form.archivo_pdf">{{ form.archivo_pdf.name }}</div>
						</div>
					</ul>
					<button type="submit" class="btn btn-lg btn-primary mt-5 w-100">Postular</button>
				</div>
			</div>
		</form>
		<div v-else class="modal-dialog" role="document">
			<div class="modal-content rounded-4 shadow">
				<div class="modal-body p-5">
					<h2 class="fw-bold mb-0">{{ recordForm.titulo }}</h2>
					<ul class="d-grid gap-4 my-5 list-unstyled small">
						<li class="d-flex gap-4">
							<svg class="bi text-body-secondary flex-shrink-0" width="48" height="48">
								<use xlink:href="#grid-fill"></use>
							</svg>
							<div>
								<h5 class="mb-0">Para postular a este puesto primero debe registrase</h5>
							</div>
						</li>
					</ul>
					<a :href='registerRoute' class="btn btn-lg btn-primary mt-5 w-100">Click Aqui!</a>
				</div>
			</div>
		</div>
	</el-dialog>
</template>
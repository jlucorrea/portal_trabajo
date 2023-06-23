<script>
import { ref, reactive, onMounted, inject, defineComponent } from 'vue';
import axios from 'axios';
import { ElMessage } from 'element-plus'
export default defineComponent({
	props: {
		showDialog: {
			type: Boolean,
			required: true
		},
		recordId: {
			type: Number,
			required: false
		}
	},
	setup(props, { emit }) {
		const emitter = inject("emitter");
		const titleDialog = ref(null);
		const resource = 'jobs';
		const form = reactive({});
		const errors = ref({});

		const initForm = () => {
			errors.value = {};
			form.value = {
				id: null,
				titulo: null,
				descripcion: null,
				sueldo: null
			};
		};

		const getData = () => {
			titleDialog.value = props.recordId ? 'Actualizar' : 'Registrar';

			if (props.recordId) {
				axios.get(`/${resource}/record/${props.recordId}`)
					.then((response) => {
						Object.assign(form, response.data);
					});
			}
		};

		const submit = () => {
			axios.post(`/${resource}`, form)
				.then((response) => {
					if (response.data.success) {
						ElMessage.success(response.data.message);
						emitter.emit('reloadData')
						close();
					} else {
						ElMessage.error(response.data.message);
					}
				})
				.catch((error) => {
					if (error.response.status === 422) {
						errors.value = error.response.data.errors
					} else {
						console.log(error);
					}
				})
		};

		const close = () => {
			emit('closeModal');
			initForm();
		};

		onMounted(() => {
			initForm();
			getData();
		});

		return {
			titleDialog,
			resource,
			form,
			errors,
			submit,
			close
		}
	}
})
</script>

<template>
	<el-dialog :title="titleDialog" v-model="showDialog" @close="close">
		<form autocomplete="off" @submit.prevent="submit">
			<div class="form-body">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label">Titulo</label>
							<el-input size="large" v-model="form.titulo"></el-input>
							<small class="text-danger" v-if="errors.titulo" v-text="errors.titulo[0]"></small>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label">Descripción</label>
							<el-input type="textarea" :rows="4" placeholder="Ingrese su texto aquí" v-model="form.descripcion"></el-input>
							<small class="text-danger" v-if="errors.descripcion" v-text="errors.descripcion[0]"></small>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label">Sueldo</label>
							<el-input size="large" type="number" v-model="form.sueldo" />
							<small class="text-danger" v-if="errors.sueldo" v-text="errors.sueldo[0]"></small>
						</div>
					</div>
				</div>
			</div>
			<div class="form-actions text-right mt-4">
				<el-button size="large" @click.prevent="close">Cancelar</el-button>
				<el-button size="large" type="primary" native-type="submit">Guardar</el-button>
			</div>
		</form>
	</el-dialog>
</template>
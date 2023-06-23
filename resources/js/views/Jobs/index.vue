<script>
import { defineComponent, ref, inject } from 'vue';
import DataTable from '../../components/DataTable.vue';
import JobForm from './form.vue';
import { deletregister } from '../../plugins/deletregister';

export default defineComponent({
	components: { DataTable, JobForm },
	setup() {
		const { destroy } = deletregister();
		const emitter = inject("emitter");
		const resource = 'jobs';
		const recordId = ref(null);
		const showDialog = ref(false);

		const clickCreate = (id) => {
			recordId.value = id;
			showDialog.value = true;
		}

		const closeModal = () => {
			showDialog.value = false;
		}

		const clickDelete = (id) => {
			destroy(`/${resource}/${id}`)
			.then(() =>
				emitter.emit('reloadData')
			);
		}

		return {
			resource,
			recordId,
			showDialog,
			clickCreate,
			clickDelete,
			closeModal
		}
	}
})
</script>

<template>
	<div>
		<div class="container">
		<div class="page-header d-flex">
			<div class="ml-4 mt-2 p-2 flex-grow-1">
				<h4>Lista de trabajos</h4>
			</div>
			<div class="mr-3">
				<a class="btn btn-success btn-sm  mt-2 mr-2" @click.prevent="clickCreate()">+ Registrar</a>
			</div>
		</div>

		<div class="card mb-0 w-100 mt-3 mb-3">
			<div class="card-body ">
				<data-table :resource="resource" :showReload="true">
					<template v-slot:heading>
						<th>#</th>
						<th class="text-left">Titulo</th>
						<th class="text-left">Descripción</th>
						<th class="text-left">Sueldo</th>
						<th class="text-center">Acciones</th>
					</template>
					<template v-slot:tbody="{ index, row }">
					<tr>
					<td>{{ index }}</td>
					<td class="text-left p-0">{{ row.titulo }}</td>
					<td class="text-left p-0">{{ row.descripcion }}</td>
					<td class="text-left p-0">{{ row.sueldo }}</td>
					<td class="text-center">
						<a class="btn btn-sm btn-primary mx-2" @click.prevent="clickCreate(row.id)">
							<i class="fa fa-pencil i-icon text-white"></i>
						</a>
						<a class="btn btn-sm btn-danger" @click.prevent="clickDelete(row.id)">
							<i class="fa fa-trash i-icon text-white"></i>
						</a>
					</td>
				</tr>
				</template>
				</data-table>
			</div>
		</div>
	</div>
	<job-form v-if="showDialog" :showDialog="showDialog" :recordId="recordId" @closeModal="closeModal"></job-form>
	</div>
</template>
<script>
import { defineComponent, ref, inject, onMounted, watch, reactive, computed } from 'vue';
import axios from 'axios';
import queryString from 'query-string'
import PostulacionForm from './form.vue';

export default defineComponent({
	props: {
		user: {
			type: Object,
			required: false
		}
	},
	components: { PostulacionForm },
	setup(props) {
		const emitter = inject("emitter");
		const resource = 'jobs';
		const pagination = ref({});
		const records = ref([]);
		const recordForm = ref({});
		const showDialog = ref(false);
		const userData = ref({});


		const postular = (id) => {
			recordForm.value = id;
			showDialog.value = true;
		}

		const closeModal = () => {
			showDialog.value = false;
		}

		const search = ref({
			titulo: null
		});

		const getRecords = () => {
			axios.get(`/${resource}/all_records?${getQueryParameters()}`)
				.then(response => {
					records.value = response.data.data;
					pagination.value = response.data.meta;
					pagination.value.per_page = parseInt(response.data.meta.per_page);
					isPostulado()
				})
				.catch(error => console.log(error));
		}

		const isPostulado = (postId) => {
			if(props.user){
				return records.value.some(row => {
					if (row.postulacion && row.postulacion.length > 0) {
						return row.postulacion.some(postulacion => postulacion.publicacion_id === postId && postulacion.postulante_id === props.user.postulante_id);
					}
					return false;
				});	
			}
			return false;
		}


		const getQueryParameters = () => {
			return queryString.stringify({
				page: pagination.value.current_page,
				limit: pagination.value.limit,
				per_page: pagination.value.per_page,
				...search.value
			});
		};

		const customIndex = (index) => {
			return pagination.value.per_page * (pagination.value.current_page - 1) + index + 1;
		};

		const getRecords2 = () => {
			getRecords()
		}

		onMounted(() => {
			getRecords();
			userData.value = props.user
		});

		emitter.on('reloadData', () => {
			getRecords();
		});

		watch(search, () => {
			if (search.value.titulo !== null) {
				getRecords();
			}
		}, { deep: true });


		return {
			userData,
			showDialog,
			customIndex,
			records,
			recordForm,
			search,
			pagination,
			postular,
			closeModal,
			getRecords2,
			isPostulado
		}
	}
})
</script>

<template>
	<div>
		<main class="container">
			<div class="row mt-2">
				<div class="col-md-6">
					<el-input class="my-3" placeholder="Buscar nombre del puesto" v-model="search.titulo"
						style="width: 100%;" size="large" prefix-icon="Search" clearable filterable />
				</div>
				<div class="col-md-6">
					<el-pagination style="justify-content: right;" class="mt-3" @current-change="getRecords2"
						layout="prev, pager, next" :total="pagination.total" background
						v-model:current-page="pagination.current_page" :page-size="pagination.per_page" />
				</div>
			</div>
			<div class="row">
				<div class="col-md-6" v-for="(row, index) in records" :key="index" :index="customIndex(index)">
					<div
						class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
						<div class="col p-4 d-flex flex-column position-static">
							<h3 class="mb-0">
								<span style="vertical-align: inherit;">
									<span style="vertical-align: inherit;">{{ row.titulo }}</span>
								</span>
							</h3>
							<div class="mb-1 text-body-secondary">
								<span style="vertical-align: inherit;">
									<span style="vertical-align: inherit;">{{ row.fecha }}</span>
								</span>
							</div>
							<p class="card-text mb-auto">
								<span style="vertical-align: inherit;">
									<span style="vertical-align: inherit;">{{ row.descripcion }}</span>
								</span>
							</p>
							<a @click.prevent="postular(row)" v-if="!isPostulado(row.id)">
								<span class="btn btn-primary" style="vertical-align: inherit;">Postular</span>
							</a>
							<a href="javascript:void(0)" v-else>
								<span class="btn btn-success" style="vertical-align: inherit;">Postulado</span>
							</a>
						</div>
						<div class="col-auto d-none d-lg-block">
							<svg class="bd-placeholder-img" width="200" height="250" xmlns="http://www.w3.org/2000/svg"
								role="img" focusable="false">
								<rect width="100%" height="100%" fill="#55595c"></rect><text x="50%" y="50%" fill="#eceeef"
									dy=".3em">S/ {{ row.sueldo }}</text>
							</svg>
						</div>
					</div>
				</div>
			</div>
		</main>
		<postulacion-form v-if="showDialog" :showDialog="showDialog" :recordForm="recordForm" :userData="userData"
			@closeModal="closeModal" />
	</div>
</template>
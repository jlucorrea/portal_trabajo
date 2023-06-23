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
			if (props.user) {
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
		<section id="featured">
			<div class="container">
				<div class="row mt-2">
				<div class="col-md-6">
					<el-input class="my-3" placeholder="Buscar nombre del puesto" v-model="search.titulo"
						style="width: 100%;" size="large" prefix-icon="Search" clearable filterable />
				</div>
				<div class="col-md-6">
					<el-pagination style="justify-content: right;" class="mt-3" @current-change="getRecords2"
						layout="prev, pager, next" :total="pagination.total == undefined ? 0 : pagination.total" background
						v-model:current-page="pagination.current_page" :page-size="pagination.per_page" />
				</div>
			</div>
				<div class="row">
					<div class="col-lg-4 col-md-6 col-xs-12" v-for="(row, index) in records" :key="index" :index="customIndex(index)">
						<div class="job-featured">
							<div class="icon">
								<img src="data:image/webp;base64,UklGRjgFAABXRUJQVlA4TCwFAAAvJ8AJEBExaYrxnhH9D0p+IiZNsecwxqf/4atVLHRsa08kSd8vZXF5vSmw2qPdt9s9PFOUIf2/oT8qYwnvNDPGMFGOJMmRJJl5jex/qVgCMP9MobsKc9C2kSA5d/+4hj+pqwSAAQigWbZt27Zt2zZv27Zt27Zt28yuCRAEuO79X6deVoIhRXg/VZEwQKq4HnwYHjgxXfuEnwLL3v15JvtPQ5QcW+IFtJx8JZBeRqA+du6bnoOo9rDNwgLh6RIPfl6cfbSvRCAMDxJB/0kDbntreTW9VqyxJE2lwpOoZdIIoWk3JzEdgU7A6ouhPs1UgjSOFp4xxqpwCAt/dgud8NMuSAJ6x+DJM6iiwLi6nfqf3f/tT02CBrz2xeD2XnAlN+BqZsHpUo2jKghBGBGGeBGHmTXenJcQauMSAl5GMbgRFzMvJb1tpQo7d7rz/QI1o/oARBGlMzh4AwbCADDR28arPh/h1tzNbxdz9BDp57pbUzX9WBnCqF4IgIm+/vdZNTjxViIKx/a6PCVdHUBBJEZgTuig8M9iYo8e4RDc/n4qhx8OvhR6Da0heSNi8QReNK0WGyn8ShyYscF+IcMjKVq4mSKCgBcxYIc/xKikKXyjZVILX+iSZ1SwKRFWk8bpDuMyX4QEhHahuKi0a0VZKJDaMLH1QsGtrye1t4p7IK/ElEJhHXkzXQ/7FgwgrGxX2f5a4SCTCAz095NrSG0QIn1iD7bYJKxjVtA1mic8HxBWbs/G+pQbhcTwxIS7UlPRm+z/9q7ll/8VC90zJx8UW2qFReTbFOyvJo20wgDK1R7jNyKSv91mf2H27Gr5xKzQ75grGzsj/XDzUWZLsYkOctrCl7lrd632wzooeDtQnwYLr+g4IkQaiAUWwp4KViwqfPI8kyz+4PUfhmMr0CPt9FsSAwXDNiFzGbruyzIAoXvzpCy0AGx13K8wE7ix0UKhbiHZr8ZqCyBEodNCCONlW+U8xQaIRcnCpTrw1L4QkNBZKxQlZ+eq4rGCsl3IWKjdVG2lK4ByXfAYfo5R1OsXEIbphWC+kJOdwQJCsL+MhTfwyzshpwdeVhJgIQzb9ISPi/zwHx2/LDQo8CJAeTxxZi/0fvP/gqstjLKQAHhpmiqMWsRR/PQDwAfDc2e1ysQwDxmkkXaDqtA29+i/DLbng9Cf9Qh2a+zE0wExzK71WhNrtQmF5OWG7RJSZ6TRnUIFX/LNY52OdA+MawCx4v3ZdpUmJ2ETyfrkKlXC0mQixYtr0p7OCuRxypTcBgwkIWx6q+SE9rMsDyvLEPFeqhaWDCd2UkPTi2xKhdHSEKQGXAgrhHLOoOb1PYi/E6DYuuaGCH841bwrOVXDS3SYXqo205oVGiB/akOJhvAdzjJjWxX2uK10CGaCES9iAQqm/24TG/79WPVVeOhgaLkQy1wCsBACocPw3aVabakwFOA8CsI/mCqtY23skTTwBFh50ovVi6Gb+ntgjRDo3NigYruFnxpF4S/jB0DY4eQa9cAkRLqisA7Cf0EeiKKuzsPPPIDfuK7wpGrGtkbakMxLPAHYW/XsfkGbXRgxtw46rBCgTNv+2r7AlKa4+Dt5HQYWTeErEE8Ab5QvLHhg7pNRxKDQnyjCcNHXP4ByAGIRZfrLuz/Cn916dUd1u0RNmIGBLooObGYwabsGJAEFB4WoM1sjw+7C4SqTiQZJuT3y+MWNT50VFpL/eAzCMLQczqY681hU+CjUHTwp9MRPSGxlVjCa/OFv4sdf/iv26aHNUa4N"
									alt="" id="pagespeed_img_8l6F7wBFOG2">
							</div>
							<div class="content">
								<h3><a href="job-details.html">{{ row.titulo }}</a></h3>
								<p class="brand">MizTech</p>
								<div class="tags">
									<span><i class="lni-map-marker"></i> New York</span>
									<span><i class="lni-user"></i>John Smith</span>
								</div>
								<span class="full-time">Full Time</span>
							</div>
						</div>
					</div>
					<!-- <div class="col-12 text-center mt-4">
						<a href="#" class="btn btn-common">Browse All Jobs</a>
					</div> -->
				</div>
			</div>
		</section>
		<!-- <main class="container">
			<div class="row mt-2">
				<div class="col-md-6">
					<el-input class="my-3" placeholder="Buscar nombre del puesto" v-model="search.titulo"
						style="width: 100%;" size="large" prefix-icon="Search" clearable filterable />
				</div>
				<div class="col-md-6">
					<el-pagination style="justify-content: right;" class="mt-3" @current-change="getRecords2"
						layout="prev, pager, next" :total="pagination.total == undefined ? 0 : pagination.total" background
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
							<span class="bd-placeholder-img">S/ {{ row.sueldo }}</span>
						</div>
					</div>
				</div>
			</div>
		</main>
		<postulacion-form v-if="showDialog" :showDialog="showDialog" :recordForm="recordForm" :userData="userData"
			@closeModal="closeModal" /> -->
	</div>
</template>
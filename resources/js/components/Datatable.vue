<script>
import { defineComponent, ref, inject, onMounted, watch } from 'vue'
import queryString from 'query-string'
export default defineComponent({
	props: {
		resource: String,
		showReload: { type: Boolean, default: false },
	},
	setup(props) {
		const emitter = inject("emitter");
		const search = ref({
			column: null,
			value: null
		});
		
		const columns = ref([]);
		const records = ref([]);
		const pagination = ref({});
		const users = ref([]);

		const getRecords = () => {
			return axios
				.get(`/${props.resource}/records?${getQueryParameters()}`)
				.then((response) => {
					records.value = response.data.data;
					pagination.value = response.data.meta;
					pagination.value.per_page = parseInt(response.data.meta.per_page);
				});
		};

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
		};

		const changeClearInput = () => {
			search.value.value = '';
			getRecords();
		};

		const getUsuarios = () => {
			axios.get(`/users/records`).then(({ data }) => {
				users.value = data.data;
			});
		};

		watch(() => search.value.column, (newColumn) => {
			if (newColumn === 'user_id') {
				getUsuarios();
			}
		});

		watch(search.value, () => {
			getRecords();
		});

		onMounted(async () => {
			const column_resource = props.resource.split('/');
			await axios.get(`/${column_resource[0]}/columns`).then((response) => {
				columns.value = response.data;
				search.value.column = Object.keys(columns.value)[0];
			});

			await getRecords();
		});

		emitter.on('reloadData', async () => {
			await getRecords();
		});

		return {
			getRecords2,
			search,
			columns,
			records,
			pagination,
			users,
			customIndex,
			changeClearInput,
		}
	}
})
</script>

<template>
	<div class="row mt-2 mb-2">
		<div class="col-md-12 col-lg-12 col-xl-12 mb-3 mt-2">
			<div class="row">
				<div class="col-lg-4 col-md-4 col-sm-12 pb-2">
					<div class="d-flex">
						<div style="width: 120px; font-weight: 800;">
							<strong>Filtrar por:</strong>
						</div>
						<el-select v-model="search.column" placeholder="Select" @change="changeClearInput">
							<el-option v-for="(label, key) in columns" :key="key" :value="key" :label="label"></el-option>
						</el-select>
					</div>
				</div>
				<div class="col-lg-3 col-md-4 col-sm-12 pb-2">
					<template v-if="search.column == 'user_id'">
						<el-select v-model="search.value" filterable clearable>
							<el-option v-for="option in users" :key="option.id" :value="option.id" :label="option.name"></el-option>
						</el-select>
					</template>
					<template v-else>
						<el-input placeholder="Buscar" v-model="search.value" style="width: 100%;" prefix-icon="el-icon-search" clearable @input="getRecords2"/>
					</template>
				</div>
				<div class="col-xl-2">
					<div class="form-group col-12" v-if="showReload">
						<button type="button" class="btn" @click.prevent="getRecords2" data-toggle="tooltip" title="Refrescar">
							<i class="fa fa-refresh text-warning fs-18"></i>
						</button>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="table-responsive tableFixHead ">
				<table class="table table-head-purple header-fixed my-table-scroll ">
					<thead>
						<slot name="heading"></slot>
					</thead>
					<tbody>
						<slot v-for="(row, index) in records" :row="row" :index="customIndex(index)" name="tbody"></slot>
					</tbody>
					<tfoot>
						<slot name="foot"></slot>
					</tfoot>
				</table>
				<div class="mt-2">
					<el-pagination v-model:current-page="pagination.current_page" :page-size="pagination.per_page"
						layout="total, prev, pager, next" :total="pagination.total == undefined ? 0 : pagination.total"
						@current-change="getRecords2" />
				</div>
			</div>
		</div>
	</div>
</template>
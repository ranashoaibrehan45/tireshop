<template>
	<div id="page-wrapper">
		<div class="row">
		    <div class="col-lg-12">
		        <h1 class="page-header">Services List</h1>
		    </div>
		</div>
		
		<div class="row">
		    <div class="col-lg-12">
		    	<div v-if="success" class="alert alert-success" role="alert">
		    		<strong>Well done!</strong> {{success_msg}}
		    	</div>
		    	<div class="text-right" style="padding:5px">
		    		<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#addServiceModal">+</button>	
		    	</div>
		    	

		        <div class="panel panel-default">
		            <div class="panel-heading">
		                Services list view
		            </div>
		            
		            <div class="panel-body">
		                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
		                    <thead>
		                        <tr>
		                            <th>ID</th>
		                            <th>Name</th>
		                            <th>Description</th>
		                            <th>Price</th>
		                            <th width="15%">Action</th>
		                        </tr>
		                    </thead>
		                    <tbody>
		                        <tr v-for="service in services.data">
		                            <td>{{service.id}}</td>
		                            <td>{{service.name}}</td>
		                            <td>{{service.description}}</td>
		                            <td>{{service.price}}</td>
		                            <td width="15%">
		                            	<button class="btn btn-sm btn-success" data-toggle="modal" data-target="#previewServiceModal" @click="getRecord(service.id)">
		                            		<i class="fa fa-search"></i>
		                            	</button>

		                            	<button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editServiceModal" @click="getRecord(service.id)">
		                            		<i class="fa fa-edit"></i>
		                            	</button>
		                            	
		                            	<button class="btn btn-sm btn-danger" @click="delRecord(service.id)">
		                            		<i class="fa fa-times"></i>
		                            	</button>
		                            </td>
		                        </tr>
		                    </tbody>
		                </table>
		                <div class="p-2 text-center">
							<pagination :data="services" @pagination-change-page="getResults"></pagination>
						</div>
		            </div>
		        </div>
		    </div>
		</div>
		<div id="models">
			<addService @serviceCreated="refreshRecord"></addService>
			<editService :service="editRec" @serviceUpdated="refreshRecord"></editService>
			<previewService :service="editRec"></previewService>
		</div>
	</div>
</template>

<script type="text/javascript">
	import Vue from 'vue';
	Vue.component('pagination', require('laravel-vue-pagination'));
	Vue.component('addService', require('./ServiceCreate.vue').default);
	Vue.component('editService', require('./ServiceEdit.vue').default);
	Vue.component('previewService', require('./ServicePreview.vue').default);

	export default{
		data(){
			return{
				success:false,
				success_msg:'',
				services:{},
				editRec:{},
				errors:[],
				current_page:1
			}
		},
		created(){
			this.getResults();
		},
		methods: {
			getResults(page = 1) {
				axios.get('service?page=' + page)
					.then(response => {
						console.log(response.data);
						if(response.data.data.length > 0)
						{
							this.services = response.data;
							this.current_page = this.services.current_page;
							console.log(this.services);
						}
					})
					.catch(error=>{
						console.log(error)
					});
			},
			getRecord(id)
			{
				axios.get('service/' + id + '/edit')
				.then(response => {
					console.log(response);
					this.editRec = response.data;
					console.log(this.editRec);
				})
				.catch(error => this.errors = error.response.data.errors)
			},
			delRecord(id)
			{
				if(confirm("Really mean to delete this service."))
				{
					axios.post("service/" + id,{
						'id': id,
						'_method': 'DELETE'
					})
					.then(response => {
						this.success = true;
						this.success_msg = 'Record has been delete successfully.';
						this.getResults(this.current_page);
					})
					.catch(error => this.errors = error.response.data.errors)
				}
			},
			refreshRecord(records)
			{
				console.log(records);
				this.services = records.data
			}
		}
	}
</script>

<style type="text/css" scoped></style>
<template>
	<div id="page-wrapper">
		<div class="row">
		    <div class="col-lg-12">
		        <h1 class="page-header">Tires Stock Record List</h1>
		    </div>
		</div>
		
		<div class="row">
		    <div class="col-lg-12">
		    	<div v-if="success" class="alert alert-success" role="alert">
		    		<strong>Well done!</strong> {{success_msg}}
		    	</div>

		        <div class="panel panel-default">
		            <div class="panel-heading">
		                Tires Stock list
		            </div>
		            
		            <div class="panel-body">
		                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
		                    <thead>
		                        <tr>
		                            <th>ID</th>
		                            <th>Company</th>
		                            <th>Size</th>
		                            <th>Quantity</th>
		                            <th>Sale Price / Unit</th>
		                            <th width="15%">Action</th>
		                        </tr>
		                    </thead>
		                    <tbody>
		                        <tr v-for="tire in tires.data">
		                            <td>{{tire.id}}</td>
		                            <td>{{tire.company.name}}</td>
		                            <td>{{tire.size.name}}</td>
		                            <td>{{tire.quantity}}</td>
		                            <td>{{tire.price}}</td>
		                            <td width="15%">
		                            	<button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editTireStockModal" @click="getRecord(tire.id)">
		                            		<i class="fa fa-edit"></i>
		                            	</button>
		                            	
		                            	<button class="btn btn-sm btn-danger" @click="delRecord(tire.id)">
		                            		<i class="fa fa-times"></i>
		                            	</button>
		                            </td>
		                        </tr>
		                    </tbody>
		                </table>
		                <div class="p-2 text-center">
							<pagination :data="tires" @pagination-change-page="getResults"></pagination>
						</div>
		            </div>
		        </div>
		    </div>
		</div>
		<div id="models">
			<editTireStock :tire="editRec" @tireStockUpdated="refreshRecord"></editTireStock>
		</div>
	</div>
</template>

<script type="text/javascript">
	import Vue from 'vue';
	Vue.component('pagination', require('laravel-vue-pagination'));
	Vue.component('editTireStock', require('./TireStockEdit.vue').default);
	
	export default{
		data(){
			return{
				success:false,
				success_msg:'',
				tires:{},
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
				axios.get('tire_stock?page=' + page)
					.then(response => {
						console.log(response.data);
						if(response.data.data.length > 0)
						{
							this.tires = response.data;
							this.current_page = this.tires.current_page;
							console.log(this.tires);
						}
					})
					.catch(error=>{
						console.log(error)
					});
			},
			getRecord(id)
			{
				axios.get('tire_stock/' + id + '/edit')
				.then(response => {
					console.log(response);
					this.editRec = response.data;
					console.log(this.editRec);
				})
				//.catch(error => this.errors = error.response.data.errors)
			},
			refreshRecord(records)
			{
				console.log(records);
				this.tires = records.data
			}
		}
	}
</script>

<style type="text/css" scoped></style>
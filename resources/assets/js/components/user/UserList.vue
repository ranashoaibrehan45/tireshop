<template>
	<div id="page-wrapper">
		<div class="row">
		    <div class="col-lg-12">
		        <h1 class="page-header">Users List</h1>
		    </div>
		</div>
		
		<div class="row">
		    <div class="col-lg-12">
		    	<div v-if="success" class="alert alert-success" role="alert">
		    		<strong>Well done!</strong> {{success_msg}}
		    	</div>

		    	<div class="text-right" style="padding:5px">
		    		<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#addUserModal">+</button>	
		    	</div>
		    	

		        <div class="panel panel-default">
		            <div class="panel-heading">
		                Users list view
		            </div>
		            
		            <div class="panel-body">
		                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
		                    <thead>
		                        <tr>
		                            <th>ID</th>
		                            <th>Name</th>
		                            <th>Username</th>
		                            <th>Email</th>
		                            <th>Role</th>
		                            <th>Action</th>
		                        </tr>
		                    </thead>
		                    <tbody>
		                        <tr v-for="record in result.data">
		                            <td>{{record.id}}</td>
		                            <td>{{record.first_name}} {{record.last_name}}</td>
		                            <td>{{record.username}}</td>
		                            <td>{{record.email}}</td>
		                            <td>{{record.role}}</td>
		                            <td>
		                            	<button class="btn btn-sm btn-success" data-toggle="modal" data-target="#previewUserModal" @click="getRecord(record.id)">
		                            		<i class="fa fa-search"></i>
		                            	</button>

		                            	<button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editUserModal" @click="getRecord(record.id)">
		                            		<i class="fa fa-edit"></i>
		                            	</button>
		                            	
		                            	<button class="btn btn-sm btn-danger" @click="delRecord(record.id)">
		                            		<i class="fa fa-times"></i>
		                            	</button>
		                            </td>
		                        </tr>
		                    </tbody>
		                </table>
		                <div class="p-2 text-center">
							<pagination :data="result" @pagination-change-page="getResults"></pagination>
						</div>
		            </div>
		        </div>
		    </div>
		</div>
		<div id="models">
			<addUser @userCreated="refreshRecord"></addUser>
			<editUser :rec="editRec" @userUpdated="refreshRecord"></editUser>
			<previewUser :rec="editRec"></previewUser>
		\</div>
	</div>
</template>

<script type="text/javascript">
	import Vue from 'vue';
	Vue.component('pagination', require('laravel-vue-pagination'));
	Vue.component('addUser', require('./UserCreate.vue').default);
	Vue.component('editUser', require('./UserEdit.vue').default);
	Vue.component('previewUser', require('./UserPreview.vue').default);

	export default{
		data(){
			return{
				success:false,
				success_msg:'',
				result:{},
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
				axios.get('user?page=' + page)
					.then(response => {
						console.log(response.data);
						if(response.data.data.length > 0)
						{
							this.result = response.data;
							this.current_page = this.result.current_page;
							console.log(this.result);
						}
					})
					.catch(error=>{
						console.log(error)
					});
			},
			getRecord(id)
			{
				axios.get('user/' + id + '/edit')
				.then(response => {
					console.log(response);
					this.editRec = response.data;
					console.log(this.editRec);
				})
				.catch(error => this.errors = error.response.data.errors)
			},
			delRecord(id)
			{
				if(confirm("Really mean to delete this record?"))
				{
					axios.post("user/" + id,{
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
				this.result = records.data
			}
		}
	}
</script>
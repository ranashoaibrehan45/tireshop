<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
            	<div class="card">
	                <div class="card-header bg-primary text-white">
	                	<h1>My Posted Tasks</h1>
	                </div>

	                <div class="card-body">
	                	<div class="table-responsive">
	                		<table class="table table-striped">
	                			<thead>
	                				<tr>
	                					<th>Instructions</th>
	                					<th>Category</th>
	                					<th>Size</th>
	                					<th>Bids</th>
	                					<th>Posted On</th>
	                					<th>Status</th>
	                				</tr>
	                			</thead>
	                			<tbody>
		                			<tr class="pointer" v-for="task in tasks.data" @click="taskDetails(task.id)">
		                				<td>
		                					<h4>{{task.title}}</h4>
		                					{{task.instructions}}
		                				</td>
		                				<td>
		                					{{task.subcategory.name}}<br />
		                					<small>
		                						<strong>{{task.category.name}}</strong>
		                					</small>
		                				</td>
		                				<td>{{task.estimated_time}}</td>
		                				<td>{{task.bids.length}}</td>
		                				<td>{{task.created_at}}</td>
		                				<td><span v-bind:class="[task.status=='hired'? 'text-success font-weight-bold':'text-primary']">{{task.status}}</span></td>
		                			</tr>
	                			</tbody>
	                		</table>
	                		<div class="p-2 text-center">
								<pagination :data="tasks" @pagination-change-page="getClientTasks"></pagination>
							</div>
	                	</div>
	                </div><!--End of card body-->
	            </div><!--End of card--> 
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">
	import Vue from 'vue';
	Vue.component('pagination', require('laravel-vue-pagination'));
	
	var Hashids = require('hashids');
	var hashids = new Hashids();
	
	export default{
		data(){
			return{
				tasks:{},
				current_page:1
			}
		},
		created(){
			this.getClientTasks()
		}, // end of created

		methods:{
			getClientTasks(page=1){
				axios.get('client/task?page=' + page)
				.then(response => {
					console.log(response.data);
					if(response.data.data.length > 0)
					{
						this.tasks = response.data;
						this.current_page = this.tasks.current_page;
						console.log(this.tasks);
					}
				})
				.catch(error=>{
					console.log(error)
				});
			},
			taskDetails(id)
			{
				id = hashids.encode(id);
				this.$router.push({name: 'taskBidding', params:{id: id}});
			}
		}// end of methods
	}
</script>
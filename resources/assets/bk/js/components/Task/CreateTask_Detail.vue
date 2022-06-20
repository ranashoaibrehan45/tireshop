<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
            	<div class="card">
	                <div class="card-header bg-primary text-white">
	                	<h1 v-if="task.subcategory">{{task.subcategory.name}}</h1>
  						<h3>{{task.subcategory.description}}</h3>
	                </div>

	                <div class="card-body">
	                  <div class="text-center">	
	                	<h1>Describe Your Task</h1>
		            	<p>We need these inputs to show only qualified and available Taskers for the job.</p>
	            	  </div>

	            	  <div id="accordion">
	            		<div class="card">
					      <div class="card-header bg-info text-white">
					        <h3 class="d-inline">Interest</h3>
					        <router-link :to="{name: 'taskInterest'}" class="float-right text-white mt-2">
					        	<font-awesome-icon icon="edit" />
					    	</router-link>

					    	<p v-if="task.interest==1">
					    		<font-awesome-icon icon="clipboard-check" />
					    		I am ready to book right now
					    	</p>

					    	<p v-if="task.interest==2">
					    		<font-awesome-icon icon="clipboard-check" />
					    		I am interested in booking sometime soon
					    	</p>

					    	<p v-if="task.interest==3">
					    		<font-awesome-icon icon="clipboard-check" />
					    		I'm just browsing
					    	</p>
					      </div>
					    </div>

					    <div class="card mt-2 bg-info text-white">
					      <div class="card-header">
					      	<div class="row">
					      		<div class="col-md-11">
					      			<h3>Your Task Location</h3>
					      		</div>
					      		<div class="col-md-1 text-right">
					      			<router-link :to="{name: 'taskLocation'}" class="float-right text-white mt-2">
							        	<font-awesome-icon icon="edit" />
							    	</router-link>
					      		</div>
					      		<div class="col-md-12">
					      			<p>
							        	<!--<font-awesome-icon icon="location" />-->
							        	{{ task.street_address }}, {{task.apt}}
							    	</p>
					      		</div>
					      	</div>
					        
					      </div>
					    </div>


					    <div class="card mt-2 bg-light">
					      	<div class="card-header">
					        	<h3>Task Details</h3>
					       	</div>
					       	<div class="show" data-parent="#accordion">
						        <div class="card-body">
									<h4>How big is your task</h4>
									<hr />
									<label class="radio-inline">
										<input type="radio" v-model="estimated_time" value="Small - Est. 1 hr"> Small - Est. 1 hr
									</label>
									<label class="radio-inline ml-lg-3">
										<input type="radio" v-model="estimated_time" value="Medium - Est. 2-3 hrs" checked> Medium - Est. 2-3 hrs
									</label>
									<label class="radio-inline ml-lg-3">
										<input type="radio" v-model="estimated_time" value="Large - Est. 4+ hrs"> Large - Est. 4+ hrs
									</label>

									<section class="mt-4">
										<h4>Vehicle Requirements</h4>
										<hr />
										<div class="radio">
											<label>
												<input type="radio" v-model="vehicle" value="0" checked>
												Not needed for task
											</label>
										</div>
										
										<div class="radio" v-for="obj in vehicles">
											<label>
												<input v-model="vehicle" type="radio" :value="obj.id" checked>
												{{obj.name}}
											</label>
										</div>
									</section>

						            <div class="text-center">
						           		<button @click="saveDetails" class="btn btn-success btn-lg pl-4 pr-4">
						           		Save</button>
						            </div>
						        </div>
						    </div>
					    </div>
					    
					    <div class="card mt-2 bg-danger text-white">
					      <div class="card-header">
					        <h3>Special Information</h3>
					      </div>
					    </div>
					    


	            	  </div><!--End of accordion div-->

	                </div><!--End of card body-->
	            </div><!--End of card--> 
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">
	export default{
		data(){
			return{
				task:{},
				vehicles:[],
				estimated_time:'Medium - Est. 2-3 hrs',
				vehicle: 0
			}
		},
		created(){
			this.task = JSON.parse(this.$ls.get('task'));
			console.log(this.task);

			if(this.task.estimated_time)
			{
				this.estimated_time = this.task.estimated_time;
			}
			if(this.task.vehicle)
			{
				this.vehicle = this.task.vehicle;
			}
			axios.get('get/vehicles')
			.then(response => { this.vehicles = response.data });

		}, // end of created

		methods:{
			saveDetails(){
				this.task.estimated_time = this.estimated_time
				this.task.vehicle = this.vehicle;;
				this.$ls.set('task', JSON.stringify(this.task));

				this.$notify({
				  group: 'notification',
				  type: 'success',
				  title: "Well done",
				  text: "Task details has been saved successfully."
				});

				this.$router.push({name: 'taskInstructions'});
			}
		}
	}
</script>
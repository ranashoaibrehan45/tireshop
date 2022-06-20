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


					    <div class="card mt-2 bg-info text-white">
					      	<div class="card-header">
					      		<div class="row">
					      			<div class="col-md-11">
					      				<h3>Task Details</h3>
					      			</div>
					      			<div class="col-md-1 text-right">
						      			<router-link :to="{name: 'taskDetail'}" class="float-right text-white mt-2">
								        	<font-awesome-icon icon="edit" />
								    	</router-link>
						      		</div>
						      		<div class="col-md-12">
						      			<p>
								        	<font-awesome-icon icon="ruler-combined" />
								        	{{ task.estimated_time }}
								    	</p>
								    	<p>
								        	<font-awesome-icon icon="car" />
								        	{{ task.vehicle }}
								    	</p>
						      		</div>
					      		</div>
					      	</div>
					    </div>
					    
					    <div class="card mt-2 bg-light">
					      <div class="card-header">
					        <h3>Special Information</h3>
					        <p>Start the conversation and tell your Tasker what you need done. This helps us match you with the best ones for the job. Don't worry, you can edit this later.</p>

				        	<fieldset class="form-group">
				        		<label>Title</label>
				        		<input type="text" v-model="title" class="form-control" />
				        	</fieldset>
				        	
				        	<fieldset class="form-group">
				        		<label for="formGroupExampleInput">Special instructions</label>
				        		<textarea class="form-control" v-model="instructions"></textarea>

				        		<p>If you need two or more Taskers, please post additional tasks for each Tasker needed.</p>
				        	</fieldset>

				        	<div class="text-center">
				           		<button @click="saveInstructions" class="btn btn-success btn-lg pl-4 pr-4">See Taskers & Prices</button>
				            </div>
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
				title: '',
				instructions:''
			}
		},
		created(){
			this.task = JSON.parse(this.$ls.get('task'));
			if(this.task.title)
			{
				this.title = this.task.title;
			}
			if(this.task.instructions){
				this.instructions = this.task.instructions;
			}
			console.log(this.task);
		}, // end of created

		methods:{
			saveInstructions(){
				if(this.title=='' || this.title==undefined)
				{
					this.$notify({
					  group: 'notification',
					  type: 'error',
					  title: "Error",
					  text: "Title is required."
					});
					return false;
				}
				else
				{
					this.task.title = this.title;
				}

				if(this.instructions=='' || this.instructions==undefined)
				{
					this.$notify({
					  group: 'notification',
					  type: 'error',
					  title: "Error",
					  text: "Task instructions are required."
					});
					return false;
				}
				else{
					this.task.instructions = this.instructions;
				}
				
				this.$ls.set('task', JSON.stringify(this.task));

				this.$notify({
				  group: 'notification',
				  type: 'success',
				  title: "Well done",
				  text: "Instructions saved successfully."
				});

				this.$router.push({name: 'chooseTasker'});
			}
		}
	}
</script>
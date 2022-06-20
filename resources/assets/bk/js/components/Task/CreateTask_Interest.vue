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
					      <div class="card-header">
					        <h3>Interest</h3>
					      </div>
					      <div class="show" data-parent="#accordion">
					        <div class="card-body">
					           <h4>What brings you here today?</h4>
					           <div class="radio">
					           	<label>
					           		<input type="radio" v-model="interest" value="1" checked>
					           		I am ready to book right now
					           	</label>
					           </div>
					           <div class="radio">
					           	<label>
					           		<input type="radio" v-model="interest" value="2">
					           		I am interested in booking sometime soon
					           	</label>
					           </div>
					           <div class="radio">
					           	<label>
					           		<input type="radio" v-model="interest" value="3">
					           		I'm just browsing
					           	</label>
					           </div>

					           <div class="text-center">
					           		<button @click="saveInterest" class="btn btn-success btn-lg pl-4 pr-4">
					           		Save</button>
					           </div>
					        </div>
					      </div>
					    </div>

					    <div class="card mt-2 bg-danger text-white">
					      <div class="card-header">
					        <h3>Your Task Location</h3>
					      </div>
					    </div>


					    <div class="card mt-2 bg-danger text-white">
					      <div class="card-header">
					        <h3>Task Details</h3>
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
				interest:1
			}
		},
		created(){
			this.task = JSON.parse(this.$ls.get('task'));
			if(this.task.interest){
				this.interest = this.task.interest;
			}
			console.log(this.task);
		}, // end of created

		methods:{
			saveInterest(){
				this.task.interest = this.interest;
				this.$ls.set('task', JSON.stringify(this.task));
				this.$router.push({name: 'taskLocation'});

				this.$notify({
				  group: 'notification',
				  type: 'success',
				  title: "Well done",
				  text: "Inforation saved successfully."
				});
			}
		}
	}
</script>
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
                	  	<div class="btn-group">
						  <button type="button" class="btn btn-success">Pick a Tasker</button>
						  <button type="button" @click="makeBiddingTask" class="btn btn-default">Open for Bidding</button>
						</div>

					  	<p>After booking, you can chat with your Tasker, agree on an exact time, or go over any requirements or questions, if necessary.</p>
					  </div>
	                  <div class="row">
	                  	<div class="col-md-4">
	                  		<div class="card">
		                  		<div class="card-body">
			                  		<h3>Sort By:</h3>
			                  		<select class="form-control">
			                  			<option>Recommended</option>
			                  			<option>Price(Lowest To Highest)</option>
			                  			<option>Price(Highest To Lowest)</option>
			                  			<option>Highest Rating</option>
			                  			<option>Most Reviews</option>
			                  			<option>Number of Tasks</option>
			                  		</select>

			                  		<h3 class="mt-3">
			                  			<font-awesome-icon icon="calendar" /> Task Date
			                  		</h3>
			                  		<input type="date" v-model="task_date" :min="min_date" :max="getMaxDate" class="form-control mt-3">

			                  		<h3 class="mt-3">
			                  			<font-awesome-icon icon="clock" /> Task Time
			                  		</h3>
			                  		<input type="time" v-model="task_time" class="form-control mt-3">
			                  		
		                  		</div>
	                  		</div>
	                  	</div>
	                  	<div class="col-md-8">
	                  		<div class="card mb-3" v-for="tasker in taskers">
							    <div class="card-body">
							      <div class="row">
								      <div class="col-md-4 text-center">
								      	<img class="card-img-top" v-bind:src="getAvatar(tasker)" alt="Card image" style="width:100%">

								      	 <a href="#" class="mb-3 mt-3">Reviews & Profile</a>
								      	 <button class="btn btn-primary btn-lg mb-3" @click="saveTasker(tasker)">
								      	 See Availability</button>
								      	 <p>You can chat with your Tasker, adjust task details, or change task time after booking.</p>
								  	  </div>

								      <div class="col-md-8">
									      <h4 class="card-title">
									      	{{tasker.first_name}} {{tasker.last_name}}

									      	<span class="float-right">${{tasker.rate_perhour}}/hr</span>
									  	  </h4>
									      <p class="card-text">
									      	<strong>Distance: </strong>{{tasker.distance}} MI
									      	<br />
									      	<strong>Experience: </strong>{{tasker.experience.name}}
									      	<div>{{tasker.quick_pictch}}</div>
									      </p>
									      
								  	  </div>
							  	  </div>
							    </div>
							</div>
	                  	</div>
	                  </div>
	                </div><!--End of card body-->
	            </div><!--End of card--> 
            </div>
        </div>

		<div class="modal fade" id="modalScheduelTask">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Tasker’s Schedule</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							<span class="sr-only">Close</span>
						</button>
					</div>
					<div class="modal-body">
						<p>Choose a start time from the Tasker’s availability that works for you.</p>

						<h3 class="mt-3">
                  			<font-awesome-icon icon="calendar" /> Task Date
                  		</h3>
                  		<input type="date" v-model="task_date" :min="min_date" :max="getMaxDate" class="form-control mt-3" required>

                  		<h3 class="mt-3">
                  			<font-awesome-icon icon="clock" /> Task Time
                  		</h3>
                  		<input type="time" v-model="task_time" class="form-control mt-3" required>
					</div>
					<div class="modal-footer">
						<div class="row">
							<div class="col-md-12 text-center">
								<button type="button" @click="saveTaskSchedule" class="btn btn-primary btn-lg">
								Select & Continue</button>
							</div>
							<div class="col-md-12">
								<p>You can chat with your Tasker, adjust task details, or change task time after booking.</p>
							</div>
						</div>
						

					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

		
		<Singup></Singup>
		
    </div>
</template>

<script type="text/javascript">
	import Vue from 'vue';
	Vue.component('Singup', require('../RegisterModal.vue').default);
	
	export default{
		data(){
			return{
				task:{},
				taskers:[],
				task_date:'',
				task_time:'',
				min_date: new Date().toISOString().slice(0, 10),
			}
		},
		created(){
			this.task = JSON.parse(this.$ls.get('task'));
			this.task_date = this.task.task_date;
			this.task_time = this.task.task_time;
			console.log(this.task);

			axios.post('task/get-taskers',{
				street_address: this.task.street_address,
				category_id: this.task.category_id,
				sub_category_id: this.task.sub_category_id,
				sub_category_id: this.task.subcategory.id,
				vehicle: this.task.vehicle,
				virtual_task: this.task.virtual_task
			})
			.then(response => {
				this.taskers = response.data;
				console.log(this.taskers);
			})
			.catch(error => {
				console.log(error.response);
			})
		}, // end of created

		computed:{
			getMaxDate(){
				var someDate = new Date();
				someDate.setDate(someDate.getDate() + 15);
				return someDate.toISOString().substr(0,10);
			}
		}, // end of computed

		methods:{
			getAvatar(user){
				if(user.avatar)
				{
					return this.base_url + 'public/images/users/avatars/' + user.avatar;
				}
				else if(user.fb_id)
				{
					return user.fb_avatar;
				}
				else if(user.google_id)
				{
					return user.google_avatar;
				}
				else
				{
					return this.base_url + 'public/images/avtar.PNG';
				}
			},
			saveTasker(tasker){
				this.task.bidding = 0;
				this.task.tasker = tasker;
				this.$ls.set('task', JSON.stringify(this.task));
				this.verifyDateTime();
			},
			makeBiddingTask(){
				this.task.bidding = 1;
				this.task.tasker = undefined;
				this.$ls.set('task', JSON.stringify(this.task));
				this.task = JSON.parse(this.$ls.get('task'));
				this.verifyDateTime();
			},
			verifyDateTime(){
				if(this.task_date == "" || this.task_date == undefined)
				{
					console.log(this.task_date);
					$("#modalScheduelTask").modal();
					return;
				}
				
				if(this.task_time == "" || this.task_time == undefined)
				{
					console.log(this.task_time);
					$("#modalScheduelTask").modal();
					return;
				}

				this.saveTaskSchedule();
			},
			saveTaskSchedule()
			{
				this.task.task_date = this.task_date;
				this.task.task_time = this.task_time;
				this.$ls.set('task', JSON.stringify(this.task));

				if(this.$auth.check())
				{
					$("#modalScheduelTask").modal('hide');
					this.$router.push({name: 'confirmTask'});
				}
				else
				{
					$("#modalScheduelTask").modal('hide');
					$("#modalSignup").modal();
				}
			}
		} //End of methods
	}
</script>
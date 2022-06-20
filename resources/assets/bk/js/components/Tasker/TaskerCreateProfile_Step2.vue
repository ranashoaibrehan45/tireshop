<template>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12">
	            <div class="card">
	                <div class="card-header bg-primary text-white">
	                	<h1>Register to become a Tasker</h1>
  						<h3>Tell us about yourself!</h3>
	                </div>

	                <div class="card-body">
	                    <form role="form">
			                <div class="row media-object">
			                    <div class="col-md-2">
			                        <div class="photo-container">
			                        	<img v-bind:src="avatar" alt="Avatar" class="img-fluid img-thumbnail">
			                            

			                            <div class="pt-2 pb-2">
			                                <label class="file">
			                                	<input type="file" id="file" @change="onFileChanged">
			                                	<span class="file-custom"></span>
			                                </label>
			                                <div class="text-center">
			                                	<button type="button" class="btn btn-primary btn-sm" @click="onUpload">Upload</button>
			                                </div>
			                            </div>
			                        </div>
			                    </div>

			                    <div class="col-md-10">
			                        <p>Upload a clear, professional photo of yourself to increase your likelihood of being hired.</p>
			                    </div>
			                </div>
			            </form>

			            <hr />

		            	<div class="row">
			            	<fieldset class="col-md-6 form-group">
			            		<label for="metro">
			            		What metro would you like to work in?
			            		</label>
			            		<select class="form-control" v-model="selectedMetro">
			            			<option v-for="metro in metros" v-bind:value="metro.id">{{ metro.name }}</option>
			            		</select>
			            	</fieldset>
			            </div>

			            <hr />

			            <h3>Home Address</h3>
			            <div class="row">
			            	<fieldset class="col-md-12 form-group">
			            		<label for="street_address">Street Address</label>
			            		<input type="text" class="form-control" id="street_address" v-model="street_address" placeholder="Legal Address">
			            	</fieldset>

			            	<fieldset class="col-md-6 form-group">
			            		<label for="city">Town/City</label>
			            		<input type="text" class="form-control" id="city" v-model="city" placeholder="Legal City">
			            	</fieldset>
			            	
			            	<fieldset class="col-md-6 form-group">
			            		<label for="city">State</label>
			            		<select class="form-control" v-model="state">
			            			<option v-for="state in states" v-bind:value="state.code">{{ state.state }}</option>
			            		</select>
			            	</fieldset>

			            	<fieldset class="col-md-6 form-group">
			            		<label for="zipcode">Zipcode</label>
			            		<input type="number" class="form-control" id="zipcode" v-model="zipcode">
			            	</fieldset>

			            	<fieldset class="col-md-6 form-group">
			            		<label for="zipcode">Mile Radius Around Central Point</label>
			            		<input type="number" class="form-control" id="radius" v-model="radius">
			            	</fieldset>

			            	<fieldset class="col-md-6 form-group">
			            		<label for="birthdate">Birthdate</label>
			            		<input type="date" class="form-control" id="birthdate" v-model="birthdate">
			            	</fieldset>
			            	
			            	<fieldset class="col-md-6 form-group">
			            		<label for="city">Phone Type</label>
			            		<select class="form-control" v-model="phone_type">
			            			<option value="android">Android</option>
			            			<option value="iphone">iPhone</option>
			            		</select>
			            	</fieldset>
			            </div>

			            <p>Do you have access to a vehicle that you can reliably use for tasks?</p>
		                
		                <div class="row">
		                    <div v-for="vehicle in vehicles" class="col-md-6">
		                    	<div class="checkbox">  
		                      		<label>
		                          		<input type="checkbox" class="" v-model="selectedVehicles" v-bind:value="vehicle.id">
		                          		<div class="vehicle-info">
		                              		<div class="callout">{{ vehicle.name }}</div>
		                              		<p class="mt-2">{{ vehicle.description }}</p>
		                              		<small>{{ vehicle.example }}</small>
		                          		</div>
		                      		</label>
		                    	</div>
		                    </div>


		                    <div class="col-md-12">
		                    	<hr/>
			                    <fieldset class="col-md-6 form-group">
				            		<label for="city">
				            			How did you hear about {{this.AppName}}?
				            		</label>
				            		<select class="form-control" v-model="selectedResource">
				            			<option v-for="resource in resources" v-bind:value="resource.id">{{ resource.name }}</option>
				            		</select>
				                </fieldset>
			            	</div>
		                </div>

		                <div class="text-center pt-5">
		                	<button type="button" class="btn btn-primary btn-lg" @click="saveTaskerInfo">Save & Continue</button>
		                </div>
		                

	                </div>
	            </div>
	        </div>
		</div>
	</div>
</template>
<script type="text/javascript">
	export default{
		data(){
			return {
				profile:{},
				avatar: this.$auth.user().avatar,
				selectedFile: null,
				metros:[],
				street_address:'',
				city:'',
				state:'',
				states:[],
				selectedMetro:'',
				zipcode:'',
				radius:'',
				birthdate:'',
				phone_type:'',
				vehicles:[],
				selectedVehicles:[],
				resources:[],
				selectedResource:'',
				errors:[]
			}
		},
		created(){
			if(this.$auth.user().avatar)
			{
				this.avatar = this.base_url + 'public/images/users/avatars/' + this.$auth.user().avatar;
			}
			else if(this.$auth.user().fb_id)
			{
				this.avatar = this.$auth.user().fb_avatar;
			}
			else if(this.$auth.user().google_id)
			{
				this.avatar = this.$auth.user().google_avatar;
			}
			else
			{
				this.avatar = this.base_url + 'public/images/avtar.PNG';
			}

			// Get Profile Id
			axios.get('/get/tasker_profile/'+this.$auth.user().id).
			then(response => {
				if(response.data.commitment==0)
				{
					this.$router.push({name: 'TaskerCreateProfile_Step1'});
				}
				
				this.profile = response.data;
				this.street_address = this.profile.street_address;
				this.city = this.profile.city;
				this.zipcode = this.profile.zipcode;
				this.radius = this.profile.radius;
				this.birthdate = this.profile.birthdate;
				this.phone_type = this.profile.phone_type;

				// Get Metros
				axios.get('/get/metros').
				then(response => {
					this.metros = response.data;
					this.selectedMetro = this.profile.metro;
				});
				
				// Get States
				axios.get('/get/states').
				then(response => {
					this.states = response.data;
					this.state = this.profile.state;
				});
				
				// Get Vehicles
				axios.get('/get/vehicles').
				then(response => {
					this.vehicles = response.data;
					var app = this;
					$.each(this.profile.vehicles, function(i, obj){
						app.selectedVehicles.push(obj.vehicle_id);
					})
				});

				// Get Vehicles
				axios.get('/get/resource').
				then(response => {
					this.resources = response.data;
					this.selectedResource = this.profile.resource;
				});
			});
		},
		methods:{
			onFileChanged (event) {
				this.selectedFile = event.target.files[0];
			},
			onUpload() {
				var formData = new FormData();
				formData.append("image", this.selectedFile);
				formData.append("user_id", this.$auth.user().id);

				axios.post('user-profile/file-upload', formData, 
					{headers: {'Content-Type': 'multipart/form-data'}}
				)
				.then(response => {
					if(response.data.success==1)
					{
						this.avatar = this.base_url + 'public/images/users/avatars/' + response.data.avatar;
					}
				})
				.catch(error => {
					console.log("error");
					console.log(error.response);
				})
			},
			NotificationError(name, msg){
				console.log(name + ":" + msg);
			},
			saveTaskerInfo(){
				if(this.profile.id == 0)
				{
					app.$notify({
					  group: 'notification',
					  type: 'error',
					  title: 'Oops!',
					  text: "There is some thing wrong, try again after some time."
					});
					return;
				}
				axios.post('tasker_profile/' + this.profile.id ,{
					_method: 'PUT',
					metro: this.selectedMetro,
					street_address: this.street_address,
					city: this.city,
					state: this.state,
					zipcode: this.zipcode,
					radius: this.radius,
					birthdate: this.birthdate,
					phone_type: this.phone_type,
					vehicle: this.selectedVehicles,
					resource: this.selectedResource
				})
				.then(response => {
					if(parseInt(response.data.success)==1)
					{
						this.$router.push({ name: "TaskerCreateProfile_Step3"})
					}

					this.$notify({
					  group: 'notification',
					  type: 'success',
					  position: 'top center',
					  title: 'Success',
					  text: 'Information saved successfully!'
					});
				})
				.catch(error => {
					var app = this;
					this.errors = error.response.data.errors;
					$.each(this.errors, function(name, obj){
						$.each(obj, function(i, msg){
							app.$notify({
							  group: 'notification',
							  type: 'error',
							  title: 'Error in ' + name + " field",
							  text: msg
							});
						});
					});
				})
			}
		}
	}
</script>

<style>
.checkbox{
	min-height: 140px;
}
div.checkbox p{min-height:40px}
.vehicle-info{
	margin-left: 30px;
	margin-top:-20px;
}
</style>
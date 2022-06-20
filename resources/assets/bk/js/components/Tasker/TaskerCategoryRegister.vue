<template>
	<div>
		<div class="modal fade" id="modalRegisterCategory">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">{{category.name}}</h4>
						<button type="button" @click="resetModal" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							<span class="sr-only">Close</span>
						</button>
					</div>
					<div class="modal-body">
                        <div class="row">
                          <div class="col-md-12">
                            <h3>Set hourly rate</h3>
                            <p>Tasks completed in category: <strong>0</strong></p>
                          </div>
                        </div>
                        
                        <div class="row mb-4">
                          <div class="col-md-12">
                          	$ <input type="number" v-model="rate_perhour" 
                            class="form-control form-inline col-md-6 d-inline PerHourRate"> . {{calculateHomeTakeRate}} / hr
                          
                            <div class="pl-2 mt-2">
                            	<strong>Take-home rate:</strong>
                            	$<span>{{calculateHomeTakeRate}}</span>/hr

                            	<p class="mt-3">
                            		Most Taskers with your experience hired at: <strong>${{ category.min_rate }}/hr</strong>
                            	</p>
                        	</div>
                          </div>
                        </div>
                    	
                        <fieldset class="form-group mb-4">
                  			<label for="experience"><h5>Level Of Experience</h5></label>
                  			<select class="form-control" v-model="experience">
                  				<option v-for="obj in experiences" :value="obj.id">{{ obj.name }}</option>
                  			</select>
                  		</fieldset>

                  		<fieldset class="form-group mb-4">
                  			<label for="experience"><h5>Your Quick Pitch</h5></label>
                  			<textarea v-model="quick_pictch" class="form-control quickPitchTxt" maxlength="250" rows="5" style="width:100%"></textarea>
                            <div class="warning pitch_warning text-right">Can't be blank</div>
                  		</fieldset>

					</div>
					<div class="modal-footer">
						<button type="button" @click="resetModal" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="button" @click="saveSkills" class="btn btn-primary">Save changes</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
	</div>
</template>
<script type="text/javascript">
	export default{
		props:['category'],
		data(){
			return {
				experiences : [],
				rate_perhour: '',
				experience:'',
				quick_pictch:'',
				homeTakeRate: 0,
				errors: []
			}
		},
		created(){
			axios.get('get/experience')
			.then(response => {
				this.experiences = response.data;
			})
			.catch(error => {
				console.log(error.response);
			})
		},
		computed: {
		    calculateHomeTakeRate: function()
			{
				return (this.rate_perhour * 80) / 100;
			},
		},
		methods:{
			saveSkills()
			{
				axios.post('tasker_skill',{
					user_id: this.$auth.user().id,
					sub_category_id: this.category.id,
					experience_id: this.experience,
					quick_pictch: this.quick_pictch,
					rate_perhour: this.rate_perhour
				})
				.then(response => {
					console.log("success");
					console.log(response.data);
					
					this.$emit('skillRegistered', response);
					$("#modalRegisterCategory").modal("hide");
					this.resetModal();
					
					this.$notify({
					  group: 'notification',
					  type: 'success',
					  title: "Well done",
					  text: "Skill has been added successfully."
					});
				})
				.catch(error => {
					console.log("error");
					if(error.response!==undefined)
					{
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
					}
				})
			},
			resetModal()
			{
				this.rate_perhour= '';
				this.experience='';
				this.quick_pictch='';
				this.homeTakeRate= 0;
				this.errors= [];
			}
		}
	}
</script>
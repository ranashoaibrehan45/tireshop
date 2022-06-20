<template>
	<div>
		<div class="modal fade" id="modalCategoryEdit">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" v-if="rec.category">{{rec.category.name}}</h4>
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
                          	$ <input type="number" v-model="rec.rate_perhour" 
                            class="form-control form-inline col-md-6 d-inline PerHourRate"> . {{calculateHomeTakeRate}} / hr
                          
                            <div class="pl-2 mt-2">
                            	<strong>Take-home rate:</strong>
                            	$<span>{{calculateHomeTakeRate}}</span>/hr

                            	<p class="mt-3" v-if="rec.category">
                            		Most Taskers with your experience hired at: <strong>${{ rec.category.min_rate }}/hr</strong>
                            	</p>
                        	</div>
                          </div>
                        </div>
                    	
                        <fieldset class="form-group mb-4">
                  			<label for="experience"><h5>Level Of Experience</h5></label>
                  			<select class="form-control" v-model="rec.experience_id">
                  				<option v-for="obj in experiences" :value="obj.id">{{ obj.name }}</option>
                  			</select>
                  		</fieldset>

                  		<fieldset class="form-group mb-4">
                  			<label for="experience"><h5>Your Quick Pitch</h5></label>
                  			<textarea v-model="rec.quick_pictch" class="form-control quickPitchTxt" maxlength="250" rows="5" style="width:100%"></textarea>
                            <div class="warning pitch_warning text-right">Can't be blank</div>
                  		</fieldset>

					</div>
					<div class="modal-footer">
						<button type="button" @click="resetModal" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="button" @click="updateSkills" class="btn btn-primary">Update</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
	</div>
</template>
<script type="text/javascript">
	export default{
		props:['rec'],
		data(){
			return {
				experiences : [],
				errors: [],
				loading: false
			}
		},
		created(){
			// get experiences
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
				return (this.rec.rate_perhour * 80) / 100;
			},
		},
		methods:{
			updateSkills()
			{
				axios.post('tasker_skill/' + this.rec.id,{
					_method: 'PUT',
					sub_category_id: this.rec.sub_category_id,
					experience_id: this.rec.experience_id,
					quick_pictch: this.rec.quick_pictch,
					rate_perhour: this.rec.rate_perhour
				})
				.then(response => {
					console.log("success");
					console.log(response.data);
					
					this.$emit('skillUpdated', response);
					$("#modalCategoryEdit").modal("hide");
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
				this.errors= [];
			}
		}
	}
</script>
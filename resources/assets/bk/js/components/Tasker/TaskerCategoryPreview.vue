<template>
	<div>
		<div class="modal fade" id="modalCategoryPreview">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" v-if="rec.category">{{rec.category.name}}</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							<span class="sr-only">Close</span>
						</button>
					</div>
					<div class="modal-body">
                        <div class="row">
                          <div class="col-md-12">
                            <h3>Hourly rate</h3>
                          </div>
                        </div>
                        
                        <div class="row mb-4">
                          <div class="col-md-12">
                          	$ {{rec.rate_perhour}} / hr
                          </div>
                        </div>
                    	
                        <fieldset class="form-group mb-4">
                  			<label for="experience"><h5>Level Of Experience</h5></label>
                  			<p v-if="rec.experience">{{rec.experience.name}}</p>
                  		</fieldset>

                  		<fieldset class="form-group mb-4">
                  			<label for="experience"><h5>Your Quick Pitch</h5></label>
                  			<p>{{rec.quick_pictch}}</p>
                  		</fieldset>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
			}
		}
	}
</script>
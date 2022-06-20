<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
            	<div class="col-md-8 offset-2">
	            	<h1>The convenient & affordable way to get things done around the home</h1>
	            	<button v-for="category in categories" 
	            			@click="getSubCategories(category.id)"
			            	data-toggle="modal" 
			            	data-target="#modalSubCategories"
			            	type="button" 
			            	class="btn btn-outline-primary mb-3 ml-2">
	            	{{category.name}}
	            	</button>
            	</div>
            </div>
        </div>

		<div class="modal fade" id="modalSubCategories">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Choose Sub-Category</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							<span class="sr-only">Close</span>
						</button>
					</div>
					<div class="modal-body">
						<button v-for="subcategory in subcategories" @click="createTask(subcategory)"
		            	type="button" 
		            	class="btn btn-outline-primary mb-3 ml-2">
		            	{{subcategory.name}}
		            	</button>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary">Save changes</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

    </div>
</template>

<script type="text/javascript">
	export default{
		data(){
			return{
				category_id:0,
				categories:[],
				subcategories:[],
				task:{}
			}
		},
		created(){
			axios.get('get/categories')
			.then(response => { this.categories = response.data })

			var lsTask = JSON.parse(this.$ls.get('task'));
			if(lsTask){
				this.task = lsTask;
				console.log(this.task);
			}
		}, // end of created
		methods:{
			getSubCategories(categoryId){
				this.category_id = categoryId;
				axios.get('get/subcategories/' + categoryId)
				.then(response => { this.subcategories = response.data })
			},
			createTask(subcategory)
			{
				$("#modalSubCategories").modal('hide');
				this.task.category_id = this.category_id;
				this.task.subcategory = subcategory;
				this.$ls.set('task', JSON.stringify(this.task));
				this.$router.push({name: 'taskInterest'});
			}
		}
	}
</script>
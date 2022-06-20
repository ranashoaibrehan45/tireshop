<template>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12">
	            <div class="card">
	                <div class="card-header bg-primary text-white">
	                	<h1>Register to become a Tasker</h1>
  						<h3>Add Your Rates & Skills!</h3>
	                </div>

	                <div class="card-body">
	                	<div class="text-right pb-4 bt-4">
	                		<router-link :to="{name:'TaskerCreateProfile_Step4'}" class="btn btn-primary">Continue</router-link>
	                	</div>

	                	<p>Select your work categories and set your hourly rates. Suggested rates are based on what Clients choose most often among Taskers with similar category experience in your area. By setting your rates at the suggested level, you’ll set yourself up to earn more.</p>

	                	<div id="accordion">
	                		<div class="card mb-3" v-for="category in categories">
						      <div v-bind:class="[(isMyCategory(category.id)? 'bg-info text-white':'bg-light'), 'card-header']" data-toggle="collapse" :href="'#'+category.slug">
						        <h3>{{category.name}}</h3>
						        <p>{{category.description}}</p>
						      </div>
						      <div :id="category.slug" class="collapse" data-parent="#accordion">
						        <div class="card-body">
						          <div id="sub_accordion">
						        	<div class="card mb-3" v-for="subcategory in category.subcategories">
						        		<div v-bind:class="[(isMySkill(subcategory.id)? 'bg-info text-white':'bg-light'), 'card-header']" data-toggle="collapse" :href="'#'+subcategory.slug">
								        	<h3>{{subcategory.name}}</h3>
								        	<p>{{subcategory.description}}</p>
								      	</div>
								      	<div :id="subcategory.slug" class="collapse" data-parent="#sub_accordion">
								      		<div class="card-body">
								      			<div class="card bg-faded p-3 mb-2">
									        		<div v-html="subcategory.expectations">{{subcategory.expectations}}</div>
						                            
						                            <div class="text-center">
							                            <div v-if="isMySkill(subcategory.id)">
							                            	<div class="btn-group" role="group" aria-label="Skill Control">
							                            		<button type="button" data-toggle="modal" data-target="#modalCategoryPreview" @click="editRecord(subcategory)" class="btn btn-primary">
							                            			<font-awesome-icon icon="eye" /> Preview
							                            		</button>

							                            		<button type="button" data-toggle="modal" data-target="#modalCategoryEdit" @click="editRecord(subcategory)" class="btn btn-secondary">
							                            			<font-awesome-icon icon="edit" />Edit
							                            		</button>
							                            	</div>
							                            </div>
							                            <div v-else>
								                            <button @click="addCategory(subcategory)" data-toggle="modal" data-target="#modalRegisterCategory" class="btn btn-primary">
								                            I agree that I am able to fulfill these expectations.
								                            </button>
							                            </div>
						                        	</div>
						                        </div>
								      		</div><!--End of subcategory card body-->
								      	</div>
						        	</div>
						          </div>
						        </div><!---End of category card body-->
						      </div>
						    </div>
	                	</div>

	                </div>
	            </div>
	        </div>
		</div>

		<div id="models">
			<registerCategory :category="selectedCategory" @skillRegistered="refreshRecord"></registerCategory>
			<editCategory :rec="editedSkill" @skillUpdated="refreshRecord"></editCategory>
			<previewCategory :rec="editedSkill"></previewCategory>
		</div>
	</div>
</template>

<script type="text/javascript">
	import Vue from 'vue';
	Vue.component('registerCategory', require('./TaskerCategoryRegister.vue').default);
	Vue.component('editCategory', require('./TaskerCategoryEdit.vue').default);
	Vue.component('previewCategory', require('./TaskerCategoryPreview.vue').default);

	export default{
		data(){
			return {
				categories:[],
				selectedCategory:{},
				myskills : [],
				editedSkill : {}
			}
		},
		created(){
			axios.get('get/categories')
			.then(response => {
				console.log(response.data);
				this.categories = response.data;

				$.each(this.categories, function(catId, obj){
					console.log(obj.getCategory());
				});
			})
			.catch(error => {
				console.log(error.response);
			});

			this.refreshRecord();
		},
		methods:{
			addCategory(category){
				console.log(category);
				this.selectedCategory = category;
			},
			editRecord(category){
				console.log("EditRecord");
				this.selectedCategory = category;
				this.editedSkill = this.myskills[category.id];
				console.log(this.editedSkill);
			},
			refreshRecord(){
				axios.get('tasker_skill')
				.then(response => {
					this.myskills = response.data;
					console.log("my Skills");
					console.log(this.myskills);
				})
				.catch(error => {
					console.log(error.response);
				})
			},
			isMyCategory(categoryId){
				var app = this;
				var returnVal = false;
				$.each(this.myskills, function(catId, obj){
					if(parseInt(categoryId)==parseInt(obj.category_id))
					{
						returnVal = true;
					}
				});

				return returnVal;
			},
			isMySkill(subCategoryId){
				var app = this;
				var returnVal = false;
				$.each(this.myskills, function(subCatId, obj){
					if(parseInt(subCatId)==parseInt(subCategoryId))
					{
						returnVal = true;
					}
				});

				return returnVal;
			},
		}
	}
</script>
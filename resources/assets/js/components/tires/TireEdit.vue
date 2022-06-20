<template>
    <div class="modal fade" id="editTireModal" tabindex="-1" role="dialog" aria-labelledby="editTireModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" @click="clearModel" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="editTireModalLabel">Edit Tire</h4>
                </div>

                <div class="modal-body">
                    <div v-if="success" class="alert alert-success" role="alert">
                        <strong>Well done!</strong> Tire has been updated successfully.
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div v-bind:class="[(error && errors.vender_id)? has_error:'', form_group]">
                                <label for="vender_id" class="required">Vender</label>
                                <select v-model="tire.vender_id" class="form-control">
                                    <option v-for="vender in venders" :value="vender.id">{{vender.name}}</option>
                                </select>

                                <span v-if="error && errors.vender_id" class="invalid-feedback" role="alert">
                                    <div v-for="msg in errors.vender_id">
                                        <strong>{{ msg }}</strong>
                                    </div>
                                </span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div v-bind:class="[(error && errors.company_id)? has_error:'', form_group]">
                                <label for="company_id" class="required">Company</label>
                                <select v-model="tire.company_id" class="form-control">
                                    <option v-for="company in companies" :value="company.id">{{company.name}}</option>
                                </select>

                                <span v-if="error && errors.company_id" class="invalid-feedback" role="alert">
                                    <div v-for="msg in errors.company_id">
                                        <strong>{{ msg }}</strong>
                                    </div>
                                </span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div v-bind:class="[(error && errors.size_id)? has_error:'', form_group]">
                                <label for="size_id" class="required">Size</label>
                                <select v-model="tire.size_id" class="form-control">
                                    <option v-for="size in sizes" :value="size.id">{{size.name}}</option>
                                </select>

                                <span v-if="error && errors.size_id" class="invalid-feedback" role="alert">
                                    <div v-for="msg in errors.size_id">
                                        <strong>{{ msg }}</strong>
                                    </div>
                                </span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div v-bind:class="[(error && errors.quantity)? has_error:'', form_group]">
                                <label for="quantity" class="required">Quantity</label>
                                <input type="number" v-model="tire.quantity" id="quantity" min="0" class="form-control">

                                <span v-if="error && errors.quantity" class="invalid-feedback" role="alert">
                                    <div v-for="msg in errors.quantity">
                                        <strong>{{ msg }}</strong>
                                    </div>
                                </span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div v-bind:class="[(error && errors.purchase_price)? has_error:'', form_group]">
                                <label for="purchase_price" class="required">Purchase Price</label>
                                <input type="number" v-model="tire.purchase_price" id="purchase_price" min="0" class="form-control">

                                <span v-if="error && errors.purchase_price" class="invalid-feedback" role="alert">
                                    <div v-for="msg in errors.purchase_price">
                                        <strong>{{ msg }}</strong>
                                    </div>
                                </span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div v-bind:class="[(error && errors.purchase_date)? has_error:'', form_group]">
                                <label for="purchase_date" class="required">Purchase Date</label>
                                <input type="date" v-model="tire.purchase_date" id="purchase_date" class="form-control">

                                <span v-if="error && errors.purchase_date" class="invalid-feedback" role="alert">
                                    <div v-for="msg in errors.purchase_date">
                                        <strong>{{ msg }}</strong>
                                    </div>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div v-bind:class="[(error && errors.short_note)? has_error:'', form_group]">
                                <label for="short_note">Short Note</label>
                                <textarea v-model="tire.short_note" id="short_note" class="form-control"></textarea>

                                <span v-if="error && errors.short_note" class="invalid-feedback" role="alert">
                                    <div v-for="msg in errors.short_note">
                                        <strong>{{ msg }}</strong>
                                    </div>
                                </span>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" @click="clearModel" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" @click="updateRecode" class="btn btn-primary">Update Tire</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script type="text/javascript">
    import Ckeditor from 'vueckeditor';
    export default{
        props:['tire'],
        components: {
          Ckeditor
        },
        data(){
            return {
                companies: [],
                sizes: [],
                venders: [],

                form_group : 'form-group',
                has_error : 'has-error',
                success:false,
                error: false,
                errors: [],

                config:{
                    toolbar: ['Format',
                              ['Bold', 'Italic', 'Strike', 'Underline'],
                              ['BulletedList', 'NumberedList', 'Blockquote'],
                              ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'],
                              ['Link', 'Unlink'],
                              ['FontSize', 'TextColor'],
                              ['Image'],
                              ['Undo', 'Redo'],
                              ['Source', 'Maximize']],
                    defaultLanguage: 'es'
                }
            }
        },
        created(){
            // get companies
            axios.get("/get/companies")
            .then(response => {
                console.log(response);
                this.companies = response.data;
            })
            .catch(error=>{
                console.log(error)
            });

            // get tire sizes
            axios.get('/get/sizes')
            .then(response => {
                console.log("sizes");
                console.log(response.data);
                if(response.data.length > 0)
                {
                    this.sizes = response.data;
                    console.log(this.sizes);
                }
            })
            .catch(error=>{
                console.log(error)
            });

            // get tire sizes
            axios.get('/get/venders')
            .then(response => {
                console.log("vender");
                console.log(response.data);
                if(response.data.length > 0)
                {
                    this.venders = response.data;
                    console.log(this.venders);
                }
            })
            .catch(error=>{
                console.log(error)
            });
        },
        methods:{
            updateRecode(){
                axios.post("tire/" + this.tire.id, 
                {
                    '_method': 'PUT',
                    company_id: this.tire.company_id,
                    size_id: this.tire.size_id,
                    vender_id: this.tire.vender_id,
                    quantity: this.tire.quantity,
                    purchase_price: this.tire.purchase_price,
                    sale_price: this.tire.sale_price,
                    purchase_date: this.tire.purchase_date,
                    short_note: this.tire.short_note,
                })
                .then(data => {
                    this.$emit('tireUpdated', data);
                    this.success = this.error = true;
                    this.errors=[];
                })
                .catch(error => {
                    console.log("error");
                    console.log(error.response);
                    this.error = true;
                    this.errors = error.response.data.errors;
                        
                })
            },
            clearModel(){
                this.success=false;
                this.error = false;
                this.errors=[];
            }
        }
    }
</script>
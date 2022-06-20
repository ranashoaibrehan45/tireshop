<template>
    <div class="modal fade" id="addExpensePaymentModal" tabindex="-1" role="dialog" aria-labelledby="addExpensePaymentLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="addExpensePaymentLabel">Pay Expense New</h4>
                </div>

                <div class="modal-body">
                    <div v-if="success" class="alert alert-success" role="alert">
                        <strong>Well done!</strong> Expense payment has been added successfully.
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div v-bind:class="[(error && errors.name)? has_error:'', form_group]">
                                <label for="expense_id" class="required">Expense Type</label>
                                <select v-model="expense_id" id="expense_id" class="form-control">
                                    <option v-for="expense in expenses" :value="expense.id">{{expense.name}}</option>
                                </select>

                                <span v-if="error && errors.expense_id" class="invalid-feedback" role="alert">
                                    <div v-for="msg in errors.expense_id">
                                        <strong>{{ msg }}</strong>
                                    </div>
                                </span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div v-bind:class="[(error && errors.amount)? has_error:'', form_group]">
                                <label for="amount" class="required">Amount</label>
                                <input type="number" min="0" v-model="amount" id="amount" class="form-control" />

                                <span v-if="error && errors.amount" class="invalid-feedback" role="alert">
                                    <div v-for="msg in errors.amount">
                                        <strong>{{ msg }}</strong>
                                    </div>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div v-bind:class="[(error && errors.paid_at)? has_error:'', form_group]">
                                <label for="paid_at" class="required">Paid At</label>
                                <input type="date" v-model="paid_at" id="paid_at" class="form-control" />

                                <span v-if="error && errors.paid_at" class="invalid-feedback" role="alert">
                                    <div v-for="msg in errors.paid_at">
                                        <strong>{{ msg }}</strong>
                                    </div>
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div v-bind:class="[(error && errors.description)? has_error:'', form_group]">
                                <label for="description">Short Description</label>
                                <textarea v-model="description" id="description" class="form-control"></textarea>

                                <span v-if="error && errors.description" class="invalid-feedback" role="alert">
                                    <div v-for="msg in errors.description">
                                        <strong>{{ msg }}</strong>
                                    </div>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" @click="addRecode" class="btn btn-primary">Save changes</button>
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
        components: {
          Ckeditor
        },
        data(){
            return {
                form_group : 'form-group',
                has_error : 'has-error',
                success:false,
                error: false,
                errors: [],

                expenses    : [],
                expense_id  : 0,
                amount         : 0,
                paid_at    : '',
                description : '',
                
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
            // get contacts
            axios.get("/get/expense")
            .then(response => {
                this.expenses = response.data;
            })
            .catch(error=>{
                console.log(error)
            });
        },
        methods:{
            addRecode(){
                axios.post("/expense_payment",{
                    expense_id: this.expense_id,
                    amount: this.amount,
                    paid_at : this.paid_at,
                    description: this.description,
                })
                .then(response => {
                    console.log("success");
                    console.log(response);

                    this.$emit('expensePaymentCreated', response);
                    
                    this.expense_id = 0;
                    this.amount = 0;
                    this.paid_at = '',
                    this.description = '';
                    
                    this.success = true;
                    this.error=false;
                    this.errors=[];
                })
                .catch(error => {
                    this.error = true;
                    this.errors = error.response.data.errors;
                    
                    console.log("error");
                    console.log(this.error);
                        
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
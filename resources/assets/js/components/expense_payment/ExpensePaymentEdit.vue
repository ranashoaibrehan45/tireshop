<template>
    <div class="modal fade" id="editExpensePaymentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" @click="clearModel" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Edit Expense Payment</h4>
                </div>

                <div class="modal-body">
                    <div v-if="success" class="alert alert-success" role="alert">
                        <strong>Well done!</strong> Expense Payment has been updated successfully.
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div v-bind:class="[(error && errors.name)? has_error:'', form_group]">
                                <label for="expense_id" class="required">Expense Type</label>
                                <select v-model="expensePayment.expense_id" id="expense_id" class="form-control">
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
                                <label for="amount" class="required">Amount (PKR)</label>
                                <input type="number" min="0" v-model="expensePayment.amount" id="amount" class="form-control" />

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
                                <label for="paid_at" class="required">Pay Date</label>
                                <input type="date" v-model="expensePayment.paid_at" id="paid_at" class="form-control" />

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
                                <textarea v-model="expensePayment.description" id="description" class="form-control"></textarea>

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
                    <button type="button" @click="clearModel" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" @click="updateRecode" class="btn btn-primary">Update Expense Payment</button>
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
        props:['expensePayment'],
        components: {
          Ckeditor
        },
        data(){
            return {
                form_group      : 'form-group',
                has_error       : 'has-error',
                success         :false,
                error           : false,
                errors          : [],
                expenses        : [],
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
            updateRecode(){
                axios.post("expense_payment/" + this.expensePayment.id,{
                    expense_id: this.expensePayment.expense_id,
                    amount: this.expensePayment.amount,
                    paid_at: this.expensePayment.paid_at,
                    description: this.expensePayment.description,
                    _method: 'PUT'
                })
                .then(data => {
                    this.$emit('expensePaymentUpdated', data);
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
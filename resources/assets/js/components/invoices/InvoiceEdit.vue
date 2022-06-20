<template>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Generate Invoice</h1>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-12">
                <div v-if="success" class="alert alert-success" role="alert">
                    <strong>Well done!</strong> {{success_msg}}
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        Generate Invoice
                    </div>
                    <div class="panel-body">
                        <table class="table table-primary table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Item</th>
                                    <th>Quantity</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>1.</td>
                                    <td>
                                        <select v-model="company" class="form-control" @change="getAvailableQty">
                                            <option v-for="company in companies" :value="company.id">{{company.name}}</option>
                                        </select>
                                        <select v-model="size" class="form-control" style="margin-top:5px" @change="getAvailableQty">
                                            <option v-for="size in sizes" :value="size.id">{{size.name}}</option>
                                        </select>
                                    </td>
                                    <td>
                                        <strong>Available: </strong>
                                        <span v-if="tire">{{tire.quantity}}</span>
                                        <input type="number" v-model="tire_quantity" class="form-control col-md-3" />
                                    </td>
                                    <td>
                                        <button class="btn btn-primary btn-sm" @click="addTireInvoice">Add</button>
                                    </td>
                                </tr>

                                <tr>
                                    <td>2.</td>
                                    <td>
                                        <select v-model="service" class="form-control">
                                            <option v-for="service in services" :value="service">{{service.name}}</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" v-model="service_quantity" class="form-control col-md-3">
                                    </td>
                                    <td>
                                        <button class="btn btn-primary btn-sm" @click="addServiceInvoice">Add</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        Invoice Items
                    </div>
                    <div class="panel-body">
                        <table class="table table-primary table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Item</th>
                                    <th>Quantity</th>
                                    <th>Price Per Unit</th>
                                    <th>Total Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr v-for="(invoice, index) in invoices" v-if="invoice.type==='tire'">
                                    <td>{{index+1}}</td>
                                    <td>
                                        {{invoice.item.company.name}} <br />
                                        {{invoice.item.size.name}}
                                    </td>
                                    <td>{{invoice.quantity}}</td>
                                    <td>
                                        {{invoice.item.price | toCurrency}}
                                    </td>
                                    <td>
                                        {{(invoice.item.price * invoice.quantity) | toCurrency}}
                                    </td>
                                    <td>
                                        <button class="btn btn-danger btn-sm" @click="delInvoice(invoice.id, invoice.type)">Delete</button>
                                    </td>
                                </tr>

                                <tr v-for="(invoice, index) in invoices" v-if="invoice.type==='service'">
                                    <td>{{index+1}}</td>
                                    <td>
                                        {{invoice.item.name}}
                                    </td>
                                    <td>{{invoice.quantity}}</td>
                                    <td>
                                        {{invoice.item.price | toCurrency}}
                                    </td>
                                    <td>
                                        {{(invoice.item.price * invoice.quantity) | toCurrency}}
                                    </td>
                                    <td>
                                        <button class="btn btn-danger btn-sm" @click="delInvoice(invoice.id, invoice.type)">Delete</button>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="4" align="right"><strong>Total:</strong></td>
                                    <td>{{total | toCurrency}}</td>
                                    <td>&nbsp;</td>
                                </tr>

                                <tr>
                                    <td colspan="4" align="right"><strong>Discount:</strong></td>
                                    <td><input type="number" v-model="discount" class="form-control"></td>
                                    <td>&nbsp;</td>
                                </tr>

                                <tr>
                                    <td colspan="4" align="right"><strong>Sub-Total:</strong></td>
                                    <td>{{subtotal | toCurrency}}</td>
                                    <td>&nbsp;</td>
                                </tr>

                                <tr>
                                    <td colspan="4" align="right"><strong>Amount Received:</strong></td>
                                    <td><input type="number" v-model="amount_received" class="form-control"></td>
                                    <td>&nbsp;</td>
                                </tr>

                                <tr>
                                    <td colspan="4" align="right"><strong>Remaining:</strong></td>
                                    <td>{{remaining | toCurrency}}</td>
                                    <td>&nbsp;</td>
                                </tr>

                            </tbody>
                        </table>

                        <div class="text-right">
                            <button @click="CheckoutInvoice" class="btn btn-primary btn-lg">Checkout & Generate Invoice</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                companies       : [],
                sizes           : [],
                tire            : [],
                invoices        : [],
                services        : [],

                company         : [],
                size            : [],

                company         : 0,
                size            : 0,
                tire_quantity   : 0,
                service_quantity: 0,
                discount        : 0,
                amount_received : 0,
                service         : [],
                short_note      : '',

                form_group      : 'form-group',
                has_error       : 'has-error',
                success         : false,
                error           : false,
                errors          : [],

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
                this.companies = response.data;
            })
            .catch(error=>{
                console.log(error)
            });

            // get tire sizes
            axios.get("/get/sizes")
            .then(response => {
                this.sizes = response.data;
            })
            .catch(error=>{
                console.log(error)
            });

            // get tire services
            axios.get('/get/services')
            .then(response => {
                if(response.data.length > 0)
                {
                    this.services = response.data;
                }
            })
            .catch(error=>{
                console.log(error)
            });
        },
        computed: {
            total: function() {
                if (!this.invoices) {
                    return 0;
                }

                return this.invoices.reduce(function (total, invoice) {
                    return total + (Number(invoice.item.price) * invoice.quantity);
                }, 0);
            },

            subtotal: function() {
                return this.total - this.discount;
            },

            remaining: function() {
                return this.amount_received - this.subtotal;
            }
        },
        methods:{
            getAvailableQty()
            {
                if(this.company > 0 && this.size > 0)
                {
                    axios.get('get/tire_stock/' + this.company + '/' + this.size)
                    .then(response => { this.tire = response.data })
                }
            },
            addTireInvoice(){
                if (this.invoices.filter(e => e.id === this.tire.id && e.type==='tire').length > 0) 
                {
                    var objIndex = this.invoices.findIndex((obj => obj.id == this.tire.id && obj.type==='tire'));
                    this.invoices[objIndex].quantity = this.tire_quantity;

                    this.$notify({
                      group: 'notification',
                      type: 'success',
                      title: "Well done",
                      text: "Updated successfully."
                    });
                }
                else
                {
                    if(this.tire_quantity <= this.tire.quantity)
                    {
                        this.invoices.push({item: this.tire, id: this.tire.id, quantity: this.tire_quantity, type:'tire'});

                        this.$notify({
                          group: 'notification',
                          type: 'success',
                          title: "Well done",
                          text: "Added successfully."
                        });
                    }
                    else
                    {
                        this.$notify({
                          group: 'notification',
                          type: 'error',
                          title: "Error",
                          text: "Out of stock."
                        });
                        return false;
                    }
                }
            },
            addServiceInvoice(){
                if (this.invoices.filter(e => e.id === this.service.id && e.type==='service').length > 0) 
                {
                    var objIndex = this.invoices.findIndex((obj => obj.id == this.tire.id && obj.type==='service'));
                    this.invoices[objIndex].quantity = this.tire_quantity;

                    this.$notify({
                      group: 'notification',
                      type: 'success',
                      title: "Well done",
                      text: "Updated successfully."
                    });
                }
                else
                {
                    this.invoices.push({item: this.service, id: this.service.id, quantity: this.service_quantity, type:'service'});

                    this.$notify({
                      group: 'notification',
                      type: 'success',
                      title: "Well done",
                      text: "Added successfully."
                    });
                }
            },
            delInvoice(id, type){
                var objIndex = this.invoices.findIndex((obj => obj.id == id && obj.type===type));
                if(objIndex > -1)
                {
                    this.invoices.splice(objIndex, 1);

                    this.$notify({
                      group: 'notification',
                      type: 'success',
                      title: "Well done",
                      text: "Deleted successfully."
                    });
                }
            },
            CheckoutInvoice(){
                if(this.invoices.length > 0 && this.amount_received >= this.subtotal)
                {
                    axios.post("/invoice",{
                        invoices: this.invoices,
                        discount: this.discount,
                        amount_received: this.amount_received,
                        total_bill: this.total,

                    })
                    .then(response => {
                        console.log("success");
                        console.log(response);

                        this.success = true;
                        this.error=false;
                        this.errors=[];

                        this.$router.push({name: 'invoice_preview', params:{invoice: response.data.id}});
                    })
                    .catch(error => {
                        this.error = true;
                        this.errors = error.response.data.errors;
                        
                        console.log("error");
                        console.log(this.error);    
                    });
                }
            },
            clearModel(){
                this.success=false;
                this.error = false;
                this.errors=[];
            }
        }
    }
</script>
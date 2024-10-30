<script type="text/javascript">
    var base_url = "<?php echo base_url() ?>";
</script>
<script type="text/javascript">
    
    const app = Vue.createApp({
        data()
        {
            return {
               
                TotalCashToBePaid: '',
                TotalCashReceived: '',
                TotalCashChanged: '0.00',
                dataTable: null,
                errors: {},
                error_transaction:[],
                loadRemainingBalanceArray:[],
                memberID: null,
                memberFullname: null,
                totalAmount: 0,
                totalDiscount: 0,
                showerrorcashierpayment:"",

               
                selectedPaymentType: '' // stores selected payment type
            }
        },
        methods:{
           
            
            loadRemainingBalance(memberID) {
                $("#loading_div").show();
                    //$("button.show-button").attr("disabled", true);
             
                let params = new URLSearchParams();
                 var address = base_url + "accounting/getassessmententries";
                params.append("memberID", memberID);
                axios.post(address, params)
                    .then(response => {
                        //console.log(response.data);
                        $("#loading_div").hide();
                       
                       
                        if (response.data.length > 0) {
                            this.loadRemainingBalanceArray = response.data;
                            this.computeTotalAmountAndDiscount(); // Calculate totalAmount and totalDiscount
                            $("#totaldiv").show();
                        }
                        
                        $('#showmemberinfo').modal('hide');
                    })
                    .catch(error => {
                        console.error('Error fetching data:', error);
                    });
            },
            updateTotal(index) {
                this.computeTotal(index);
                this.computeTotalAmountAndDiscount(); // Recalculate totals after updating Debit or Discount
            },
            computeTotal(index) {
                // Assuming Debit is the total amount
                const amount = parseFloat(this.loadRemainingBalanceArray[index].Credit) || 0;
                const discount = parseFloat(this.loadRemainingBalanceArray[index].Discount) || 0;

                // Return the computed total for the current row
                return amount - discount;
            },
            computeTotalAmountAndDiscount() {
                // Reset totalAmount and totalDiscount before recalculating
                this.totalAmount = 0;
                this.totalDiscount = 0;

                // Calculate totalAmount and totalDiscount for all rows
                this.loadRemainingBalanceArray.forEach((item, index) => {
                    this.totalAmount += parseFloat(item.Credit) || 0;
                    this.totalDiscount += parseFloat(item.Discount) || 0;
                });

                this.TotalCashToBePaid = this.totalAmount-this.totalDiscount;
            },
            
            computeTotalChange()
            {
                this.TotalCashChanged = this.TotalCashReceived - this.TotalCashToBePaid  ;
            },
            
        },
        mounted(){
            this.loadRemainingBalance("");
        }
    });


    app.mount('#app');
</script>
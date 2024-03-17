<script type="text/javascript">
    var base_url = "<?php echo base_url() ?>";
   
</script>
<script type="text/javascript">
    
    const app = Vue.createApp({
        data()
        {
            return {
                
                searchTerm: '',
                totalDebit:'0',
                totalCredit:'0',
                totalBalance:'0',
                totalActualPayment:'0',
                totalPaymentDiscount:'0',
                totalBalanceFee:'0',
                dataTable: null,
                errors: {},
                error_transaction:[],
                loadRemainingBalanceArray:[],
                memberID: null,
                memberFullname: null,
                totalAmount: 0,
                totalDiscount: 0,
                
            }
        },
        methods:{
            searchProfile:function(){
                if ($.fn.DataTable.isDataTable('#showmemberinfoDataTable')) { // Destroy existing DataTable if it exists
                    $('#showmemberinfoDataTable').DataTable().destroy();
                }

                //$("#showmemberinfoDataTable").hide();
                $("#searchusermessegediv").show();
                $("#nousermessegediv").hide();
                //$('#showmemberinfo').modal('show');

                let params = new URLSearchParams();
                var address = base_url+"cashiering/search";
                params.append("searchTerm", this.searchTerm);
                axios.post(address, params,)
                    .then(response => {


                        if (response.data && response.data.length > 0) {
                            // Initialize DataTable for the modal
                            $('#showmemberinfoDataTable').DataTable({
                                data: response.data,
                                dataType: 'json',
                                columns: [
                                    {
                                        data: null,
                                        render: function (data, type, row, meta) {
                                            if (meta) {
                                                return meta.row + 1; // Row number starts from 1
                                            } else {
                                                return ''; // or handle the case when meta is undefined
                                            }
                                        },
                                        title: '#'
                                    },
                                    { data: 'UserID', title: 'User ID' },
                                    { data: 'LastName', title: 'Last Name' },
                                    { data: 'FirstName', title: 'First Name' },
                                    { data: 'MiddleName', title: 'Middle Name' },
                                    { data: 'NameExtension', title: 'Name Extension' },
                                    {
                                      data: null,
                                      render: (data, type, row) => {
                                        
                                        return '<button class="show-button btn btn-sm btn-warning" ><i class="fa fa-check"></i></button> ';
                                      },
                                      title: 'Action'
                                    }
                                    // Add other columns as needed
                                ]
                            });
                            $("#searchusermessegediv").hide();
                            $("#nousermessegediv").hide();
                            $('#showmemberinfo').modal('show');
                        }
                        else
                        {
                            $("#searchusermessegediv").hide();
                            $("#nousermessegediv").show();
                        }
                       
                    })
                    .catch(error => {
                        console.error('Error fetching data:', error);
                        $("#searchusermessegediv").hide();
                            $("#nousermessegediv").hide();
                    });

                     

                    //$('#showmemberinfo').modal('show');
            },
            
            loadRemainingBalance(memberID) {
                $("#loading_div").show();
                    $("button.show-button").attr("disabled", true);
             
                let params = new URLSearchParams();
                var address = base_url + "accounting/getassessmententries";
                params.append("memberID", memberID);
                axios.post(address, params)
                    .then(response => {
                        //console.log(response.data);
                        $("#loading_div").hide();
                        $("button.show-button").attr("disabled", false);
                        this.memberID   = memberID ;
                        if (response.data.length > 0) {
                            console.log(response.data);
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
            
            computeTotalAmountAndDiscount() {
                // Reset totalAmount and totalDiscount before recalculating
                this.totalDebit = 0;
                this.totalCredit = 0;
                this.totalBalance = 0;

                this.totalActualPayment = 0;
                this.totalPaymentDiscount = 0;
                this.totalBalanceFee = 0;
           
                // Calculate totalAmount and totalDiscount for all rows
                this.loadRemainingBalanceArray.forEach((item, index) => {
                    this.totalCredit += parseFloat(item.Credit) || 0;
                    this.totalDebit += parseFloat(item.Debit) || 0;
                    this.totalBalance += parseFloat(item.BalanceFee) || 0;

                    this.totalActualPayment += parseFloat(item.ActualPayment) || 0;
                    this.totalPaymentDiscount += parseFloat(item.PaymentDiscount) || 0;
                     this.totalBalanceFee += parseFloat(item.BalanceFee) || 0;
                });

                
            },
            
           
           
            
        },
        mounted(){
            $('#showmemberinfoDataTable').on('click', '.show-button', (event) => {
                var table = $('#showmemberinfoDataTable').DataTable();
                var selectedRowData = table.row($(event.currentTarget).closest('tr')).data();
                this.memberID = selectedRowData.UserID;
                //this.searchTerm = selectedRowData.LastName + ', ' +selectedRowData.FirstName ;
                this.searchTerm = selectedRowData.UserID ;
                this.memberFullname = selectedRowData.LastName + ', ' +selectedRowData.FirstName ;
                this.loadRemainingBalance(this.memberID);
                $("#payNowButton").attr("disabled", false   );
            });
            
        }
    });


    app.mount('#app');
</script>
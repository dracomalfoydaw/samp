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
                
                selectedItems: [] ,// Array to keep track of selected items
                showConfirmationModal: false,


                loadListofPayment:[],
                search_value: "",
                selectedType: "CONT",
                options: [
                    { value: 'CONT', label: 'Contribution' },
                    { value: 'ATDNC', label: 'Attendance Fee' },
                    { value: 'Other', label: 'Other' }
                    ],
            }
        },
        methods:{
            updateRow(EntryID,Credit,Remarks)
            {
                $("#messagebox_table").hide();
                $("#loading_table").show();
                const address = base_url + "accounting/updateListofPayment";
                let params = new URLSearchParams();
                params.append("amount", Credit);
                params.append("EntryID", EntryID);
                params.append("Remarks", Remarks);
                params.append("memberID", this.memberID);
                axios.post(address, params)
                .then(response => {
                    $("#loading_table").hide();
                    if (response.data.message === "success") {
                     
                        //this.loadListofPayment = response.data.message_result;
                    } else {
                        $("#messagebox_table").show();
                        console.log('Error:', response.data);
                        $("#error_content").html(response.data.message_details);
                    }
                })
                .catch(error => {
                    $("#loading_table").hide();
                    $("#messagebox_table").show();
                    console.error('Error fetching data:', error);
                    $("#error_content").html('There was an error fetching data!');
                });
            },
            

            fetchData() {
                const address = base_url + "accounting/getListofPaymenttoAdd";
                let params = new URLSearchParams();
                params.append("typePayment", this.selectedType);
                params.append("searchvalue", this.search_value);
                axios.post(address, params)
                .then(response => {
                    $("#loading_addfee_div").hide();
                    if (response.data.message === "success") {
                     
                        this.loadListofPayment = response.data.message_result;
                    } else {
                        $("#loading_addfee_div").hide();
                        console.log('Error:', response.data);
                        $("#error_content").html(response.data.message_details);
                    }
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                    $("#error_content").html('There was an error fetching data!');
                });
            },

            selectItem(data,remarks)
            {
                $("#loading_addfee_div").show()
                const address = base_url + "accounting/insertnewpayment";
                let params = new URLSearchParams();
                params.append("data", data);
                params.append("typePayment", this.selectedType);
                params.append("memberID", this.memberID);
                params.append("remarks", remarks);
                axios.post(address, params)
                .then(response => {
                    $("#loading_addfee_div").hide();
                    if (response.data.message === "success") {
                        this.loadRemainingBalance(this.memberID) ;
                        $('#addrecord').modal('hide');
                    } else {
                        $("#loading_addfee_div").hide();
                       
                        $("#error_content").html(response.data.message_details);
                    }
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                    $("#error_content").html('There was an error fetching data!');
                });
            },


            search()
            {
                $("#loading_addfee_div").show()

                this.fetchData() ;
            },
            addrecord() {   
                if(this.memberID !="" && this.memberID != null)
                {
                    $("#loading_addfee_div").show();

                    this.fetchData() ;
                    $('#addrecord').modal('show');
                }           
                
            },

            confirmDelete() {
              // Open Bootstrap modal
                let count_check = 0;
                const selectedData = this.loadRemainingBalanceArray.filter((item, index) => this.selectedItems[index]);
                selectedData.forEach(item => count_check++);
                if (count_check > 0) {
                    $('#confirmationModal').modal('show');
                }
            },
            deleteTransactions() {
              // Perform deletion logic here
              const selectedData = this.loadRemainingBalanceArray.filter(
                (item, index) => this.selectedItems[index]
                );
              const selectedTransactions = selectedData.map((item) => item.EntryID);
              //console.log("Deleting transactions", selectedTransactions);
              $("#loading_div_delete").show();
              const address = base_url + "accounting/removeListofPayment";
                let params = new URLSearchParams();
                params.append("memberID", this.memberID);
                params.append("selectedTransactions", selectedTransactions);
                axios.post(address, params)
                .then(response => {
                    $("#loading_div_delete").hide();
                    if (response.data.message === "success") {
                        this.loadRemainingBalance(this.memberID);
                        $('#confirmationModal').modal('hide');
                        //this.loadListofPayment = response.data.message_result;
                    } else {
                        $("#loading_div_delete").hide();
                        console.log('Error:', response.data);
                        $("#error_content").html(response.data.message_details);
                    }
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                    $("#error_content").html('There was an error fetching data!');
                });
              
              // Close Bootstrap modal after deletion
              
          },
          selectAll(event) {
                // Update all checkboxes based on the master checkbox state
            this.selectedItems = Array(this.loadRemainingBalanceArray.length).fill(event.target.checked);
        },
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
            
        },
        watch: {
            'loadRemainingBalanceArray': {
                deep: true,
                handler(newVal, oldVal) {
                    newVal.forEach((item, index) => {
                        // Recalculate BalanceFee whenever Credit changes
                        this.$watch(() => item.Credit, () => {
                            item.BalanceFee = parseFloat(item.Credit) - (parseFloat(item.ActualPayment) + parseFloat(item.PaymentDiscount));
                             this.computeTotalAmountAndDiscount();
                        });
                    });
                }
            }
        }
    });


app.mount('#app');
</script>
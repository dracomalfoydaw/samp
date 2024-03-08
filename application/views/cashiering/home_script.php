<script type="text/javascript">
    var base_url = "<?php echo base_url() ?>";
    var setORnumber = "<?php echo $issetORnumber ?>";
    var ORnumber = "<?php echo $ORnumber ?>";
</script>
<script type="text/javascript">
    
    const app = Vue.createApp({
        data()
        {
            return {
                OrNumber: 'OR Number: '+ORnumber,
                setORnumber : setORnumber,
                isOrNumberExist: true,
                searchTermOrNumber: '',
                searchTerm: '',
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
                var address = base_url + "cashiering/loadbalance";
                params.append("memberID", memberID);
                axios.post(address, params)
                    .then(response => {
                        //console.log(response.data);
                        $("#loading_div").hide();
                        $("button.show-button").attr("disabled", false);
                        this.memberID   = memberID ;
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
            payNow()
            {
                this.TotalCashReceived = 0.00;
                this.TotalCashChanged = 0.00;
                this.showerrorcashierpayment = "";
                $("#showerrorcashierpayment").hide();
                $('#payment_modal').modal('show');
            },
            confirmpayNow()
            {
                if(this.TotalCashChanged<0)
                {
                    this.showerrorcashierpayment = "Total Cash Received must be greater than the total amount to be paid.";
                    $("#showerrorcashierpayment").show();
                }
                else
                {
                    // Create an array to store the JSON objects for each row
                    const jsonData = [];

                      // Loop through the rows and construct the JSON object for each row
                    this.loadRemainingBalanceArray.forEach((item) => {
                        const rowObject = {
                          ChartCode: item.ChartCode,
                          ChartName: item.ChartName,
                          Debit: item.Credit,
                          Discount: item.Discount,
                          
                          Remarks: item.Remarks,
                          EntryID: item.EntryID,
                        };

                        // Push the constructed JSON object to the array
                        jsonData.push(rowObject);
                    });

                      // Display the JSON data in the console (you can modify this part based on your requirements)
                    transtable = JSON.stringify(jsonData, null, 2);
                    //console.log(JSON.stringify(jsonData, null, 2));

                    let params = new URLSearchParams();
                var address = base_url + "cashiering/paymenttransaction";
                params.append("loadRemainingBalanceArray", transtable);
                params.append("TotalCashReceived", this.TotalCashReceived);
                params.append("TotalCashToBePaid", this.TotalCashToBePaid);
                params.append("TotalCashChanged", this.TotalCashChanged);
                params.append("TotalDiscount", this.totalDiscount);
                params.append("memberID", this.memberID);
                params.append("memberFullname", this.memberFullname);
                axios.post(address, params)
                    .then(response => {
                        console.log(response.data);
                    })
                    .catch(error => {
                        console.error('Error fetching data:', error);
                    });
                }
            },
            computeTotalChange()
            {
                this.TotalCashChanged = this.TotalCashReceived - this.TotalCashToBePaid  ;
            },
            cashierSetup()
            {
              $('#cashierSetup_modal').modal('show');
            },
            verifyOR()
            {
                $("#oruseddiv").hide();
                $("#ornotuseddiv").hide();
                $("#checkingornotuseddiv").show();
                let params = new URLSearchParams();
                var address = base_url + "cashiering/checkornumber";
                params.append("ornumber", this.searchTermOrNumber);
                axios.post(address, params)
                    .then(response => {
                        if(response.data.message=="exist")
                        {
                            this.isOrNumberExist = true;
                            $("#oruseddiv").show();
                            $("#ornotuseddiv").hide();
                        }
                        else if(response.data.message=="not exist")
                        {
                            this.OrNumber=this.searchTermOrNumber;

                            this.isOrNumberExist = false;
                            $("#oruseddiv").hide();
                            $("#ornotuseddiv").show();
                        }
                        else
                        {
                            this.isOrNumberExist = true;
                            $("#oruseddiv").show();
                            $("#ornotuseddiv").hide();
                        }
                        $("#checkingornotuseddiv").hide();
                    })
                    .catch(error => {
                        console.error('Error fetching data:', error);
                        $("#checkingornotuseddiv").hide();
                    });
            },
            confirmOR()
            {
               $('#cashierSetup_modal').modal('hide');
            }
        },
        mounted(){
            $('#showmemberinfoDataTable').on('click', '.show-button', (event) => {
                var table = $('#showmemberinfoDataTable').DataTable();
                var selectedRowData = table.row($(event.currentTarget).closest('tr')).data();
                this.memberID = selectedRowData.UserID;
                this.searchTerm = selectedRowData.LastName + ', ' +selectedRowData.FirstName ;
                this.memberFullname = selectedRowData.LastName + ', ' +selectedRowData.FirstName ;
                this.loadRemainingBalance(this.memberID);
                $("#payNowButton").attr("disabled", false   );
            });
            if(this.setORnumber != "set")
            {
                $('#cashierSetup_modal').modal('show');
            }
        }
    });


    app.mount('#app');
</script>
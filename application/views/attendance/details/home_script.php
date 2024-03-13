<script type="text/javascript">
    var base_url = "<?php echo base_url() ?>";
    var AttendanceEntryID = "<?php echo $AttendanceEntryID ?>";
</script>
<script type="text/javascript">
    const app = Vue.createApp({
        data()
        {
            return {
                searchTerm: '',
                dataTable: null,
                loading: true,
                errors: {},
                error_transaction:[],
                formData: {
                    Name: '',
                    Description: '',
                    Fines: '',
                    createannoucement: [],
                },
            };
        },
        methods:{
            loadDatatable:function()
            {
                if ($.fn.DataTable.isDataTable('#dataTable')) { // Destroy existing DataTable if it exists
                    $('#dataTable').DataTable().destroy();
                }

                this.dataTable = $('#dataTable').DataTable({
                    "processing": true,
                    "serverSide": true,

                    ajax: {
                        url: base_url+'attendance/search_attendies/'+AttendanceEntryID, // Replace with your server-side script
                        dataSrc: '',
                        type: "POST",
                        data: function (d) {
                            d.searchTerm = $("#search-input").val(); // Add the search term
                        }
                    },
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
                       
                        { data: 'UniqueID', title: 'UniqueID' },
                        { data: 'Fullname', title: 'Fullname' },
                         {
                            data: null,
                            render: function (data, type, row) {
                              if (row.Remarks === "1") {
                                return '<a disabled class=" btn btn-sm btn-info" title="Already Cleared"><i class="fa fa-check"></i></a>';
                              } else {
                                return '<button class="check-attendance-button btn btn-sm btn-success" data-user-id="' + row.UniqueID + '">Check Attendance Now</button>';
                              }
                            },
                            title: 'Action'
                          },
                    ]
                });

                // Watch for changes in searchTerm and update DataTable search
                this.$watch('searchTerm', (newValue) => {
                    this.dataTable.search(newValue).draw();
                });
               /* $('#search-input').on('input', () => {
                        this.dataTable.search($('#search-input').val()).draw();
                    });*/
            },

            clearAction: function (memberID) {
                $('#loading').show();
                $(".check-attendance-button").prop("disabled",true);
                const address = base_url+"attendance/check_attendance";
                let params = new URLSearchParams();
                params.append("AttendanceEntryID", AttendanceEntryID);
                params.append("memberID", memberID);
                axios.post(address, params,)
                    .then(response => {
                        $('#loading').fadeOut("slow");
                        if(response.data.message=="success")
                        {                            
                            alert('Cleared');
                            this.loadDatatable();
                        }
                        else
                        {
                            alert('Error: Status not Cleared');
                            $(".check-attendance-button").prop("disabled",false);
                        }
                    })
                    .catch(error => {
                        $('#loading').fadeOut("slow");
                         this.error_transaction.push("Something went wrong. Contact the administrator for the problem.");
                        $(".messagebox").fadeIn("slow");
                        alert("Something went wrong. Contact the administrator for the problem.");
                        $('html,body').animate({ scrollTop: 0 }, 'slow');
                        console.log(error);
                    });
            }
            

        },
        mounted(){
            const self = this; // Store the reference to the Vue instance
            this.loadDatatable();
            $('#dataTable').on('click', '.check-attendance-button', function () {
                var userId = $(this).data('user-id');
               
                self.clearAction(userId); // Use the stored reference to the Vue instance
              });
           
        }
    });

    app.mount('#app');
</script>
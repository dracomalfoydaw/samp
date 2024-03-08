<script type="text/javascript">
    var base_url = "<?php echo base_url() ?>";
</script>
<script type="text/javascript">
    const app = Vue.createApp({
        data()
        {
            return {
                searchTerm: '',
                dataTable: null,
                dataTableShowDetail: null,
                loading: true,
                errors: {},
                error_transaction:[],
            
            };
        },
        methods:{
            loadDatatable:function()
            {
                this.dataTable = $('#dataTable').DataTable({
                    "processing": true,
                    "serverSide": true,

                    ajax: {
                        url: base_url+'contribution/search/collection', // Replace with your server-side script
                        dataSrc: '',
                        type: "POST",
                        data: function (d) {
                            d.searchTerm = $("#search-input").val(); // Add the search term
                        }
                    },
                    columns: [                  
                       
                        { data: 'Name', title: 'Name' },
                        { data: 'BalanceFee', title: 'Value' },
                        { data: 'Description', title: 'Description' },
                        { data: 'TotalDebit', title: 'Total Collection' },
                        { data: 'TotalCredit', title: 'Need to be Collected' },
                        {
                          data: null,
                          render: (data, type, row) => {
                            
                            return '<button class="show-button btn btn-sm btn-warning" data-user-id="' + row.EntryID + '"><i class="fa fa-eye"></i></button> ';
                          },
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

            openUpdateModal: function (userId) {
                // Open the modal
                        $('#updateModal').modal('show');
                // Fetch data for the user with userId via AJAX
               /* $.ajax({
                    url: base_url + 'contribution/collection/profilecollectionlist',  // Adjust the URL as needed
                    type: 'POST',

                    success: function (response) {
                        // Initialize DataTable for the modal
                        $('#modalDataTable').DataTable({
                            destroy: true, // Destroy existing DataTable if it exists
                            data: response,
                            dataType: 'json',
                            columns: [
                                { data: 'Fullname', title: 'Name' },
                                { data: 'TotalDebit', title: 'Value' },
                                // Add other columns as needed
                            ]
                        });

                        
                    },
                    error: function (error) {
                        console.error('Error fetching user data:', error);
                    }
                });*/


                let params = new URLSearchParams();
                    var address = base_url+"contribution/collection/profilecollectionlist";
                    params.append("searchvalue", userId);
                    axios.post(address, params,)
                        .then(response => {
                          

                            // Initialize DataTable for the modal
                            $('#modalDataTable').DataTable({
                                destroy: true, // Destroy existing DataTable if it exists
                                data: response.data,
                                dataType: 'json',
                                columns: [
                                    { data: 'Fullname', title: 'Name' },
                                    { data: 'TotalDebit', title: 'Value' },
                                    // Add other columns as needed
                                ]
                            });
                        })
                        .catch(error => {
                            console.error('Error fetching data:', error);
                        });
            },


            updateDataInModal: function () {
                // Implement the logic to update data based on the values in the modal form
                // For example, make an AJAX call to update the user details
                // After successful update, close the modal
                $('#updateModal').modal('hide');
            },
           
            populateModalDataTable: function (data) {
                // Clear existing rows in the modal DataTable
                $('#modalDataTable tbody').empty();
            },

          

        },
        mounted(){
            this.loadDatatable();
            /*$('#dataTable').on('click', '.show-button', function () {
                var userId = $(this).data('user-id');
                
                this.openUpdateModal(userId);
            });*/
            $('#dataTable').on('click', '.show-button', (event) => {
                var userId = $(event.currentTarget).data('user-id');
                this.openUpdateModal(userId);
            });
            
        }
    });

    app.mount('#app');
</script>
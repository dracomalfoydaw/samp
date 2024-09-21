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
                            
                            return '<button class="show-button btn btn-sm btn-warning" data-user-id="' + row.EntryID + '"><i class="fa fa-eye"></i></button> &nbsp <button class="sync-button btn btn-sm btn-success" data-user-id="' + row.EntryID + '"><i class="fa fa-sync"></i></button>';
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
                        $('#updateModal').modal('show');


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
                                    { data: 'TotalDebit', title: 'Total Value Paid' },
                                    { data: 'TotalCredit', title: 'Balance' },
                                    // Add other columns as needed
                                ]
                            });
                        })
                        .catch(error => {
                            console.error('Error fetching data:', error);
                        });
            },

            syncRecord: function (userId) {
                
                this.syncformModal = new bootstrap.Modal(document.getElementById('syncformModal'), {
                    backdrop: 'static', // Prevent closing when clicking outside
                    keyboard: false, // Prevent closing with ESC key
                  });
                this.syncformModal.show();

                let params = new URLSearchParams();
                var address = base_url+"contribution/collection/synccollection";
                params.append("searchvalue", userId);
                axios.post(address, params,)
                    .then(response => {
                        this.syncformModal.hide();
                        location.reload();
                    })
                    .catch(error => {
                        this.syncformModal.hide();
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

            $('#dataTable').on('click', '.sync-button', (event) => {
                var userId = $(event.currentTarget).data('user-id');
                this.syncRecord(userId);
            });
            $('#dataTable').on('click', '.show-button', (event) => {
                var userId = $(event.currentTarget).data('user-id');
                this.openUpdateModal(userId);
            });
            
        }
    });

    app.mount('#app');
</script>
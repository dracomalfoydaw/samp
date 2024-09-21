<!-- Modal for updating data -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">View Contribution Report</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- DataTable for displaying fetched data -->
                <div class="datatable">
                <table class="table" id="modalDataTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Billing</th>
                            <th>Billing</th>
                            <!-- Add other columns as needed -->
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                 </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

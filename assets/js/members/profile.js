    const app = Vue.createApp({});




app.component('table-content', {
  template: `
    
    <div class="row ">
      <div class="col-md-5">
        <button class="tips btn btn-sm  btn-info" @click="newRecord"> <i class="fa fa-plus"></i> Add New</button>
        <button class="tips btn btn-sm  btn-danger" v-if="selectedRows.length" @click="deleteRecord"> <i class="fa fa-trash"></i> Delete</button>
      </div>
      <div class="col-md-3">  

      </div>
      <div class="col-md-4">
        <input type="text" class="form-control" v-model="searchQuery" @keyup.enter="onSearch" placeholder="Search...">
      </div>
    </div>
    <div class="datatable">
      <div class="row ">
        <div class="col-md-5">
         
        </div>
        <div class="col-md-3">            
            <div class="form-group has-feedback justify-content-center align-items-center" id="loading" style="display: none;">
                <div class="justify-content-center align-items-center">
                  <img src="./assets/imgs/loading.gif" alt="Loading" style="width:150px;height:150px;">
                </div>
            </div>
        </div>
        <div class="col-md-4">
        
        </div>
      </div>
      <table class="table table-responsive table-bordered table-hover" id="example" width="100%" cellspacing="0"></table>
      <div class="row">
        <div class="col-md-6 d-flex align-items-center">
          <div class="row-per-page">
            <select class="form-control form-control-inline" id="rowsPerPage" v-model="rowsPerPage" @change="updateRowsPerPage">
              <option v-for="option in rowOptions" :key="option.value" :value="option.value">{{ option.text }}</option>
            </select>
          </div>
          <div class="sort-options ml-2">
            <select id="sortColumn" class="form-control form-control-inline" v-model="sortColumn" @change="updateSort">
              <option v-for="option in sortOptions" :key="option.value" :value="option.value">{{ option.text }}</option>
            </select>
            <select id="sortOrder" class="form-control form-control-inline ml-2" v-model="sortOrder" @change="updateSort">
              <option value="asc">Ascending</option>
              <option value="desc">Descending</option>
            </select>
          </div>
        </div>

        <div class="col-md-6">
          <div class="pagination-controls">
            <button class="btn btn-primary" @click="prevPage" :disabled="isDisabledPrevPage || currentPage === 1">Previous</button>
            <span>Page {{ currentPage }} of many</span>
            <button class="btn btn-primary" :disabled="isDisabledNextPage" @click="nextPage">Next</button>
          </div>
        </div>
      </div>
      <!-- Delete Modal -->
      <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            
              <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" @click="closeModal" aria-label="Close" :disabled="isDeleting">X</button>
              </div>
              <div class="modal-body">
                Are you sure you want to delete this record?
                <div v-if="isDeleting">
                  <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%;"></div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" @click="closeModal" :disabled="isDeleting">Cancel</button>
                <button type="submit" class="btn btn-danger"  @click="confirmDelete"  :disabled="isDeleting">Delete</button>
              </div>
            
          </div>
        </div>
      </div>

      <!-- New Form Modal -->
      <div class="modal fade" id="newFormModal" tabindex="-1" aria-labelledby="newFormModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <form @submit.prevent="confirmSubmit">
              <div class="modal-header">
                <h5 class="modal-title" id="newFormModalLabel">New Record</h5>
                <button type="button" class="btn-close" @click="closenewFormModal" :disabled="isSubmit" aria-label="Close">X</button>
              </div>
             
              <div class="modal-body messagebox_error" style="display: none;">
                <div class="alert alert-danger "  role="alert">
                  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                  <span class="sr-only">Error:</span>
                  <a style="color:black;"id="message_error" disabled >
                    <b>You have following error(s):</b> 
                    <p>Something went wrong. Contact the administrator for the problem.</p>
                  </a>
                </div> 
              </div> 
              <div class="modal-body messagebox" style="display: none;">
                <div class="alert alert-danger "  role="alert">
                  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                  <span class="sr-only">Error:</span>
                  <a style="color:black;"id="message_error" disabled >
                    <b>You have following error(s):</b> 
                    <ul id="error_content">
                       
                    </ul>
                  </a>
                </div> 
              </div> 
              
              <div class="modal-body">
                <div v-if="isSubmit">
                  <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%;"></div>
                  </div>
                </div>
                <div v-if="isSubmit">
                </div>
               
                
                

                <div class="row">
                  <div class="col-md-6">

                  </div>
                  <div class="col-md-6">

                  </div>
                </div>

                <div class="mb-3">                    
                  <div class ="row">
                    <div class="col-md-6">
                      <label class="control-label col-md-3 bold font-xs">Generate By </label>
                      <span class="form-control">
                        <label><input :disabled="isSubmit" type="radio" name="stud-num-rad" class="stud-num-rad auto" value="auto-num" v-model="newForm.studNumRad"checked> Automatic</label> &nbsp;
                        <label><input :disabled="isSubmit" type="radio" name="stud-num-rad" class="stud-num-rad" value="pre-num" v-model="newForm.studNumRad"> Manual</label>
                        </span>
                    </div>
                    <div class="col-md-6">
                      <label for="ProfileID" class="form-label">Profile ID</label>
                      <input :disabled="isSubmit || isAutomatic" type="text" class="form-control" id="ProfileID" name="ProfileID" v-model="newForm.ProfileID" required>
                      <span v-if="errors.ProfileID" style="color: red;">{{ errors.ProfileID }}</span>
                    </div>
                  </div>
                </div>
                <h3>Personal Information</h3>
                <hr>
                <div class="mb-3">
                  <div class ="row">
                    <div class="col-md-3">                      
                      <label for="Email" class="form-label">Email Address</label>
                      <input :disabled="isSubmit" type="email" class="form-control" id="Email" name="Email" v-model="newForm.Email" required>
                      <span v-if="errors.Email" style="color: red;">{{ errors.Email }}</span>
                    </div>
                  </div>
                </div>

                <div class="mb-3">
                  <div class ="row">
                    <div class="col-md-3">
                      <label for="FirstName" class="form-label">First Name</label>
                      <input :disabled="isSubmit" type="text" class="form-control" id="FirstName" name="FirstName" v-model="newForm.FirstName" required>
                      <span v-if="errors.FirstName" style="color: red;">{{ errors.FirstName }}</span>
                    </div>
                    <div class="col-md-3">
                      <label for="MiddleName" class="form-label">Middle Name</label>
                      <input :disabled="isSubmit" type="text" class="form-control" id="MiddleName" name="MiddleName" v-model="newForm.MiddleName" >
                      <span v-if="errors.MiddleName" style="color: red;">{{ errors.MiddleName }}</span>
                    </div>
                    <div class="col-md-3">
                      <label for="LastName" class="form-label">Last Name</label>
                      <input :disabled="isSubmit" type="text" class="form-control" id="LastName" name="LastName" v-model="newForm.LastName" required>
                      <span v-if="errors.LastName" style="color: red;">{{ errors.LastName }}</span>
                    </div>
                    <div class="col-md-3">
                      <label for="NameExtension" class="form-label">Name Extension</label>
                      <input :disabled="isSubmit" type="text" class="form-control" id="NameExtension" name="NameExtension" v-model="newForm.NameExtension" >
                      <span v-if="errors.NameExtension" style="color: red;">{{ errors.NameExtension }}</span>
                    </div>
                  </div>
                </div>
                <h3>Home Address</h3>
                <hr>
                <div class="mb-3">
                  <div class ="row">
                    <div class="col-md-12">
                      <label for="homeaddress" class=" control-label text-left"> Home/Blkd</label>
                      <input :disabled="isSubmit" type="text" class="form-control" id="homeaddress" name="homeaddress" v-model="newForm.homeaddress" >
                      <span v-if="errors.homeaddress" style="color: red;">{{ errors.homeaddress }}</span>
                    </div>
                  </div>
                </div>
                <div class="mb-3">
                  <div class ="row">
                    <div class="col-md-3">
                      <label for="Province" class=" control-label text-left"> Province </label>
                      <input :disabled="isSubmit" type="text" class="form-control" id="Province" name="Province" v-model="newForm.Province" >
                      <span v-if="errors.Province" style="color: red;">{{ errors.Province }}</span>
                    </div>
                    <div class="col-md-3">
                      <label for="Municipality" class=" control-label text-left"> Municipality/City </label>
                      <input :disabled="isSubmit" type="text" class="form-control" id="Municipality" name="Province" v-model="newForm.Municipality" >                 
                      <span v-if="errors.Municipality" style="color: red;">{{ errors.Municipality }}</span>
                    </div>
                    <div class="col-md-3">
                      <label for="Barangay" class=" control-label  text-left"> Barangay </label>
                      <input :disabled="isSubmit" type="text" class="form-control" id="Barangay" name="Province" v-model="newForm.Barangay" >                    
                      <span v-if="errors.Barangay" style="color: red;">{{ errors.Barangay }}</span>
                    </div>
                    <div class="col-md-3">
                      <label for="zipcode" class="form-label">ZipCode</label>
                      <input :disabled="isSubmit" type="text" class="form-control" id="zipcode" name="zipcode" v-model="newForm.zipcode" >
                      <span v-if="errors.zipcode" style="color: red;">{{ errors.zipcode }}</span>
                    </div>
                  </div>
                </div>

                           
                <div class="mb-3">
                  <div class="custom-control custom-checkbox">
                    <input 
                      :disabled="isSubmit" 
                      class="custom-control-input" 
                      v-model="newForm.defaultuseraccount" 
                      id="defaultuseraccount" 
                      type="checkbox" 
                    />
                    <label class="custom-control-label" for="defaultuseraccount">
                      Create Default System User
                    </label>
                  </div>
                </div>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" @click="closenewFormModal" :disabled="isSubmit">Cancel</button>
                <button type="submit" class="btn btn-primary" :disabled="isSubmit">Submit</button>
              </div>
            </form>           
          </div>
        </div>
      </div>
    </div>
  `,
  data() {
    return {
      table: null,
      isDisabledNextPage: null,
      isDisabledPrevPage: null,
      currentPage: 1,
      searchQuery: '',
      rowsPerPage: 5, // Default rows per page
      sortColumn: '',
      sortOrder: 'asc', // Default sort order
      rowOptions: [
        { value: '5', text: '5' },
        { value: '10', text: '10' },
        { value: '25', text: '25' },
        { value: '50', text: '50' },
        { value: '100', text: '100' }
      ],
      sortOptions: [
        { value: '', text: 'Sort by' },
        { value: 'AccountID', text: 'Account ID' },
        { value: 'FirstName', text: 'First Name' },
        { value: 'MiddleName', text: 'Middle Name' },
        { value: 'LastName', text: 'Last Name' },
      ],      
      selectedRows: [],
      session_log: session_log,
      rowNumber: null,
      /**delete form**/  
      entryIdToDelete: null,
      isDeleting: false,
      deleteModal: null,
      /**New form**/      
      errors : {},      
      isSubmit: false,
      isAutomatic: false,
      newForm: {},
      newFormModal : null,
    };
  },
  watch: {
      'newForm.studNumRad'(newVal) {
          this.isAutomatic = newVal === 'auto-num';
      }
  },
  methods: {
    async fetchData(page, query = '', sortColumn = '', sortOrder = 'asc') {
      this.isDisabledNextPage = true;
      this.isDisabledPrevPage = true;
      this.showLoading(true);
      this.table.clear();
      this.table.draw();
      try {
        const response = await axios.get(base_url + 'members/get_data', {
          params: {
            start: (page - 1) * this.rowsPerPage,
            limit: this.rowsPerPage,
            search: query,
            sortColumn: sortColumn,
            sortOrder: sortOrder,
            session_log: this.session_log,
          }
        });
        if(response.data.session_log && response.data.success) {
          this.isDisabledNextPage  = false;
          this.isDisabledPrevPage  = false;
          table_data =  response.data.data; 
          if(response.data.data.length <=0)
          {
            this.isDisabledNextPage = true;
          } 
        }
        else
        {
          alert('Session TimeOut. Reloading the Page');
          location.reload(true);
        }
        this.table.clear();
        this.table.rows.add(table_data);
        this.table.draw();
        this.$nextTick(() => {
          this.addEventListeners();
        });
      } catch (error) {
        console.error('Error fetching data:', error);
      } finally {
        this.showLoading(false);
      }
    },
    nextPage() {
      this.currentPage++;
      this.fetchData(this.currentPage, this.searchQuery, this.sortColumn, this.sortOrder);
    },
    prevPage() {
      if (this.currentPage > 1) {
        this.currentPage--;
        this.fetchData(this.currentPage, this.searchQuery, this.sortColumn, this.sortOrder);
      }
    },
    onSearch() {
      this.currentPage = 1;
      this.fetchData(this.currentPage, this.searchQuery, this.sortColumn, this.sortOrder);
    },
    updateRowsPerPage() {
      this.currentPage = 1;
      this.fetchData(this.currentPage, this.searchQuery, this.sortColumn, this.sortOrder);
    },
    updateSort() {
      this.currentPage = 1;
      this.fetchData(this.currentPage, this.searchQuery, this.sortColumn, this.sortOrder);
    },
    showLoading(show) {
      const loadingElement = document.getElementById('loading');
      if (loadingElement) {
        loadingElement.style.display = show ? 'block' : 'none';
      }
    },
    

    /**New form**/    
    newRecord() {
      this.newFormModal = new bootstrap.Modal(document.getElementById('newFormModal'), {
        backdrop: 'static', // Prevent closing when clicking outside
        keyboard: false, // Prevent closing with ESC key
      });
      this.newFormModal.show();
    },

    confirmSubmit() {
      try {   
          $(".messagebox").fadeOut("slow");
          $(".messagebox_error").fadeOut("slow");
          const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
          this.errors = {};
          if (!this.newForm.Email) {
            this.errors.Email = 'Email is required.';
          }
          else if (!emailPattern.test(this.newForm.Email)) {
            this.errors.Email = 'Invalid email address.';
          }
          if (!this.newForm.FirstName) {
            this.errors.FirstName = 'First Name is required.';
          }
          if (!this.newForm.LastName) {
            this.errors.LastName = 'Last Name is required.';
          }

          if (!this.newForm.LastName) {
            this.errors.LastName = 'Last Name is required.';
          }
          if (!this.newForm.LastName) {
            this.errors.LastName = 'Last Name is required.';
          }
          if (!this.newForm.LastName) {
            this.errors.LastName = 'Last Name is required.';
          }
          if (!this.newForm.LastName) {
            this.errors.LastName = 'Last Name is required.';
          }

          if (!this.newForm.homeaddress) {
            this.errors.homeaddress = 'Home Address is required.';
          }
          if (!this.newForm.Province) {
            this.errors.Province = 'Province Name is required.';
          }
          if (!this.newForm.Municipality) {
            this.errors.Municipality = 'Municipality Name is required.';
          }
          if (!this.newForm.Barangay) {
            this.errors.Barangay = 'Barangay Name is required.';
          }
          if (!this.newForm.zipcode) {
            this.errors.zipcode = 'ZipCode is required.';
          }

          if(!this.isAutomatic)
          {
            if (!this.newForm.ProfileID) {
              this.errors.ProfileID = 'Profile ID is required.';
            }
          }
          
          if (Object.keys(this.errors).length === 0) {
            this.isSubmit = true;
            var formdata = new FormData();
            formdata.append('isAutomaticProfileID', this.isAutomatic );
            formdata.append('session_log', this.session_log);
            formdata.append('FirstName', this.newForm.FirstName);
            formdata.append('LastName', this.newForm.LastName);
            formdata.append('MiddleName', this.newForm.MiddleName || '');
            formdata.append('NameExtension', this.newForm.NameExtension || '');
            formdata.append('ProfileID', this.newForm.ProfileID);
            formdata.append('email', this.newForm.Email);

            formdata.append('homeaddress', this.newForm.homeaddress);
            formdata.append('Province', this.newForm.Province);
            formdata.append('Municipality', this.newForm.Municipality);
            formdata.append('Barangay', this.newForm.Barangay);
            formdata.append('ZipCode', this.newForm.zipcode);

            formdata.append("defaultuseraccount", this.newForm.defaultuseraccount); 
            var address = base_url + 'members/add';
            axios.post(address, formdata,)
            .then(response_server => {
              const response = response_server.data;
              console.log(response);
              if (response.session_log && response.success) {
                this.newForm= {};
                this.newForm.ProfileID = '';
                this.newForm.studNumRad = 'auto-num';
                this.newForm.defaultuseraccount = false;
                this.isAutomatic = true,
                this.currentPage = 1;
                this.selectedRows = [];
                this.fetchData(this.currentPage, this.searchQuery, this.sortColumn, this.sortOrder);
                this.newFormModal.hide();
                $(".messagebox").fadeOut("slow");
              }
              else if(response.session_log && response.success == false)
              {
                $("#error_content").html(response.message_details);
                $(".messagebox").fadeIn("slow");
              }
              else
              {
                alert('Session TimeOut. Reloading the Page');
                location.reload(true);
              }
              this.isSubmit = false;
            })
            .catch(error => {
              $(".messagebox_error").fadeIn("slow");
              this.isSubmit = false;
            });
          }
      } catch (error) {
        this.newFormModal.hide();
        console.error('Error of fetching data:', error);
        alert('An error occurred while fetching the record.');
      }
    },
    closenewFormModal() {
      this.newFormModal.hide();
    },
    
    /**delete row**/
    deleteRow(entryId,rowNumber) {
      this.entryIdToDelete = entryId;
      this.rowNumber = rowNumber;
      this.deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'), {
        backdrop: 'static', // Prevent closing when clicking outside
        //keyboard: false // Prevent closing with ESC key
      });
      this.deleteModal.show();
    },

    async confirmDelete() {
      this.isDeleting = true;
      try {     
          var formdata = new FormData();
          var selectedRowsJSON = JSON.stringify(this.selectedRows);
          formdata.append('session_log', this.session_log);
          formdata.append('data', selectedRowsJSON);
          const response = await axios.post(base_url + 'members/delete', formdata);
          if (response.data.session_log && response.data.success) {
            //this.currentPage = 1;
            this.selectedRows = [];
            this.fetchData(this.currentPage, this.searchQuery, this.sortColumn, this.sortOrder);
            this.closeModal();           
          }
          else
          {
            alert('Session TimeOut. Reloading the Page');
            location.reload(true);
          }
      } catch (error) {
        console.error('Error deleting data:', error);
        alert('An error occurred while deleting the record.');
        this.isDeleting = false;
      }
    },
    closeModal() {
      this.isDeleting = false;
      if (this.deleteModal) {
        this.deleteModal.hide();
      }
    },
    deleteRecord() {
      //alert('Selected IDs: ' + this.selectedRows.join(', '));

      this.deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'), {
        backdrop: 'static', // Prevent closing when clicking outside
        keyboard: false // Prevent closing with ESC key
      });
      this.deleteModal.show();
    },

 

            
    
    addEventListeners() {
      const self = this;
      $('#example').off('click', '.update-button').on('click', '.update-button', function() {
        const entryId = $(this).data('entry-id');
        const rowNumber = $(this).data('row-number');
        self.updateRow(entryId,rowNumber);
      });

      $('#example').on('click', '.avatar-img', function() {
        const imgSrc = $(this).data('img');
        alert('You clicked on the image: ' + imgSrc);
      });
      
    },
    
    handleCheckboxClick(event, row) {
      if (event.target.checked) {
        if (!this.selectedRows.includes(row.TransID)) {
          this.selectedRows.push(row.TransID);
        }
      } else {
        const index = this.selectedRows.indexOf(row.TransID);
        if (index > -1) {
          this.selectedRows.splice(index, 1);
        }
      }
    },
    
    handleSelectAll(event) {
      const isChecked = event.target.checked;
      this.selectedRows = [];
      $('input.row-checkbox').prop('checked', isChecked);
      if (isChecked) {
        this.table.rows().every((index) => {
          const row = this.table.row(index).data();
          this.selectedRows.push(row.TransID);
        });
      }
    }
    
  },
  mounted() {
    const default_avatar = `${base_url}assets/assets/img/logo.png`; // Path to default image
    this.newForm.ProfileID = '';
    this.newForm.studNumRad = 'auto-num';
    this.newForm.defaultuseraccount = false;
    this.isAutomatic = true,
    this.table = $('#example').DataTable({
      columns: [
        {
          data: null,
          render: function (data, type, row, meta) {
            if (row.RecordStatus === 'Record Deleted') {
              return "";
            } else {              
              return `<input type="checkbox" class="row-checkbox" data-entry-id="${row.TransID}" >`;
            }
          },
          width:'5%',
          title: '<input type="checkbox" id="select-all" >',
          orderable: false
        },
        {
          data: 'Avatar',
          title: 'Avatar',
          orderable: false ,// Disable default sorting,
          render: function(data, type, row) {
            if (data === '' || data === null) {
              avatar_url = default_avatar;
            }
            else
            {
              avatar_url = `${base_url}/uploads/users/${data}`;
            }
            return `<img src="${avatar_url}" alt="Avatar" class="avatar-img img-fluid" style="cursor:pointer;" data-img="${avatar_url}" onerror="this.onerror=null;this.src='${default_avatar}';">`;
          }
        },
        {
          data: 'AccountID',
          title: 'Account ID',
          orderable: false ,// Disable default sorting,
          render: function(data, type, row) {
            if (row.RecordStatus === 'Record Deleted') {
              return '<span><del>' + data + '</del></span>';
            } else {
              return `<a target="_blank" href="${base_url}members/show/${row.AccountID}">${row.AccountID}</a>`;
            }
          }
        },
        {
          data: 'EmailAddress',
          title: 'Email Address',
          orderable: false ,// Disable default sorting,
          render: function(data, type, row) {
            if (row.RecordStatus === 'Record Deleted') {
              return '<span><del>' + data + '</del></span>';
            } else {
              return data;
            }
          }
        },
        {
          data: 'FirstName',
          title: 'First Name',
          orderable: false ,// Disable default sorting,
          render: function(data, type, row) {
            if (row.RecordStatus === 'Record Deleted') {
              return '<span><del>' + data + '</del></span>';
            } else {
              return data;
            }
          }
        },
        {
          data: 'MiddleName',
          title: 'Middle Name',
          orderable: false ,// Disable default sorting,
          render: function(data, type, row) {
            if (row.RecordStatus === 'Record Deleted') {
              return '<span><del>' + data + '</del></span>';
            } else {
              return data;
            }
          }
        },
        {
          data: 'LastName',
          title: 'Last Name',
          orderable: false ,// Disable default sorting,
          render: function(data, type, row) {
            if (row.RecordStatus === 'Record Deleted') {
              return '<span><del>' + data + '</del></span>';
            } else {
              return data;
            }
          }
        },
        {
          data: 'NameExtension',
          title: 'Name Extension',
          orderable: false ,// Disable default sorting,
          render: function(data, type, row) {
            if (row.RecordStatus === 'Record Deleted') {
              return '<span><del>' + data + '</del></span>';
            } else {
              return data;
            }
          }
        },
        
        {
          data: null,
          render: (data, type, row, meta) => {
            if (row.RecordStatus === 'Record Deleted') {
              return `<button class="btn btn-sm btn-danger" disabled><i class="fa fa-trash"></i> Record deleted</button>`;
            } else {
              if (row.RecordActive === 'Active') {
                return `<button class="btn btn-sm btn-success" disabled> Active</button>`;
              }
              else
              {
                return `<button class="btn btn-sm btn-danger" disabled>Inactive</button>`;
              }
            }
          },
          title: 'Status',
          width:'5%',
          orderable: false // Disable default sorting
        },

        {
          data: null,
          render: (data, type, row, meta) => {
            if (row.RecordStatus === 'Record Deleted') {
              return `<button class="btn btn-sm btn-danger" disabled><i class="fa fa-trash"></i> Record deleted</button>`;
            } else {
              if (row.RecordStatus === 'Record Deleted') {
                return '<span><del>' + data + '</del></span>';
              } else {
                return `<a target="_blank" class="btn btn-sm btn-danger"  href="${base_url}members/print/${row.AccountID}"> <i class="fa fa-print"></i> </a>`;
              }
            }
          },
          title: 'Print',
          width:'5%',
          orderable: false // Disable default sorting
        }
        
      ],
      paging: false,
      searching: false,
      info: false
    });
    this.fetchData(this.currentPage);

    $('#example tbody').on('click', 'input.row-checkbox', (event) => {
      const row = this.table.row($(event.target).closest('tr')).data();
      this.handleCheckboxClick(event, row);
    });

    $('#select-all').on('click', (event) => {
      this.handleSelectAll(event);
    });


    
  }
});

   


    

    app.mount('#app');
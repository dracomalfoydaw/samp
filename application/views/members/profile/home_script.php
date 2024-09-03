<script type="text/javascript">
    var base_url = "<?php echo base_url() ?>";
    var session_log="<?php echo $this->encryption->encrypt(CNF_SESSION_LOG); ?>";
</script>
<script type="text/javascript">
  const app = Vue.createApp({});
app.component('table-content', {
  template: `
    <div class="card-body">
        <button class="btn btn-primary mb-3">Register</button>
    </div>
    <div class="card-body">

        <div class="datatable">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
               <thead>
                   
                </thead>

                <tbody>


                </tbody>
            </table>
        </div>
    </div>
  `,
});

  app.mount('#app');
</script>

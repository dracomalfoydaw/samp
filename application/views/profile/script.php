<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
<script>
    var image_var = '<?php echo SiteHelpers::avatar_class("img-account-profile rounded-circle mb-2");?>';
    var ini_username = "<?php echo $this->session->userdata('username') ?>";
    var ini_emailaddress = "<?php echo $this->session->userdata('eid') ?>";
    var ini_firstname = "<?php echo $this->session->userdata('fname') ?>";
    var ini_lastname = "<?php echo $this->session->userdata('lname') ?>";
    var ini_middlename = "<?php echo $this->session->userdata('mname') ?>";
    var ini_nameextension = "<?php echo $this->session->userdata('nameext') ?>";
    var email_status = "<?php if($this->session->userdata('ChangeEmailStatus')==1) {echo 'reconfirm';} ?>";
    var authenticationStatus = <?php echo ($this->session->userdata('2wayAuthOption') == md5(sha1(sha1(md5(sha1("activated")))))) ? 'true' : 'false'; ?>;
</script>

<script src="<?php echo base_url() ?>assets/js/profile.js?t=<?php  echo  date('Ydhis')?>"></script>





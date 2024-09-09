<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
<script>
    var image_var = '<?php echo SiteHelpers::avatar_class_members("img-account-profile rounded-circle mb-2", $data['Avatar']);?>';
    var ini_username = "<?php echo $data['AccountID']; ?>";
    var ini_emailaddress = "<?php echo $data['EmailAddress']; ?>";
    var ini_firstname = "<?php echo $data['FirstName']; ?>";
    var ini_lastname = "<?php echo $data['LastName']; ?>";
    var ini_middlename = "<?php echo $data['MiddleName']; ?>";
    var ini_nameextension = "<?php echo $data['NameExtension']; ?>";
    var ini_ProfileStatus = "<?php echo $data['RecordActive']; ?>";

    var ini_HomePurok = "<?php echo $data['HomePurok']; ?>";
    var ini_HomeBaranggay = "<?php echo $data['HomeBaranggay']; ?>";
    var ini_HomeMuncity = "<?php echo $data['HomeMuncity']; ?>";
    var ini_HomeProvince = "<?php echo $data['HomeProvince']; ?>";
    var ini_zipcode = "<?php echo $data['zipcode']; ?>";
</script>

<script src="<?php echo base_url() ?>assets/js/members/details.js?t=<?php  echo  date('Ydhis')?>"></script>





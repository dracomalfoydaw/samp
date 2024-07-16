        <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="<?php echo base_url() ?>assets/js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" crossorigin="anonymous"></script>
      
        <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
       
        <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js" crossorigin="anonymous"></script>
        
        <script src="https://unpkg.com/vue@3.4.15/dist/vue.global.prod.js"></script>
        <script src="https://unpkg.com/axios@1.6.5/dist/axios.min.js"></script>
        <script src="https://unpkg.com/lodash@4.17.21/lodash.min.js"></script>


        <script>
        var base_url = "<?php echo base_url() ?>";
        $(document).ready(function(){
            // Set the time limit (in milliseconds) for inactivity
            var inactivityTimeLimit = 10 * 60 * 2000; // 10 minutes

            var logoutTimer;

            // Function to show the logout message as an alert and redirect
            function showLogoutAlert() {
                alert("You have been logged out due to inactivity.");
                 $('select, input[type="radio"], a, button').prop('disabled', true); //disabled 
                // Redirect to the logout page
                window.location.href = base_url+'profile/logout'; // Replace 'logout.html' with your desired logout URL
            }

            // Function to reset the timer
            function resetLogoutTimer() {
                clearTimeout(logoutTimer);
                logoutTimer = setTimeout(showLogoutAlert, inactivityTimeLimit);
            }

            // Event listeners to reset the timer on user activity
            $(document).mousemove(resetLogoutTimer);
            $(document).keypress(resetLogoutTimer);

            // Initialize the timer
            resetLogoutTimer();
        });
        </script>
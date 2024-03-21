<script>
    document.addEventListener("DOMContentLoaded", function() {
        const announcementTitles = document.querySelectorAll('.announcement-title');

        announcementTitles.forEach(title => {
            title.addEventListener('click', function() {
                const details = this.parentElement.parentElement.nextElementSibling.querySelector('.announcement-details');
                if (details.style.display === 'none') {
                    details.style.display = 'block';
                } else {
                    details.style.display = 'none';
                }
            });
        });
    });
</script>
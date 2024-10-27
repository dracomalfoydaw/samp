<script type="text/javascript">
    var base_url = "<?php echo base_url() ?>";
   
</script>
<script type="text/javascript">

    const app = Vue.createApp({
    data() {
        return {
            records: [],         // Array to store records
            limit: 10,           // Number of records to fetch per request (keep this constant)
            offset: 0,           // Starting offset, will increment by 10 each time
            isFetching: false,   // Loading state
            hasMoreData: true ,   // Flag to stop fetches when no more data
             increment: 10, 
        };
    },
    methods: {
        async fetchData() {
            if (this.isFetching || !this.hasMoreData) return; // Avoid further calls if no more data
            this.isFetching = true;
            var address = base_url + "accounting/getledgerentries";
            
            try {
                var formdata = new FormData();
                formdata.append('limit', this.limit);
                formdata.append('offset', this.offset);

                const response = await axios.post(address, formdata);
                const data = response.data;
                if (data.length > 0) {
                    this.records.push(...data);  // Append new records
                    this.offset += this.increment;   // Increase offset by limit for the next batch
                    this.limit += this.increment;   // Increase offset by limit for the next batch
                } else {
                    this.hasMoreData = false;    // Disable further fetches if no data
                }
                
            } catch (error) {
                console.error(error);
            } finally {
                this.isFetching = false;
            }
        },


        handleScroll() {
            const bottomReached = window.innerHeight + window.scrollY >= document.body.offsetHeight - 100;
            if (bottomReached) {
                this.fetchData(); // Load more data when near the bottom
            }
        }
    },
    mounted() {
        this.fetchData(); // Initial data fetch
        window.addEventListener('scroll', this.handleScroll); // Listen to scroll event
    },
    beforeUnmount() {
        window.removeEventListener('scroll', this.handleScroll); // Clean up on unmount
    }
});

    app.mount('#app');
</script>
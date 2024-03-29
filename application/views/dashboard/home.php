  






<div class="card mb-4" style="background-image: linear-gradient(24deg, #0000ff70 0%, rgb(55 231 102) 100%);">
    <div class="card-header">Announcement</div>
    <div class="card-body">
      
    
        <?php foreach ($announcementlist as $key ): ?>
        <!-- Example DataTable for Dashboard Demo-->
        <div class="card mb-4">
            <div class="card-header"><?php echo $key->AnnouncementTitle?></div>
            <div class="card-body">
              
            
                <p><?php echo $key->Description?></p>
            </div>
        </div>


        <?php endforeach; ?>
    </div>
</div>

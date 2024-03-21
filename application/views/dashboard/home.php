                    

<!-- Example DataTable for Dashboard Demo-->
<div class="card mb-4">
    <div class="card-header">Announcement</div>
    <div class="card-body">
      
    </div>
    <div class="card-body" id="app">
        <?php foreach ($announcementlist as $key ): ?>
    <div class="card card-icon lift lift-sm mb-4">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between">
                <div class="h5 card-title mb-0 announcement-title"><?php echo $key->AnnouncementTitle?></div>
                <i class="flex-shrink-0 ml-4" data-feather="chevron-right"></i>
            </div>
        </div>
        <div class="announcement-details" style="display: none;">
            <p><?php echo $key->Description?></p>
        </div>
    </div>
    <?php endforeach; ?>
    </div>
</div>




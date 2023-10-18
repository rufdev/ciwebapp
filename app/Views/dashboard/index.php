<?= $this->extend('template/admin_template'); ?>

<?= $this->section('content'); ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard</h1>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
    <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?= $totalauthors ?></h3>

                <p>Total Authors</p>
              </div>
              <div class="icon">
                <i class="ion ion-person"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?= $totalposts ?></h3>

                <p>Total Posts</p>
              </div>
              <div class="icon">
                <i class="ion ion-ios-list"></i>
              </div>
            </div>
          </div>
        </div>  
        
    </div>
</section>
<?= $this->endSection(); ?>


<?= $this->section('pagescripts'); ?>
<script>
    $(function() {
       
    });
</script>
<?= $this->endSection(); ?>
<section class="content-header">
    <h1>
        Program
        Studi
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i></a></li>
        <li class="active">Program Studi</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title"><?= ucfirst($page) ?> Program Studi</h3>
            <div class="pull-right">
                <a href="<?= site_url('programstudi') ?>" class="btn btn-warning btn-flat">
                    <i class="fa fa-undo"> Back</i>
                </a>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <?php // echo validation_errors(); 
                    ?>
                    <form action="<?= site_url('programstudi/process') ?>" method="post">
                        <div class="form-group">
                            <label>Kode *</label>
                            <!-- untuk yang input type hidden name id ini digunakan untuk input bagian id -->
                            <input type="hidden" name="id" value="<?= $row->programstudi_id ?>">
                            <input type="text" name="programstudi_kode" value="<?= $row->kode ?>" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Program *</label>
                            <input type="text" name="program" value="<?= $row->program ?>" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" name="<?= $page ?>" class="btn btn-success btn-flat"><i class="fa fa-paper-plane"> Save</i></button>
                            <button type="reset" class="btn btn-flat">Reset</button>
                        </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>

</section>
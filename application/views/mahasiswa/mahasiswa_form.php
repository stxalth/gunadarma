<section class="content-header">
    <h1>
        Data Mahasiswa

    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i></a></li>
        <li class="active">Mahasiswa</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title"><?= ucfirst($page) ?> Mahasiswa</h3>
            <div class="pull-right">
                <a href="<?= site_url('mahasiswa') ?>" class="btn btn-warning btn-flat">
                    <i class="fa fa-undo"> Back</i>
                </a>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <form action="<?= site_url('mahasiswa/process') ?>" method="post">
                        <div class="form-group">
                            <label>NPM *</label>
                            <input type="hidden" name="id" value="<?= $row->mahasiswa_id ?>">
                            <input type="text" name="npm" value="<?= $row->npm ?>" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="product_name">Nama *</label>
                            <input type="text" name="nama" id="nama" value="<?= $row->nama ?>" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Program Studi *</label>
                            <?php echo form_dropdown(
                                'programstudi',
                                $programstudi,
                                $selectedprogram,
                                [
                                    'class' => 'form-control',
                                    'required' => 'required'
                                ],

                            ) ?>
                        </div>

                        <div class="form-group">
                            <label>Angkatan *</label>
                            <input type="number" name="angkatan" value="<?= $row->angkatan ?>" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <button type="submit" name="<?= $page ?>" class="btn btn-success btn-flat"><i class="fa fa-paper-plane"> Save</i></button>
                            <button type="reset" class="btn btn-flat">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</section>
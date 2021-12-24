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
            <h3 class="box-title">Data Program Studi</h3>
            <div class="pull-right">
                <a href="<?= site_url('programstudi/add') ?>" class="btn btn-primary">
                    <i class="fa fa-plus"> Buat</i>
                </a>
            </div>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode</th>
                        <th>Program</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($row->result() as $key => $data) { ?>
                        <tr>
                            <td><?= $no++ ?>.</td>
                            <td><?= $data->kode ?></td>
                            <td><?= $data->program ?></td>
                            <td class="text-center" width="160px">
                                <a href="<?= site_url('programstudi/edit/' . $data->programstudi_id) ?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil">Update</i></a>
                                <a href="<?= site_url('programstudi/del/' . $data->programstudi_id) ?>" onclick="return confirm('Yakin ingin menghapus?')" class="btn btn-danger btn-xs">
                                    <i class="fa fa-trash"> Hapus</i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

</section>
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
    <?php $this->view('message') ?>
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Data Program Studi</h3>
            <div class="pull-right">
                <a href="<?= site_url('programstudi/add') ?>" class="btn btn-primary">
                    <i class="fa fa-plus"> Buat</i>
                </a>
            </div>
            <br></br>
            <form method="post" action="<?= site_url('programstudi/spreadsheet_import') ?>" enctype="multipart/form-data" class="form-inline">
                <div class="form-group" style="width: 100%">
                    <p>Import Data CSV/Excel</p>
                    <input type="file" name="upload_file" class="form-control" id="upload_file" placeholder="Import CSV/Excel">
                    <input type="submit" name="submit" class="btn btn-primary">
                </div>
            </form>
            <br>
            <div class="pull-left">
                <a href="<?= site_url('programstudi/spreadsheet') ?>" class="btn btn-success">
                    <i>Export Excel</i>
                </a>
            </div>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped" id="table1">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode</th>
                        <th>Program</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- <?php $no = 1;
                            foreach ($row->result() as $key => $data) { ?>
                        <tr>
                            <td style="width:5%;"><?= $no++ ?>.</td>
                            <td><?= $data->kode ?></td>
                            <td><?= $data->program ?></td>
                            <td class="text-center" width="160px">
                                <a href="<?= site_url('programstudi/edit/' . $data->programstudi_id) ?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil">Update</i></a>
                                <a href="<?= site_url('programstudi/del/' . $data->programstudi_id) ?>" onclick="return confirm('Yakin ingin menghapus?')" class="btn btn-danger btn-xs">
                                    <i class="fa fa-trash"> Hapus</i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?> -->
                </tbody>
            </table>
        </div>
    </div>

</section>

<script>
    $(document).ready(function() {
        $('#table1').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?= site_url('programstudi/get_ajax') ?>",
                "type": "POST"
            },
            // "columnDefs": [{
            //     "targets": [6],
            //     "className": "text-right"
            // }]
        })
    })
</script>
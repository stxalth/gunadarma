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
    <?php $this->view('message') ?>
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Data Mahasiswa</h3>
            <div class="pull-right">
                <a href="<?= site_url('mahasiswa/add') ?>" class="btn btn-primary">
                    <i class="fa fa-plus"> Buat</i>
                </a>
            </div>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped" id="table1">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>NPM</th>
                        <th>Nama</th>
                        <th>Program Studi</th>
                        <th>Angkatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- <?php $no = 1;
                            foreach ($row->result() as $key => $data) { ?>
                        <tr>
                            <td><?= $no++ ?>.</td>
                            <td><?= $data->npm ?></td>
                            <td><?= $data->nama ?></td>
                            <td><?= $data->program_studi ?></td>
                            <td><?= $data->angkatan ?></td>
                            <td class="text-center" width="160px">
                                <a href="<?= site_url('mahasiswa/edit/' . $data->mahasiswa_id) ?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil">Update</i></a>
                                <a href="<?= site_url('mahasiswa/del/' . $data->mahasiswa_id) ?>" onclick="return confirm('Yakin ingin menghapus?')" class="btn btn-danger btn-xs">
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
                "url": "<?= site_url('mahasiswa/get_ajax') ?>",
                "type": "POST"
            }
            // "columnDefs": [{
            //     "targets": [6],
            //     "className": "text-right"
            // }]
        })
    })
</script>
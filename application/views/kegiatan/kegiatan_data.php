<section class="content-header">
    <h1>
        Data kegiatan

    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i></a></li>
        <li class="active">kegiatan</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <?php $this->view('message') ?>
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Data kegiatan</h3>
            <div class="pull-right">
                <a href="<?= site_url('kegiatan/add') ?>" class="btn btn-primary">
                    <i class="fa fa-plus"> Buat</i>
                </a>
            </div>
            <br></br>
            <div class="pull-left">
                <a href="<?= site_url('kegiatan/spreadsheet') ?>" class="btn btn-success">
                    <i>Export Excel</i>
                </a>
            </div>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped" id="table1">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tahun</th>
                        <th>Kategori</th>
                        <th>Kepesertaan</th>
                        <th>Nama Kegiatan</th>
                        <th>Jumlah PT</th>
                        <th>Jumlah Peserta</th>
                        <th>Capaian</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Akhir</th>
                        <th>Sertifikat/Piala</th>
                        <th>URL</th>
                        <th>Foto</th>
                        <th>Surat Tugas</th>
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
                            <td><?= $data->tahun ?></td>
                            <td><?= $data->kategori ?></td>
                            <td><?= $data->kepesertaan ?></td>
                            <td><?= $data->namakegiatan ?></td>
                            <td><?= $data->jmlpt ?></td>
                            <td><?= $data->jmlpeserta ?></td>
                            <td><?= $data->capaian ?></td>
                            <td><?= $data->tglmulai ?></td>
                            <td><?= $data->tglakhir ?></td>
                            <td>
                                <?php if ($data->sertifpiala != null) { ?>
                                    <a href="<?= base_url('uploads/kegiatan/') . $data->sertifpiala ?>" class="btn btn-default btn-xs" style="width: 70px"><i class="fa fa-eye"> lihat</i></a>
                                <?php } ?>
                            </td>
                            <td><?= $data->url ?></td>
                            <td>
                                <?php if ($data->foto != null) { ?>
                                    <img src="<?= base_url('uploads/kegiatan/') . $data->foto ?>" style="width: 80px">
                                <?php } ?>
                            </td>
                            <td>
                                <?php if ($data->surattugas != null) { ?>
                                    <a href="<?= base_url('uploads/kegiatan/') . $data->surattugas ?>" class="btn btn-default btn-xs" style="width: 70px"><i class="fa fa-eye"> lihat</i></a>
                                <?php } ?>
                            </td>
                            <td><?= $data->mhs_npm ?></td>
                            <td><?= $data->mhs_nama ?></td>
                            <td><?= $data->program_studi ?></td>
                            <td><?= $data->mhs_angkatan ?></td>
                            <td class="text-center" width="160px">
                                <a href="<?= site_url('kegiatan/edit/' . $data->kegiatan_id) ?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil">Update</i></a>
                                <a href="<?= site_url('kegiatan/del/' . $data->kegiatan_id) ?>" onclick="return confirm('Yakin ingin menghapus?')" class="btn btn-danger btn-xs">
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
                "url": "<?= site_url('kegiatan/get_ajax') ?>",
                "type": "POST"
            },
        })
    })
</script>
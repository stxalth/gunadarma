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
    <div class="box">
        <div class="box-header">
            <h3 class="box-title"><?= ucfirst($page) ?> kegiatan</h3>
            <div class="pull-right">
                <a href="<?= site_url('kegiatan') ?>" class="btn btn-warning btn-flat">
                    <i class="fa fa-undo"> Back</i>
                </a>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <?php echo form_open_multipart('kegiatan/process'); ?>
                    <div class="form-group">
                        <label>Tahun </label>
                        <input type="hidden" name="id" value="<?= $row->kegiatan_id ?>">
                        <input type="number" name="tahun" value="<?= $row->tahun ?>" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Kategori </label>
                        <input type="text" name="kategori" value="<?= $row->kategori ?>" class="form-control">
                    </div>

                    <!-- <div class="form-group">
                        <label>Kepesertaan </label>
                        <input type="text" name="kepesertaan" value="<?= $row->kepesertaan ?>" class="form-control">
                    </div> -->

                    <div class="form-group">
                        <label>Kepesertaan</label>
                        <select type="text" name="kepesertaan" class="form-control">
                            <option value="">-Pilih-</option>
                            <option value="Internasional" <?= set_value('kepesertaan') == 1 ? "selected" : null ?>>Internasional</option>
                            <option value="Nasional" <?= set_value('kepesertaan') == 2 ? "selected" : null ?>>Nasional</option>
                            <option value="Provinsi" <?= set_value('kepesertaan') == 2 ? "selected" : null ?>>Provinsi</option>
                            <option value="Wilayah" <?= set_value('kepesertaan') == 2 ? "selected" : null ?>>Wiilayah</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Nama Kegiatan </label>
                        <input type="text" name="namakegiatan" id="namakegiatan" value="<?= $row->namakegiatan ?>" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Jumlah PT </label>
                        <input type="number" name="jmlpt" value="<?= $row->jmlpt ?>" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Jumlah Peserta </label>
                        <input type="number" name="jmlpeserta" value="<?= $row->jmlpeserta ?>" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Capaian </label>
                        <input type="text" name="capaian" value="<?= $row->capaian ?>" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Tanggal Mulai </label>
                        <input type="date" name="tglmulai" value="<?= $row->tglmulai ?>" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Tanggal Akhir </label>
                        <input type="date" name="tglakhir" value="<?= $row->tglakhir ?>" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>URL </label>
                        <input type="text" name="url" value="<?= $row->url ?>" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Sertifikat/Piala</label>
                        <?php if ($page == 'edit') {
                            if ($row->sertifpiala != null) { ?>
                                <div style="margin-bottom:5px;">
                                    <a href="<?= base_url('uploads/kegiatan/') . $row->sertifpiala ?>" class="btn btn-default btn-xs" style="width: 70px"><i class="fa fa-eye"> lihat</i></a>
                                </div>
                        <?php
                            }
                        } ?>
                        <input type="file" name="sertifpiala" class="form-control">
                        <small>(Biarkan kosong jika tidak ada <?= $page == 'edit' ? 'diganti' : 'ada' ?>)</small>
                    </div>

                    <div class="form-group">
                        <label>Surat Tugas</label>
                        <?php if ($page == 'edit') {
                            if ($row->surattugas != null) { ?>
                                <div style="margin-bottom:5px;">
                                    <a href="<?= base_url('uploads/kegiatan/') . $row->surattugas ?>" class="btn btn-default btn-xs" style="width: 70px"><i class="fa fa-eye"> lihat</i></a>
                                </div>
                        <?php
                            }
                        } ?>
                        <input type="file" name="surattugas" class="form-control">
                        <small>(Biarkan kosong jika tidak ada <?= $page == 'edit' ? 'diganti' : 'ada' ?>)</small>
                    </div>

                    <div class="form-group">
                        <label>Foto</label>
                        <?php if ($page == 'edit') {
                            if ($row->foto != null) { ?>
                                <div style="margin-bottom:5px;">
                                    <img src="<?= base_url('uploads/kegiatan/' . $row->foto)  ?>" style="width:80%;">
                                </div>
                        <?php
                            }
                        } ?>
                        <input type="file" name="foto" class="form-control">
                        <small>(Biarkan kosong jika tidak ada <?= $page == 'edit' ? 'diganti' : 'ada' ?>)</small>
                    </div>


                    <div class="form-group">
                        <label>Mahasiswa </label>
                        <?php echo form_dropdown(
                            'mahasiswa',
                            $mahasiswa,
                            $selectedmhs,
                            ['class' => 'form-control']
                        ) ?>
                    </div>

                    <div class="form-group">
                        <button type="submit" name="<?= $page ?>" class="btn btn-success btn-flat"><i class="fa fa-paper-plane"> Save</i></button>
                        <button type="reset" class="btn btn-flat">Reset</button>
                    </div>

                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </div>

</section>
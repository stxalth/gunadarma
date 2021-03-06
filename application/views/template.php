<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Gunadarma</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="<?= base_url() ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/buttons/2.1.0/css/buttons.dataTables.min.css">
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition skin-purple sidebar-mini">
    <div class="wrapper">
        <header class="main-header">
            <a href="<?= base_url('dashboard') ?>" class="logo">
                <span class="logo-mini"><b>G</b></span>
                <span class="logo-lg"><b>Gunadarma</b></span>
            </a>
            <nav class="navbar navbar-static-top">
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- User Account -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <span class="hidden-xs"><?= $this->fungsi->user_login()->username //untuk menampilkan data user pada bagian pojok KANAN atas
                                                        ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <div class="pull-right">
                                    <a href="<?= site_url('auth/logout') ?>" class="btn btn-flat bg-red">Sign out</a>
                                </div>
                            </ul>
                        </li>
                    </ul>
                    </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- Left side column -->
        <aside class="main-sidebar">
            <section class="sidebar">
                <div class="user-panel">
                    <div class="pull-left image">
                        <br></br>
                    </div>
                    <div class="pull-left info">
                        <p><?= ucfirst($this->fungsi->user_login()->username) ?></p>
                        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                    </div>
                </div>
                </form>
                <!-- sidebar menu -->
                <ul class="sidebar-menu" data-widget="tree">
                    <li class="header">MAIN NAVIGATION</li>
                    <li <?= $this->uri->segment(1) == 'dashboard' || $this->uri->segment(1) == '' ? 'class="active"' : '' ?>>
                        <a href="<?= site_url('dashboard') ?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
                    </li>
                    <li <?= $this->uri->segment(1) == 'programstudi' || $this->uri->segment(1) == '' ? 'class="active"' : '' ?>>
                        <a href="<?= site_url('programstudi') ?>"><i class="fa fa-thumb-tack"></i> <span>Program Studi</span></a>
                    </li>
                    <li <?= $this->uri->segment(1) == 'mahasiswa' || $this->uri->segment(1) == '' ? 'class="active"' : '' ?>>
                        <a href="<?= site_url('mahasiswa') ?>"><i class="fa fa-mortar-board"></i> <span>Mahasiswa</span></a>
                    </li>
                    <li <?= $this->uri->segment(1) == 'kegiatan' || $this->uri->segment(1) == '' ? 'class="active"' : '' ?>>
                        <a href="<?= site_url('kegiatan') ?>"><i class="fa fa-book"></i> <span>Daftar Kegiatan</span></a>
                    </li>

                    <?php if ($this->fungsi->user_login()->level == 1) { ?>
                        <li class="header">SETTINGS</li>
                        <li><a href="<?= site_url('user') ?>"><i class="fa fa-user"></i> <span>Users</span></a></li>
                    <?php } ?>
                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>

        <script src="<?= base_url() ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <?php echo $contents ?>
        </div>
        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>Version</b> 1.0
            </div>
            <strong>Copyright &copy; 2021 Pindo</a>.</strong> All rights
            reserved.
        </footer>
    </div>

    <script src="<?= base_url() ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <script src="<?= base_url() ?>assets/dist/js/adminlte.min.js"></script>

    <script src="<?= base_url() ?>assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url() ?>assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

    <script src="//cdn.datatables.net/buttons/2.1.0/js/dataTables.buttons.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="//cdn.datatables.net/buttons/2.1.0/js/buttons.html5.min.js"></script>
    <script src="//cdn.datatables.net/buttons/2.1.0/js/buttons.print.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#table1').DataTable()
        })
    </script>
</body>

</html>
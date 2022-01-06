<?php if ($this->session->has_userdata('success')) { ?>
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <i class="icon fa fa-ban"></i><?= strip_tags(str_replace('</p>', '', $this->session->flashdata('error'))) ?>
    </div>
<?php } ?>
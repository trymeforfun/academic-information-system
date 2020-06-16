<section class="content-header">
    <h1>
        Universitas Harapan Kita
        <small>Code Your life with your style</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="../admin"><i class="fa fa-dashboard"></i>Home</a></li>
        <li><a href="<?= $back; ?>">Menu</a></li>
        <li class="active"><?= $button; ?>Menu</li>
    </ol>
</section>

<!-- Main Content -->
<section class="content">

    <!-- Default Box -->
    <div class="box">
        <div class="box-body">
        
        <!-- Form input atau Edit User -->
        <h2 style="margin-top:0px">Jurusan<?= $button ?></h2>
        <form action="<?= $action; ?>" method="post">
        
        <div class="form-group">
            <label for="varchar">Kode jurusan<?= form_error('kode_jurusan'); ?></label>
            <input type="text" class="form-control name="kode_jurusan" id="kode_jurusan" placeholder="Kode jurusan" value="<?= $kode_jurusan; ?>">
        </div>
        <div class="form-group">
            <label for="varchar">Nama jurusan<?= form_error('nama_jurusan'); ?></label>
            <input type="text" class="form-control name="nama_jurusan" id="nama_jurusan" placeholder="Nama_jurusan" value="<?= $nama_jurusan; ?>">
        </div>
        <div class="form-group">
            <input type="hidden" class="form-control name="id" id="id" placeholder="id" value="<?= $id_jurusan; ?>"/>
            <button type="submit" class="btn btn-primary"><?= $button; ?></button>
            <a href="<?= site_url('jurusan') ?>" class="btn btn-danger">Cancel</a>

        </div>
       



    </div>

</section>
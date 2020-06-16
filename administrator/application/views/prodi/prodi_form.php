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
        <legend><?= $button; ?>Program Studi</legend>
        <form action="<?= $action; ?>" method="post">
        
        <div class="form-group">
            <label for="varchar">Kode Prodi<?= form_error('kode_prodi'); ?></label>
            <input type="text" class="form-control name="kode_prodi" id="kode_prodi" placeholder="Kode Prodi" value="<?= $kode_prodi; ?>">
        </div>
        <div class="form-group">
            <label for="varchar">Nama Prodi<?= form_error('nama_prodi'); ?></label>
            <input type="text" class="form-control name="nama_prodi" id="nama_prodi" placeholder="Nama Prodi" value="<?= $nama_prodi; ?>">
        </div>
        <div class="form-group">
            <label for="int">Jurusan<?= form_error('id_jurusan'); ?></label>
            <?= combobox('id_jurusan', 'jurusan', 'nama_jurusan', 'id_jurusan', $id_jurusan) ?>
        </div>
        <input type="hidden" name="id_prodi" value="<?= $id_prodi; ?>"/>
        <button type="submit" class="btn btn-primary"><?= $button; ?></button>
        <a href="<?= site_url('prodi'); ?>" class="btn btn-default">Cancel</a>
        </form>
        
        
        </div>




    </div>

</section>
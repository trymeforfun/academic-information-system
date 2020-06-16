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
        <h2 style="margin-top:0px">Menu<?= $button ?></h2>
        <form action="<?= $action; ?>" method="post">
        
        <div class="form-group">
            <label for="varchar">Nama Menu<?= form_error('nama_menu'); ?></label>
            <input type="text" class="form-control name="nama_menu" id="nama_menu" placeholder="Nama Menu" value="<?= $nama_menu; ?>">
        </div>
        <div class="form-group">
            <label for="varchar">Link<?= form_error('link'); ?></label>
            <input type="text" class="form-control name="link" id="link" placeholder="Link" value="<?= $link; ?>">
        </div>
        <div class="form-group">
            <label for="varchar">Icon<?= form_error('icon'); ?></label>
            <input type="text" class="form-control name="icon" id="icon" placeholder="Icon" value="<?= $icon; ?>"/>
        </div>
        <div class="form-group">
            <label for="int">Main Menu<?= form_error('main_menu'); ?></label>
            <?= combobox('main_menu', 'menu', 'nama_menu', 'id_menu', $id_menu); ?>
        </div>
        <input type="hidden" name="id_menu" value="<?= $id_menu; ?>"/>
        <button type="submit" class="btn btn-primary"><?= $button; ?></button>
        <a href="<?= site_url('menu'); ?>" class="btn btn-default">Cancel</a>
        </form>
        
        
        </div>




    </div>

</section>
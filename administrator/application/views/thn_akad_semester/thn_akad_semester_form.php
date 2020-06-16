<section class="content-header">
    <h1>
        Universitas Harapan Kita
        <small>Code Your life with your style</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="../admin"><i class="fa fa-dashboard"></i>Home</a></li>
        <li><a href="<?= $back; ?>">Tahun Akademik</a></li>
        <li class="active"><?= $button; ?>Tahun Akademik</li>
    </ol>
</section>

<!-- Main Content -->
<section class="content">

    <!-- Default Box -->
    <div class="box">
        <div class="box-body">
        
        <!-- Form input atau Edit User -->
        <legend><?= $button; ?>Tahun Akademik</legend>
        <form action="<?= $action; ?>" method="post">
        
        <div class="form-group">
            <label for="varchar">Tahun Akademik<?= form_error('thn_akad'); ?></label>
            <input type="text" class="form-control"  name="thn_akad" id="thn_akad" placeholder="Tahun Akademik" value="<?= $thn_akad; ?>">
        </div>
        <div class="form-group">
            <label for="varchar">Semester<?= form_error('semester') ?></label>
            <div class="radio">
                <label>
                    <input type="radio" name="semester" id="semester" value="1"
                    <?= set_value('semester', $semester) == 1 ? "checked" : ""; ?> checked
                    /> Ganjil
                </label>
                <label>
                    <input type="radio" name="semester" id="semester" value="2"
                    <?= set_value('semester', $semester) == 2 ? "checked" : ""; ?> checked
                    /> Genap
                </label>
            </div>
        </div>
        <input type="hidden" name="id_thn_akad" value="<?= $id_thn_akad; ?>"/>
        <button type="submit" class="btn btn-primary"><?= $button; ?></button>
        <a href="<?= site_url('thn_akad_semester'); ?>" class="btn btn-default">Cancel</a>
        </form>
        
        
        </div>




    </div>

</section>
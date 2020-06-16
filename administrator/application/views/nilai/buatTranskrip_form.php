<section class="content-header">
    <h1>Universitas Harapan Kita
        <small>code your life with your style</small>
    </h1>
    <ol class='breadcrumb'>
       <li><a href="../admin"><i class="fa fa-dashboard btn-primary"></i>Home</a></li> 
       <li class="active">Cetak Transkrip Nilai</li>
    </ol>
</section>

<div class="box">
    <div class="box-body">

    <h2 class="mt-0px">Cetak Transkrip Nilai</h2>
    <form action="<?= $action ?>" method="post">
        <?= validation_errors(); ?>
            <div class="form-group">
                <label for="char">NIM <?= form_error('nim') ?></label>&nbsp;
                <input type="text" name="nim" id="nim" placeholder="NIM" value="<?= $nim ?>">
            </div>
            <button type="submit" class="btn btn-primary">Proses</button>
    
    
    
    
    
    
    </form>
<section class="content-header">
    <h1>Universitas Harapan Kita
        <small>code your life with your style</small>
    </h1>
    <ol class='breadcrumb'>
       <li><a href="admin"><i class="fa fa-dashboard btn-primary"></i>Home</a></li> 
       <li class="active"><a href="<?= $back ?>">Matakuliah</a></li>
       <li class="active"><?= $button ?>Matakuliah</li>
    </ol>
</section>

<section class="content">

<div class="box">
    <div class="box-body">
        <legend><?= $button ?>Matakuliah</legend>
        <a href="<?= site_url('matakuliah/update/'.$kode_matakuliah) ?>" class="btn btn-primary">Update</a>
        <a href="<?= site_url('matakuliah') ?>" class="btn btn-warning">Cancel</a>
        <p></p>
        <table class="table table-stripped table-bordered">
            <tr><td>Kode Matakuliah</td><td><?= $kode_matakuliah ?></td></tr>
            <tr><td>Nama Matakuliah</td><td><?= $nama_matakuliah ?></td></tr>
            <tr><td>SKS</td><td><?= $sks ?></td></tr>
            <tr><td>Semester</td><td><?= $semester ?></td></tr>
            <tr>
                <td>Jenis</td>
                <td>
                    <?php
                        if($jenis == "U"){
                            echo "Umum";
                        } elseif ($jenis == "W") {
                            echo "Wajib";
                        } else {
                            echo "Pilihan";
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <td>Program Studi</td>\
                <td><?= $nama_prodi ?></td>
            </tr>
            <tr><td><td></td><a href="<?= site_url('matakuliah') ?>" class="btn btn-default">Cancel</a></td></tr>
        </table>
    
    </div>



</div>
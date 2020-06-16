<section class="content-header">
    <h1>Universitas Harapan Kita
        <small>code your life with your style</small>
    </h1>
    <ol class='breadcrumb'>
       <li><a href="admin"><i class="fa fa-dashboard btn-primary"></i>Home</a></li> 
       <li class="active"><a href="<?= $back ?>">Mahasiswa</a></li>
       <li class="active"><?= $button ?>Mahasiswa</li>
    </ol>
</section>

<section class="content">

<div class="box">
    <div class="box-body">
        <legend><?= $button ?>Matakuliah</legend>
        <a href="<?= site_url('mahasiswa/update/'.$nim) ?>" class="btn btn-primary">Update</a>
        <a href="<?= site_url('mahasiswa') ?>" class="btn btn-warning">Cancel</a>
        <p></p>
        <table class="table table-stripped table-bordered">
            <tr><td>Photo</td><td><img src="../../images/<?= $photo ?>" alt=""></td></tr>
            <tr><td>Nama Lengkap</td><td><?= $nama_lengkap ?></td></tr>
            <tr><td>Nama Panggilan</td><td><?= $nama_panggilan ?></td></tr>
            <tr><td>Alamat</td><td><?= $alamat ?></td></tr>
            <tr><td>Email</td><td><?= $email ?></td></tr>
            <tr><td>Telp</td><td><?= $telp ?></td></tr>
            <tr><td>Tempat Lahir</td><td><?= $tempat_lahir ?></td></tr>
            <tr><td>Tanggal Lahir</td><td><?= $tgl_lahir ?></td></tr>
            <tr>
                <td>Jenis</td>
                <td>
                    <?php
                        if($jenis_kelamin == "L"){
                            echo "Laki-laki";
                        }  else {
                            echo "Perempuan";
                        }
                        ?>
                </td>
            </tr>
            <tr><td>Agama</td><td><?= $agama ?></td></tr>
            <tr>
                <td>Program Studi</td>\
                <td><?= inputtext('id_prodi','prodi','nama_prodi','id_prodi',$id_prodi); ?></td>
            </tr>
            
        </table>
    
    </div>



</div>
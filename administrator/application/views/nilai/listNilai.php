<?php

$ci = get_instance();
$ci->load->model('Matakuliah_model');
$ci->load->model('Thn_akad_semester_model');

?>

<section class="content-header">
    <h1>Universitas Harapan Kita
        <small>code your life with your style</small>
    </h1>
    <ol class='breadcrumb'>
       <li><a href="admin"><i class="fa fa-dashboard btn-primary"></i>Home</a></li> 
       <li><a href="<?= $back ?>">Nilai Permatakuliah</a></li>
       <li class="active"><?= $button ?>Nilai Permatakuliah</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-body">
            <?php
            
                if ($list_nilai == null) {
                    $thn = $ci->Thn_akad_semester_model->get_by_id($id_thn_akad);

                    $semester = $thn->semester==1;

                    if ($semester == 1) {
                       $tampilSemester = "Ganjil";
                    } else {
                       $tampilSemester = "Genap";
                    }
                    
                    ?>
                    <div class="alert alert-danger">
                        <strong>MAAF !</strong> Tidak ada matakuliah <?= $ci->Matakuliah_model->get_by_id('kode_matakuliah') ?> di tahun ajaran <?= $thn->thn_akad. "(". $tampilSemester .")"; ?>
                    </div>
            <?php
                }
                else {

                
            ?>
            <center>
                <legend>MASUKKAN NILAI AKHIR</legend>
                <table>
                    <tr>
                        <td>Kode Matakuliah</td><td>: <?= $kode_matakuliah ?></td>
                    </tr>
                    <tr>
                        <td>Matakuliah</td><td>: <?= $ci->Matakuliah_model->get_by_id($kode_matakuliah)->nama_matakuliah ?></td>
                    </tr>
                    <tr>
                        <td>SKS</td><td>: <?= $ci->Matakuliah_model->get_by_id($kode_matakuliah)->sks ?></td>
                    </tr>
                    <?php
                    
                        $thn = $ci->Thn_akad_semester_model->get_by_id($id_thn_akad);
                        $semester = $thn->semester==1;

                        if ($semester == 1) {
                            $tampilSemester = "Ganjil";
                         } else {
                            $tampilSemester = "Genap";
                         }
               ?>

                    <tr>
                         <td>Tahun Akademik (semester)</td><td>: <?= $thn->thn_akad ."(". $tampilSemester .")";?></td>
                    </tr>
                </table>
            </center>
            <form action="<?= $action ?>" method="post">
                <table class="table table-bordered table table-stripped">
                <tr>
                    <td>NO</td>
                    <td>NIM</td>
                    <td>NAMA</td>
                    <td>NILAI</td>
                </tr>
                <?php

                    $no = 0;

                    foreach ($list_nilai as $row) {
                        $no++;

                ?>

                <tr>
                    <td><?= $no ?></td>
                    <td><?= $row->nim ?></td>
                    <td><?= $row->nama_lengkap ?></td>

                    <input type="hidden" name="id_krs[]" value="<?= $row->id_krs; ?>">
                    <td><input type="text" name="nilai[]" value="<?= $row->nilai ?>"></td>
                </tr>
                <?php } ?>
                </table>
                <button type="submit" class="btn btn-primary">Proses</button>
            </form>
                <?php } ?>


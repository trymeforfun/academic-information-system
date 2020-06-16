<?php 

$ci = get_instance();
$ci->load->helper('my_function');
$ci->load->model('Krs_model');
$ci->load->model('Mahasiswa_model');
$ci->load->model('Matakuliah_model');
$ci->load->model('Thn_akad_semester_model');

$krs = $ci->Krs_model->get_by_id($id[0]);
$kode_matakuliah = $krs->kode_matakuliah;
$id_thn_akad = $krs->id_thn_akad;

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

        <center>
            <legend>MASUKKAN NILAI AKHIR</legend>
            <table>
            
            <tr>
                <td>Kode Matakuliah</td>
                <td>: <?= $kode_matakuliah ?></td>
            </tr>
            <tr>
                <td>Matakuliah</td>
                <td>: <?= $ci->Matakuliah_model->get_by_id($kode_matakuliah)->nama_matakuliah;  ?></td>
            </tr>
            <tr>
                <td>: <?= $ci->Matakuliah_model->get_by_id($kode_matakuliah)->sks;  ?></td>
            </tr>
            <?php
            
            $thn = $ci->Thn_akad_semester_model->get_by_id($id_thn_akad);

            $semester = $thn->semester == 1;
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
        <div>&nbsp;</div>
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
                <td><?= $no; ?></td>
                <?php $nim = $ci->Krs_model->get_by_id($id_krs[$i])->nim ?>
                <td><?= $nim ?></td>
                <?php $nim = $ci->Mahasiswa_model->get_by_id($nim)->nama_lengkap ?>
                <td><?= $ci->Krs_model->get_by_id($id_krs[$i])->nilai ?></td>
                </tr>


          <?php } ?>
        </table>
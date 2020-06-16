<section class="content-header">
    <h1>Universitas Harapan Kita
        <small>code your life with your style</small>
    </h1>
    <ol class='breadcrumb'>
       <li><a href="admin"><i class="fa fa-dashboard btn-primary"></i>Home</a></li> 
       <li class="active">Menu</li>
    </ol>
</section>

<!-- Main Content -->
<section class="content">

<!-- Default box -->
<div class="box">
    <div class="box-body">
<center>
    <legend><strong>KARTU RENCANA STUDI</strong></legend>
    <table>
        <tr>
            <td><strong>NIM</strong></td><td>&nbsp;:<?= $nim ?></td>
        </tr>
        <tr>
            <td><strong>Nama</strong></td><td>&nbsp;:<?= $nama_lengkap ?></td>
        </tr>
        <tr>
            <td><strong>Program Studi</strong></td><td>&nbsp;:<?= $prodi ?></td>
        </tr>
        <tr>
            <td><strong>Tahun Akademik(Semester)</strong></td><td>&nbsp;:<?= $thn_akad . '&nbsp;('.$semester.')' ?></td>
        </tr>
    </table>
</center>
    <table class="table table-bordered table table-stripped mt-10px">
        <tr>
             <th>NO</th>
             <th>KODE</th>
             <th>MATAKULIAH</th>
             <th>SKS</th>
             <th>ACTION</th>
        </tr>

<?php


$no = 1;
$jumlahSks = 0;

foreach ($krs_data as $krs) {
    ?>
<tr>
<td width="80px"><?= $no++ ?></td>
<td><?= $krs->kode_matakuliah ?></td>
<td><?= $krs->nama_matakuliah ?></td>
<td>
    <?php
    
    echo anchor(site_url('krs/update/'.$krs->id_krs), '<button type="button" class="btn btn-warning"><i class="fa fa-pencil aria-hidden="true"></i></button>');
    echo '&nbsp';
    echoanchor(site_url('krs/delete/'.$krs->id_krs), '<button type="button" class="btn btn-warning"><i class="fa fa-pencil aria-hidden="true"></i></button>')
    
    ?>
</td>
</tr>
<?php
}
?>

<tr>
<td colspan="3"><strong>JUMLAH SKS</strong></td><strong><?= $jumlahSks ?></strong>
</tr>
</table>
<?php
echo anchor(site_url('krs/create'.$nim.'/'.$id_thn_akad),'Create','class="btn btn-primary"');
?>
</div>
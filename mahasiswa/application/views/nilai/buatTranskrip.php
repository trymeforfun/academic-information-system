<section class="content-header">
    <h1>Universitas Harapan Kita
        <small>code your life with your style</small>
    </h1>
    <ol class='breadcrumb'>
       <li><a href="../admin"><i class="fa fa-dashboard btn-primary"></i>Home</a></li> 
       <li class="active">Transkrip Nilai</li>
    </ol>
</section>

<section class="content">

    <div class="box">
        <div class="box-body">

            <?php
                $ci = get_instance();
                $ci->load->helper('my_function');
            ?>

            <center>
                <legend>TRNASKRIP NILAI</legend>
                <table>
                    <tr>
                    <td><strong>NIM</strong></td><td> : <?= $mhs_nim ?></td>
                    </tr>
                    <tr>
                    <td><strong>Nama</strong></td><td> : <?= $mhs_nama ?></td>
                    </tr>
                    <tr>
                    <td><strong>Prodi</strong></td><td> : <?= $mhs_prodi ?></td>
                    </tr>
                    <tr>
                    <td><strong>Tahun Akademik (Semester)</strong></td><td>&nbsp;: <?= $thn_akad ?></td>
                    </tr>
                </table>

                <br>

                <table class="table table-bordered table table-stripped">
                    <tr>
                        <td>NO</td>
                        <td>KODE</td>
                        <td>MATAKULIAH</td>
                        <td align="center">SKS</td>
                        <td align="center">NILAI</td>
                        <td align="center">SKOR</td>
                    </tr>
                    <?php
                    
                        $no = 0;

                        $jSks = 0;
                        $jSkor = 0;

                        foreach ($trans as $row) {
                            $no++;
                    ?>

                    <tr>
                    
                        <td><?= $no; ?></td>
                        <td><?= $row->kode_matakuliah; ?></td>
                        <td><?= $row->nama_matakuliah; ?></td>
                        <td align="right"><?= $row->sks; ?></td>
                        <td align="center"><?= $row->nilai; ?></td>
                        <td align="right"><?= skorNilai($row->nilai,$row->sks); ?></td>
                        <?php
                            $jSks+=$row->sks;
                            $jSkor+=skorNilai($row->nilai,$row->sks)
                        ?>
                    </tr>
                        <?php } ?>
                    <tr>
                        <td colspan="3">Jumlah</td>
                        <td align="right"><?= $jSks ?></td>
                        <td>&nbsp;</td>
                        <td align="right"><?= $jSkor ?></td>
                    </tr>
                </table>

                Indeks Prestasi : <?= number_format($jSkor/$jSks,2) ?>



            </center>
        
        
        
        </div>



    </div>
</section>
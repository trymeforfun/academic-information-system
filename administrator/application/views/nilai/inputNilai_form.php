<section class="content-header">
    <h1>Universitas Harapan Kita
        <small>code your life with your style</small>
    </h1>
    <ol class='breadcrumb'>
       <li><a href="../admin"><i class="fa fa-dashboard btn-primary"></i>Home</a></li> 
       <li><a href="<?= $back ?>">Nilai Permatakuliah</a></li>
       <li class="active"><?= $button ?>Nilai Permatakuliah</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-body">
            <legend>Input Nilai Permatakuliah</legend>
            <form action="<?= $action ?>" method="post">
            
                <?= validation_errors() ?>
                <div class="form-group">
                    <label for="int">Tahun Akademik (Semester<?= form_error('id_thn_akad') ?>)</label>
                    <?php
                    
                        $query = $this->db->query('SELECT id_thn_akad, semester, 
                                                   CONCAT (thn_akad,"/") as ta_sem
                                                   FROM thn_akad_semester ORDER BY id_thn_akad DESC ');
                        
                        $dropdowns = $query->result();
                        foreach ($dropdowns as $dropdown) {
                            if($dropdown->semester == 1){
                                $tampilSemester = "Ganjil";
                            } else {
                                $tampilSemester = "Genap";
                            }

                            $dropDownList[$dropdown->id_thn_akad] = $dropdown->ta_sem ." ". $tampilSemester;

                        }

                        echo form_dropdown('id_thn_akad', $dropDownList,'', 'class="form-control" id="id_thn_akad"');
                    ?>

                    <div class ="form-group">
                        <label for="char">Kode Matakuliah<?= form_error('kode_matakuliah') ?></label>
                        <input type="text" class="form-control" name="kode_matakuliah" id="kode_matakuliah" placeholder="Kode Matakuliah" value="<?= $kode_matakuliah?>">
                    </div>
                
                </div>

                <button type="submit" class="btn btn-primary">Proses</button>

            </form>
        
        
        </div>



    </div>



</section>
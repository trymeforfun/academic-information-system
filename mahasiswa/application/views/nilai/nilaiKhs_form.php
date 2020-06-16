<section class="content-header">
    <h1>Universitas Harapan Kita
        <small>code your life with your style</small>
    </h1>
    <ol class='breadcrumb'>
       <li><a href="admin"><i class="fa fa-dashboard btn-primary"></i>Home</a></li> 
       <li class="active">Kartu Hasil Studi Mahasiswa</li>
    </ol>
</section>

<div class="box">
    <div class="box-body">
        <legend>Kartu Hasil Studi Mahasiswa</legend>    
            <form action="<?= $action ?>">

                <div class="form-group">
                    <label for="char">NIM <?= form_error('nim') ?></label>
                    <input type="text" class="form-control "name="nim" id="nim" placeholder="NIM" value="<?= $username ?>"readonly/>
                </div>
                <div class="form-group">
            1       <label for="int">Tahun Akademik/Semester <?= form_error('id_thn_akad') ?></label>
                    <?php
                    
                        $query = $this->db->query('SELECT id_thn_akad,semester, 
                                                   CONCAT(thn_akad,"/") AS ta_sem
                                                   FROM thn_akad_semester
                                                   ORDER BY id_thn_akad DESC');
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
                </div>
                
                <button type="submit" class="btn btn-primary">Proses</button>
            
            </form>
    
    
    
    </div>



</div>
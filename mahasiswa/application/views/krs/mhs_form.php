<section class="content-header">
    <h1>
        Universitas Harapan Kita
        <small>Code Your life with your style</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="../admin"><i class="fa fa-dashboard"></i>Home</a></li>
        <li><a href="<?= $back; ?>">KRS Mahasiswa</a></li>
        <li class="active"><?= $button; ?>KRS Mahasiswa</li>
    </ol>
</section>

<!-- Main Content -->
<section class="content">

    <!-- Default Box -->
    <div class="box">
        <div class="box-body">
        
        <!-- Form input atau Edit User -->
        <legend><?= $button; ?>Kartu Rencana Studi Mahasiswa</legend>
        <form action="<?= $action; ?>" method="post">
        <?php $username = $this->session->userdata['username']; ?>
        <div class="form-group">
        <label for="char">Nomor Mahasiswa<?= form_error('nim') ?></label>
        <input type="text" name="nim" id="nim" placeholder="Nomor Mahasiswa" value="<?= $username ?>"readonly/>
        </div>

        <div class="form-group">
        <label for="int">
            Tahun Akademik/Semester 
            <?= form_error('id_thn_akad') ?>
        </label>
        <?php
            $query = $this->db->query('SELECT id_thn_akad, semester, CONCAT(thn_akad,"/") AS thn_semester FROM thn_akad_semester ORDER BY id_thn_akad DESC');
            $dropdowns = $query->result();

            foreach($dropdowns as $dropdown){
                if ($dropdown->semester == 1) {
                    $tampilSemester = "Ganjil";
                } else {
                    $tampilSemester = "Genap";
                }

                $dropDownList[$dropdown->id_thn_akad] = $dropdown->thn_semester. "". $tampilSemester;
            }

            echo form_dropdown('id_thn_akad', $dropDownList,'', 'class="form-control" id="id_thn_akad"');

        ?>
        </div>
        <button type="submit" class="btn btn-primary">Proses</button>
        </form>
        
        
        </div>




    </div>

</section>
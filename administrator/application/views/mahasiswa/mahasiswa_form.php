<section class="content-header">
    <h1>
        Universitas Harapan Kita
        <small>Code Your life with your style</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="../admin"><i class="fa fa-dashboard"></i>Home</a></li>
        <li><a href="<?= $back; ?>">Menu</a></li>
        <li class="active"><?= $button; ?>Menu</li>
    </ol>
</section>

<!-- Main Content -->
<section class="content">

    <!-- Default Box -->
    <div class="box">
        <div class="box-body">
        
        <!-- Form input atau Edit -->

        <legend><?= $button; ?>Mahasiswa</legend>
        <form role="form" class="form-horizontal" action="<?= $action ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" class="form-control" name="photo" id="photo" value="<?= $photo ?>" >
        

            <div class="form-group">
                <label class="col-sm-2"for="char">Nomor Mahasiswa</label>
                    <div class="col-sm-4">
                     <input type="text" name="nim" id="nim" class="form-control" placeholder="Nim" value="<?= $nim ?>">
                     <?= form_error('nim') ?>
                    </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2" for="varchar">Nama Lengkap</label>
                    <div class="col-sm-10">
                     <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" placeholder="Nama Lengkap" value="<?= $nama_lengkap ?>">
                     <?= form_error('nama_lengkap') ?>
                    </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2" for="varchar">Nama Panggilan</label>
                    <div class="col-sm-10">
                     <input type="text" name="nama_panggilan" id="nama_panggilan" class="form-control" placeholder="Nama Panggilan" value="<?= $nama_panggilan ?>">
                     <?= form_error('nama_panggilan') ?>
                    </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2" for="varchar">Alamat</label>
                    <div class="col-sm-10">
                     <input type="text" name="alamat" id="alamat" class="form-control" placeholder="Alamat" value="<?= $alamat ?>">
                     <?= form_error('alamat') ?>
                    </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2" for="varchar">Email</label>
                    <div class="col-sm-4">
                     <input type="text" name="email" id="email" class="form-control" placeholder="Email" value="<?= $email ?>">
                     <?= form_error('email') ?>
                    </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2" for="varchar">Telp</label>
                    <div class="col-sm-8">
                     <input type="text" name="telp" id="telp" class="form-control" placeholder="Telp" value="<?= $telp ?>">
                     <?= form_error('telp') ?>
                    </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2" for="varchar">Tempat Lahir</label>
                    <div class="col-sm-10">
                     <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" placeholder="Tempat Lahir" value="<?= $tempat_lahir ?>">
                     <?= form_error('tempat_lahir') ?>
                    </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2" for="varchar">Tanggal Lahir</label>
                    <div class="col-sm-10">
                     <input type="date" name="tgl_lahir" id="tempat_lahir" class="form-control"  value="<?= isset($tgl_lahir) ? set_value('tgl_lahir', date('Y-m-d', strtotime($tgl_lahir))) : set_value($tgl_lahir); ?>">
                     <?= form_error('tgl_lahir') ?>
                    </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2" for="enum">Jenis Kelamin</label>
                    <div class="col-sm-4">
                     <?php
                        $pilihan = [ "" => "-- Pilihan --",
                                     "L" => "Laki-laki",
                                     "P" => "Perempuan"
                                    ];
                        echo form_dropdown('jenis_kelamin',$pilihan,$jenis_kelamin,'class ="form-control" id="jenis_kelamin"');
                        echo form_error('jenis_kelamin');
                     ?>
                    </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2" for="enum">Agama</label>
                    <div class="col-sm-4">
                     <?php
                        $pil_agama = [ "" => "-- Pilihan --",
                                     "Islam" => "Islam",
                                     "katholik" => "Katholik",
                                     "Protestan" => "Protestan",
                                     "Hindu" => "Hindu",
                                     "Budha" => "Budha",
                                     "Lainnya" => "Lainnya"
                                    ];
                        echo form_dropdown('agama',$pil_agama,$agama,'class ="form-control" id="agama"');
                        echo form_error('agama');
                     ?>
                    </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2" for="enum">Jenis Kelamin</label>
                    <div class="col-sm-4">
                     <?php
                        $query = $this->db->query('SELECT id_prodi, nama_prodi FROM prodi');
                        $dropdowns = $query->result();
                        foreach($dropdowns as $dropdown){
                            $dropDownList[$dropdown->id_prodi] = $dropdown->nama_prodi;
                        }
                        $finalDropDown = array_merge(array("" => "-- Pilihan --"), $dropDownList);
                        echo form_dropdown('id_prodi', $finalDropDown, $id_prodi, 'class="form-control" id="id_prodi"');
                        echo form_error('id_prodi')
                     ?>
                    </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2" for="photo">Photo</label>
                    <div class="col-sm-4">
                        <?php
                            if($photo ==""){
                                echo "<p class='help-block'>Silahkan Upload foto Mahasiswa</p>";
                            } else {
                        ?>
                        <div>
                            <img src="<?= base_url() ?>images/<?= $photo ?>" alt=""> 
                        </div><br>
                        <?php
                        }
                        ?>
                        <input type="file" name="photo" id="photo">
                    </div>
            </div>
    <button type="submit" class="btn btn-primary"><?= $button ?></button>
    <a href="<?= site_url('mahasiswa') ?>" class="btn btn-default">Cancel</a>




        </form>
        
        </div>




    </div>

</section>
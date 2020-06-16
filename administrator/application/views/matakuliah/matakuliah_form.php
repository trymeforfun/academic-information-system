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

        <legend><?= $button; ?></legend>
        <form action="<?= $action ?>" method="post">
        

    <div class="form-group">
        <label for="varchar">Kode Matakuliah<?= form_error('kode_matakuliah') ?></label>
        <input type="text" name="kode_matakuliah" id="kode_matakuliah" class="form-control" placeholder="Kode Matakuliah" value="<?= $kode_matakuliah ?>">
    </div>
    <div class="form-group">
        <label for="varchar">Nama Matakuliah<?= form_error('nama_matakuliah') ?></label>
        <input type="text" name="nama_matakuliah" id="nama_matakuliah" class="form-control" placeholder="Nama Matakuliah" value="<?= $nama_matakuliah ?>">
    </div>

    <div class="form-group">
        <label for="enum">SKS <?= form_error('sks') ?></label>
        <?php
            $pilihan = [
                "" => "-- Pilihan --",
                "1" => "1",
                "2" => "2",
                "3" => "3",
                "4" => "4",
                "5" => "5",
                "6" => "6",
            ];

            echo form_dropdown('sks', $pilihan,$sks,'class ="form-control" id="sks"');
        ?>
    </div>
    <div class="form-group">
        <label for="enum">Semester <?= form_error('semester') ?></label>
        <?php
            $pilihan = [
                "" => "-- Pilihan --",
                "1" => "1",
                "2" => "2",
                "3" => "3",
                "4" => "4",
                "5" => "5",
                "6" => "6",
                "7" => "7",
                "8" => "8",
            ];
            
            echo form_dropdown('semester', $pilihan,$semester,'class ="form-control" id="semester"');
            ?>
    </div>

    <div class="form-group">
            <label for="enum">Jenis<?= form_error('jenis') ?></label>
            <?php 
                $pilJenis = [
                    "" => "-- Pilihan --",
                    "U" => "Umum",
                    "W" => "Wajib",
                    "P" => "Pilihan",
                    
                ];
                    echo form_dropdown('jenis', $pilJenis,$jenis,'class ="form-control" id="jenis"');
            ?>
    </div>
    <div class="form-group">
                <label for="int">Prodi<?= form_error('id_prodi') ?></label>
                <?= combobox('id_prodi', 'prodi' ,'nama_prodi', 'id_prodi', $id_prodi) ?>
    </div>

    <button type="submit" class="btn btn-primary"><?= $button ?></button>
    <a href="<?= site_url('matakuliah') ?>" class="btn btn-default">Cancel</a>




        </form>
        
        </div>




    </div>

</section>
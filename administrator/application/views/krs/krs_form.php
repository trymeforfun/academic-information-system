<section class="content-header">
    <h1>
        Universitas Harapan Kita
        <small>Code Your life with your style</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="../admin"><i class="fa fa-dashboard"></i>Home</a></li>
        <li><a href="<?= $back; ?>">Data Kartu Rencana Studi</a></li>
        <li class="active"><?= $judul; ?>Data Kartu Rencana Studi</li>
    </ol>
</section>
<div class ="box">
    <div class="box-body">
        <legend><?= $judul; ?>Data Kartu Rencana Studi</legend>
            <form action="<?= $action ?>" method="post">
                <div class="form-group">
                    <label for="int">Tahun Akademik<?= form_error('id_thn_akad') ?></label>
                    <input type="text" class="form-control" name="thn_akad_smt" value="<?= $thn_akad_smt.'/'.$semester ?>"readonly/>
 <input type="hidden" name="id_thn_akad" class="form-control" id="id_thn_akad" value="<?= $id_thn_akad ?>">
                    <input type="hidden" name="id_krs" class="form-control" id="id_krs" value="<?= $id_krs?>" >
                </div>

                <div class="form-group">
                    <label for="char">Nomor Mahasiswa<?= form_error('nim') ?></label>
                    <input type="text" name="nim" id="nim" value="<?= $nim ?>" placeholder="NIM" readonly/> 
                </div>
                <div class="form-group">
                    <label for="int">Matakuliah<?= form_error('kode_matakuliah') ?></label>
                    <?php
                        $query = $this->db->query('SELECT kode_matakuliah,nama_matakuliah FROM matakuliah');
                        $dropdowns = $query->result();
                        foreach ($dropdowns as $dropdown) {
                            $dropDownList[$dropdown->kode_matakuliah] = $dropdown->nama_matakuliah;
                        }
                        echo form_dropdown('kode_matakuliah',$dropDownList,$kode_matakuliah,'class="form-control" id="kode_matakuliah"')
                    ?>
                </div>
                <button class="btn btn-primary"type="submit">Simpan</button>
                <a href="<?= site_url('krs') ?>" class="btn btn-default">Cancel</a>
                </form>


    </div>
</div>
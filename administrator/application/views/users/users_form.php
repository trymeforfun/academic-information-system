<section class="content-header">
    <h1>
        Universitas Harapan Kita
        <small>Code Your life with your style</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="../admin"><i class="fa fa-dashboard"></i>Home</a></li>
        <li><a href="<?= $back; ?>">Users</a></li>
        <li class="active"><?= $button; ?>Users</li>
    </ol>
</section>

<!-- Main Content -->
<section class="content">

    <!-- Default Box -->
    <div class="box">
        <div class="box-body">
        
        <!-- Form input atau Edit User -->
        <h2 style="margin-top:0px">Users<?= $button ?></h2>
        <form action="<?= $action; ?>" method="post">
        
        <div class="form-group">
            <label for="varchar">Username<?= form_error('username'); ?></label>
            <input type="text" class="form-control" name="username" id="username" placeholder="Username" value="<?= $username; ?>">
        </div>
        <div class="form-group">
            <label for="varchar">Password<?= form_error('password'); ?></label>
            <input type="text" class="form-control" name="password" id="password" placeholder="Password" value="<?= $password; ?>">
        </div>
        <div class="form-group">
            <label for="varchar">Email<?= form_error('email'); ?></label>
            <input type="text" class="form-control" name="email" id="email" placeholder="Email" value="<?= $email; ?>"/>
        </div>
        <div class="form-group">
            <label for="enum">Level<?= form_error('level')?></label>
            <select name="level" class="form-control select2" style="width:100%;">

        <?php
        if($level =='admin'){
            ?>
            <option value="admin" selected>Admin</option>
            <option value="mahasiswa">Mahasiswa</option>

        <?php
                }
                elseif($level == 'mahasiswa'){
                    ?>
                    <option value="admin" >Admin</option>
                    <option value="mahasiswa" selected>Mahasiswa</option>

        <?php
        }else{
            ?>
            <option value="admin" >Admin</option>
            <option value="mahasiswa">Mahasiswa</option>

        <?php
        }
        ?>
    </select>
    </div>
    <div class="form-group">
    <label for="enum">Blokir<?= form_error('blokir')?></label>
    <select name="blokir" class="form-control select2" style="width:100%;">
        <?php
        if($blokir == 'Y'){
            ?>
                <option value="Y" selected>Ya</option>
                <option value="N">No</option>
            <?php  
             }elseif($blokir == 'N'){
                 ?>
                 <option value="Y">Ya</option>
                 <option value="N" selected>No</option>
                <?php
             }else{
                 ?>
                 <option value="Y">Ya</option>
                 <option value="N">No</option>
            <?php
             }
            ?>
        </select>
    </div>
        
        <button type="submit" class="btn btn-primary"><?= $button; ?></button>
        <a href="<?= site_url('users')?>" class="btn btn-danger">Cancel</a>
        </form>
        
        </div>




    </div>

</section>
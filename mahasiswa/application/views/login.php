<body class="hold-transition login-page">
<div class="login-box" id="box">
    <div class="login-logo">
      <a href="index.php"><b>Mahasiswa</b></a>
    </div>
    <div class="login-box-body">
      <center><img width="25%px" src="<?= base_url('assets/')?>images/ekoenergi.jpg" id="uhkimage" class="rounded-circle" alt=""></center>
    
<form action="<?= base_url('login/proses'); ?>" method="post" class="user">
    <div class="row">
      <?php 
        // validasi error, jika passsword atau username tidak cocok 
        if(validation_errors() || $this->session->flashdata('result_login')){
          ?>
          <div class="alert alert-danger animated fadeInDown" role="alert">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong>Peringatan!</strong>
          <?php
          // Menampilkan error
          echo validation_errors();
          //session data user
          echo $this->session->flashdata('result_login'); 
          ?>
          </div><?php
        }
        ?>
      
    </div >
    <?= $this->session->flashdata('message'); ?>
    <div class="form-group has-feedback">
        <input type="text" name="username"  class="form-control" placeholder="Username">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password"  class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
    <div class="row">
        <div class="col-xs-8"></div>
          <div class="col-xs-4">
            <button type="submit" id="btn_login" class="btn btn-primary btn-block btn-flat">Sign In</button>
          </div>
    </div>
    </form>


     
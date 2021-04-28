
  <div class="container">
    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="text-center" style="margin-top: 25px;">
          <h1 class="h4 text-gray-900 mb-4">Environmental Management Bureau - Company Registration System (CRS)</h1>
        </div>
        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image-crs"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Sign in</h1>
                  </div>
                  <div class="text-center">
                    <span style="font-size:14px;color:red;padding-bottom: 20px;"><?php echo $this->session->flashdata('login_msg'); ?></span>
                  </div>
                  <form class="user" action="<?php echo base_url(); ?>Login/validate_login" method="post" id="client_login">
                    <div class="form-group">
                      <input type="username" name="username" class="form-control form-control-user" id="exampleInputUsername" aria-describedby="emailHelp" placeholder="Enter Username...">
                    </div>
                    <div class="form-group">
                      <input type="password" name="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password">
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block" name="button">Login</button>
                    <hr>
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="<?php echo base_url(); ?>Login/rest_pass">Forgot Password?</a> |
                        <a class="small" href="<?php echo base_url(); ?>register">Create an Account</a><br><br>
                  </div>
                  <div class="text-center">

                    <a target="_blank" href="<?= base_url()?>uploads/steps_crs_new.pdf">USER MANUAL <i class="fa fa-book" aria-hidden="true"></i></a>
                    <!-- <link rel="stylesheet" href="/css/master.css"> -->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>
<script type="text/javascript">

  $(document).ready(function(e){
    $("#client_login").validate({
     rules: {
       username:{
         required:true,
         minlength: 5,
       },
       password:{
         minlength: 7,
         required:true,
       },
     },
     messages:{
        username:{
          required:     "Specify  your username",
          minlength:     jQuery.validator.format("At least {0} characters required!"),
        },
        password:{
          required:      "Specify  your password",
          minlength:     jQuery.validator.format("At least {0} characters required!")
        },

     },

    });

    // for dropzone

  })

</script>

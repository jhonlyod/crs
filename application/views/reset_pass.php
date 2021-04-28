<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image-crs"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-2">Forgot Your Password?</h1>
                    <p class="mb-4">We get it, stuff happens. Just enter your registered email address below and we'll send you a verfication link!</p>
                  </div>
                  <div class="text-center">
                      <?php if (!empty($error)): ?>
                        <p class="mb-4" style="color:red;font-size:12px"><?php echo $error ?></p>
                      <?php endif; ?>
                   </div>

                  <form class="user" action="<?= base_url() ?>Login/send_reset_pass" method="post">
                    <div class="form-group">
                      <input type="email" name="email" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address..." required>
                    </div>
                    <button class="btn btn-primary btn-user btn-block" type="submit" name="button">SEND</button>
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="<?php echo base_url(); ?>User">Create an Account!</a>
                  </div>
                  <div class="text-center">
                    <a class="small" href="<?php echo base_url(); ?>Login">Already have an account? Login!</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
.buttonload {
  background-color: #4CAF50; /* Green background */
  border: none; /* Remove borders */
  color: white; /* White text */
  padding: 12px 24px; /* Some padding */
  font-size: 16px; /* Set a font-size */
}

/* Add a right margin to each icon */
.fa {
  margin-left: -12px;
  margin-right: 8px;
}
h2#swal2-title {
    font-size: 15px;
}
</style>
  <div class="container" style="max-width: 720px !important ;">

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <!-- background: url(https://source.unsplash.com/Mv9hjnEUHR4/600x800);
background-position: center;
background-size: cover; -->
          <div class="col-lg-12">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Create an Account </h1>
              </div>
              <!-- <form class="user" id="est_registration" name="est_registration_name" action="<?php //echo base_url(); ?>User/save_user_data" enctype="multipart/form-data" method="post"> -->
              <form class="user" action="<?php echo base_url(); ?>User/save_user_data" id="est_registration" name="est_registration_name" enctype="multipart/form-data" method="post">
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" value="<?= $acc_data[0]['username']?>" name="username" class="form-control form-control-user" placeholder="Username">
                  </div>
                  <div class="col-sm-6">
                    <input type="text" value="<?= $acc_data[0]['first_name']?>" name="first_name" class="form-control form-control-user" placeholder="First Name">
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" value="<?= $acc_data[0]['last_name']?>" name="last_name" class="form-control form-control-user" placeholder="Last Name">
                  </div>
                  <div class="col-sm-6">
                    <input type="text" value="<?= $acc_data[0]['position']?>" name="position" class="form-control form-control-user" placeholder="Position">
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="email" value="<?= $acc_data[0]['email']?>" class="form-control form-control-user"  placeholder="Email" name="email">

                    <!-- <select class="form-control" name="salutation" style="border-radius: 25px;height: 48px;">
                      <option value="" disabled selected>-Salutation-</option>
                      <option value="II">II</option>
                      <option value="III">III</option>
                      <option value="IV">IV</option>
                      <option value="V">V</option>
                      <option value="VI">VI</option>
                      <option value="Jr.">Jr.</option>
                      <option value="Sr.">Sr.</option>
                    </select> -->
                  </div>
                  <div class="col-sm-6">
                    <input type="text" value="<?= $acc_data[0]['contact_no']?>" class="form-control form-control-user"  placeholder="Telephone/Mobile No" name="contact_no">
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="password" class="form-control form-control-user"  placeholder="Password" name="password" id="password">
                  </div>
                  <div class="col-sm-6">
                    <input type="password" class="form-control form-control-user"  placeholder="Confirm Password" name="verify_password">
                  </div>
                </div>
                <div class="form-group row">
                  <!-- <div class="col-sm-12 mb-3 mb-sm-0">
                    <input type="email" value="<?= $acc_data[0]['email']?>" class="form-control form-control-user"  placeholder="Email" name="email">
                  </div> -->

                </div>
                <div class="form-group row">
                  <div class="col-sm-12">
                    <select class="form-control " name="region" style="border-radius: 25px;height: 48px;">
                        <option value="<?= $acc_data[0]['']?>" disabled selected>SELECT REGION - (user location)</option>
                        <?php foreach ($regions as $key => $regval): ?>
                          <?php if ($regval['rgnid'] == $acc_data[0]['region']): ?>
                                <option value="<?= $regval['rgnid']?>" selected><?= $regval['rgnnam']?></option>
                                <?php else: ?>
                                    <option value="<?= $regval['rgnid']?>" ><?= $regval['rgnnam']?></option>
                          <?php endif; ?>

                        <?php endforeach; ?>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="">COMPANY ID</label>
                    <input type="file" class="form-control " name="company_id" id="comp_id">
                    </div>

                  <div class="col-sm-6">
                      <label for="">GOVERNMENT ID</label>
                    <input type="file" class="form-control "  name="government_id">
                  </div>
                </div>

                <div class="form-group row">
                  <div class="col-sm-3 mb-3 mb-sm-0">
                    <div class="text-center">
                      <a class="small" href="<?php echo base_url(); ?>Login">Already have an account?</a><br>
                    </div>
                  </div>
                  <div class="col-sm-6">

                    <!-- <a href="login.html" class="btn btn-primary btn-user btn-block">
                      Register Account
                    </a> -->
                    <!-- <input type="submit" name="" value="Register Account" class="btn btn-primary btn-user btn-block"> -->
                    <button type="submit" class="btn btn-primary btn-user btn-block" name="button" id="save_user_data_btn">Save</button>
                    <button type="button" class="btn btn-primary btn-user btn-block buttonload" name="button" disabled style="display:none">  <i class="fa fa-spinner fa-spin"></i>Please Wait</button>

                  </div>
                  <div class="col-sm-3">

                  </div>
                </div>
              </form>
              <hr>
              <div class="text-center">

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
  <!-- <?php //echo base_url(); ?>User/save_user_data -->
    <script type="text/javascript">
  $(document).ready(function(e){
    $(":file").on("change", function(e) {
      var file = this.files[0];
      var fileType = file["type"];
      var validImageTypes = ["image/gif", "image/jpeg", "image/png"];
      if ($.inArray(fileType, validImageTypes) < 0) {
        alert('Invalid file, Please upload image.');
        $(this).val("");
      }else {
        return true;
      }
    })

    jQuery.validator.addMethod("noSpace", function(value, element) {
 return value.indexOf(" ") < 0 && value != "";
}, "No space please and don't leave it empty");

      $("#est_registration").validate({
        rules: {
          first_name: "required",
          last_name: "required",
          position: "required",
          contact_no: "required",
          salutation: "required",
          region: "required",
          company_id: "required",
          government_id: "required",
          password:{
            minlength: 7,
            required:true,
          },
          verify_password:{
            equalTo: "#password",
          },
          username:{
            required:true,
            minlength: 7,
             noSpace: true,
            remote:{
              url : '<?php echo base_url(); ?>User/check_fields',
              type: "post",
            },
          },
          email: {
            required: true,
            email: true,
            remote:{
              url : '<?php echo base_url(); ?>User/check_fields',
              type: "post",
            },
          },
        },
        messages:{
          company_id:     "Attach your company id",
          government_id:  "Attach your Government id",
          first_name:     "Specify your first name",
          last_name:      "Specify your last name",
          position:       "Specify your company position",
          contact_no:     "Specify your contact number",
          salutation:     "Specify your salutation",
          // email:          "Specify valid email",
          email:{
            required:      "Specify  your email",
            remote:        "Email already exists.",
          },
          region:         "Specify your region",
          username:{
            remote:        "Username already exists.",
            required:     "Specify  your username",
            minlength:     jQuery.validator.format("At least {0} characters required!"),
          },
          password:{
            required:      "Specify  your password",
            minlength:     jQuery.validator.format("At least {0} characters required!")
          },
          verify_password: " Enter Confirm Password Same as Password"

        },

      });
      $('#est_registration').submit(function(e){
         if( $(this).valid() ) {
           $('#save_user_data_btn').hide();
            $('.buttonload').show();
         }
      })
    // for dropzone

  })

</script>

<?php if ($this->session->flashdata('save_est_msg') != ''): ?>
<script type="text/javascript">
 $(document).ready(function() {
   Swal.fire({
     title: 'Registered Successfully',
     text: 'Please login. Thank you.',  // title: 'Sweet!',
     // text: '<?php //echo $this->session->flashdata('messsage'); ?>',
     imageUrl: '<?php echo base_url(); ?>assets/images/logo.png',
     imageWidth: 135,
     imageHeight: 50,
     imageAlt: 'Custom image',
     })
     // for validations
     // for main and branch
 });


</script>
<?php endif; ?>

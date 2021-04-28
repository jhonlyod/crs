

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
                <h1 class="h4 text-gray-900 mb-4">User Profile </h1>
              </div>
              <!-- <form class="user" id="est_registration" name="est_registration_name" action="<?php //echo base_url(); ?>User/save_user_data" enctype="multipart/form-data" method="post"> -->
              <form class="user" action="<?php echo base_url(); ?>User/save_user_data" id="est_registration" name="est_registration_name" enctype="multipart/form-data" method="post">
                <input type="hidden" name="user_id" value="<?= $this->encrypt->encode($acc_data[0]['client_id'])?>">
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" value="<?= $acc_data[0]['username']?>" name="username" class="form-control form-control-user" placeholder="Username" readonly>
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
                    <select class="form-control" name="salutation" style="border-radius: 25px;height: 48px;" id="salutation_id">
                      <option value="" disabled selected>-Salutation-</option>
                      <option value="II">II</option>
                      <option value="III">III</option>
                      <option value="IV">IV</option>
                      <option value="V">V</option>
                      <option value="VI">VI</option>
                      <option value="Jr">Jr.</option>
                      <option value="Sr">Sr.</option>
                    </select>
                  </div>
                  <div class="col-sm-6">
                    <input type="text" value="<?= $acc_data[0]['contact_no']?>" class="form-control form-control-user"  placeholder="Telephone/Mobile No" name="contact_no">
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <button type="button" name="button" style="color: #2E59D9;border: none;background: white;position: absolute;"><i class="fa fa-eye" aria-hidden="true" id="show_pass_btn"></i></button>
                    <input type="password" class="form-control form-control-user" value="<?= $this->encrypt->decode($acc_data[0]['raw_password'])?>" placeholder="Password" name="password" id="password">
                  </div>
                  <div class="col-sm-6">
                    <input type="password" class="form-control form-control-user"  placeholder="Confirm Password" name="verify_password">
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-12 mb-3 mb-sm-0">
                    <input type="email" value="<?= $acc_data[0]['email']?>" class="form-control form-control-user"  placeholder="Email" name="email">
                  </div>

                </div>
                <div class="form-group row">
                  <div class="col-sm-12">
                    <select class="form-control " name="region" style="border-radius: 25px;height: 48px;">
                        <option value="<?= $acc_data[0]['']?>" disabled selected>SELECT REGION</option>
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
                    <div class="" id="btn_new_comp_id_container" >
                      <a href="<?php echo base_url() ?>uploads/user_attch_id/company_id/<?= $this->session->userdata('view_user_id'); ?>/<?=$acc_comp_attch[0]['name']?>" target="_blank">Company ID </a><button type="button" name="button" style="border: none;background: none;color: #4E73DF;" id="btn_new_comp_id"><i class="fa fa-plus" aria-hidden="true" ></i></button>
                    </div>
                  </div>
                  <div class="col-sm-6 mb-3 mb-sm-0">
                      <div class="" id="btn_new_gov_id_container">
                        <a href="<?php echo base_url() ?>uploads/user_attch_id/gov_id/<?= $this->session->userdata('view_user_id'); ?>/<?=$acc_gov_attch[0]['name']?>" target="_blank">Government ID</a><button type="button" name="button" style="border: none;background: none;color: #4E73DF;" id="btn_new_gov_id"><i class="fa fa-plus" aria-hidden="true"></i></button>
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <div class="" id="undo_new_comp_btn_container" style="display:none">
                      <label for="">COMPANY ID</label><button type="button" name="button" style="border: none;background: none;color: #4E73DF;" id="undo_new_comp_btn"><i class="fa fa-undo" aria-hidden="true"></i></button>
                      <input type="file" class="form-control " name="company_id">
                    </div>
                  </div>
                  <div class="col-sm-6" >
                    <div class=""id="undo_new_gov_btn_container" style="display:none">
                      <label for="">GOVERNMENT ID</label>  <button type="button" name="button" style="border: none;background: none;color: #4E73DF;" id="undo_new_gov_btn"><i class="fa fa-undo" aria-hidden="true"></i></button>
                      <input type="file" class="form-control "  name="government_id">
                    </div>

                  </div>
                </div>

                <div class="form-group row">
                  <div class="col-sm-3 mb-3 mb-sm-0">
                    <!-- <div class="text-center">
                      <a class="small" href="<?php echo base_url(); ?>Login">Already have an account? Login!</a><br>
                        <a class="small" href="<?php echo base_url(); ?>Login/rest_pass">Forgot Password?</a>
                    </div> -->
                  </div>
                  <div class="col-sm-6">

                    <!-- <a href="login.html" class="btn btn-primary btn-user btn-block">
                      Register Account
                    </a> -->
                    <!-- <input type="submit" name="" value="Register Account" class="btn btn-primary btn-user btn-block"> -->
                    <button type="submit" class="btn btn-primary btn-user btn-block" name="button">Save</button>
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
    $('#show_pass_btn').on('click',function(){
      $('#password').attr('type','text');
    })
    $('#btn_new_comp_id').on('click',function(){
      $(this).parent().hide();
      $('#undo_new_comp_btn_container').show();
    })
    $('#undo_new_comp_btn').on('click',function(){
      $(this).parent().hide();
      $('#btn_new_comp_id_container').show();
    })

    $('#btn_new_gov_id').on('click',function(){
      $(this).parent().hide();
      $('#undo_new_gov_btn_container').show();
    })
    $('#undo_new_gov_btn').on('click',function(){
      $(this).parent().hide();
      $('#btn_new_gov_id_container').show();
    })
    var salutaion_val = "<?php echo $acc_data[0]['salutation'] ?>";
    $("#salutation_id").val(salutaion_val).find("option[value=" + salutaion_val +"]").attr('selected', true);
    $("#est_registration").validate({
     rules: {
       first_name: "required",
       last_name: "required",
       position: "required",
       contact_no: "required",
       salutation: "required",
       region: "required",
       password:{
         minlength: 5,
         required:true,
       },
       verify_password:{
          equalTo: "#password",
       },
     },
     messages:{
        first_name:     "Specify your first name",
        last_name:      "Specify your last name",
        position:       "Specify your company position",
        contact_no:     "Specify your contact number",
        salutation:     "Specify your salutation",
        region:         "Specify your region",
        password:{
          required:      "Specify  your password",
          minlength:     jQuery.validator.format("At least {0} characters required!")
        },
        verify_password: " Enter Confirm Password Same as Password"

     },

    });

    // for dropzone

  })

</script>

<?php if ($this->session->flashdata('update_est_msg')): ?>
<script type="text/javascript">
 $(document).ready(function() {
   Swal.fire({
     title: 'Updated successfully',
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

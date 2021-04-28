


<div id="content-wrapper" class="d-flex flex-column" >
  <div id="overlay" style="margin:auto">
       <img src="<?php echo base_url(); ?>assets/images/embloader.gif" alt="Loading" />
       Loading...
  </div>
      <!-- Main Content -->
<div id="content">

        <!-- Topbar -->
 <div class="container">
   <h1 class="h6 mb-4 text-gray-600" style="text-decoration: underline;display:contents">ADD ESTABLISHMENT |</h1>
   <a target="_blank" href="<?= base_url()?>uploads/STEPS ON HOW TO USE COMPANY REGISTRATION SYSTEM FOR CLIENT - UPD.pdf">USER MANUAL <i class="fa fa-book" aria-hidden="true"></i></a>

    <div class="card o-hidden border-0 shadow-lg my-4">
      <div class="card-body p-0">
        <div class="row">
          <div class="col-lg-12">
            <div class="p-5">
                <div id="new_est_container">
                <form class="user" id="add_new_establishment_id" action="<?php echo base_url(); ?>Establishment/update_establishment" method="post" enctype="multipart/form-data">
                    <input type="hidden" class="form-control" name="company_id" value="<?= $this->encrypt->encode($est_data_by_id[0]['company_id']); ?>" readonly>
                  <div class="row">
                    <h2 class="est-title-cont"><span class="est-text-title">COMPANY DETAILS</span></h2>
                    <!-- <span class="text-center" style="color:red;font-size: 15px;padding-left: 5px;">Note: Not the head office address</span> -->
                  </div>
                  <span>EMBID:</span>
                  <input type="text" class="form-control" name="emb_id" value="<?= $est_data_by_id[0]['emb_id'] ?>" readonly>
                  <hr>
                  <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                      <span>MAIN</span>
                          <?php if ($est_data_by_id[0]['company_type'] == $est_data_by_id[0]['company_id'] ): ?>
                            <input type="radio" name="est-type" value="main" checked><br>
                          <?php else: ?>
                            <input type="radio" name="est-type" value="main" ><br>
                          <?php endif; ?>
                      <span>If your establishment is a mother company.</span>
                    </div>
                    <div class="col-sm-6">
                        <span>BRANCH</span>
                        <?php if ($est_data_by_id[0]['company_type'] != $est_data_by_id[0]['company_id'] ): ?>
                          <input type="radio" name="est-type" value="branch" checked><br>
                          <?php else: ?>
                            <input type="radio" name="est-type" value="branch" ><br>
                      <?php endif; ?>
                      <span>If your establishment is under a mother company.</span>
                    </div>
                  </div>
                  <!-- hide this if main company is check -->
                  <div class="form-group row" style="display:none" id="slc-mother-est">
                    <div class="col-sm-12 mb-3 mb-sm-0">
                      <select class="form-control" name="main_company_id" id="main_company_id" onchange="Crs.select_main(this.value)">
                          <option value="">SELECT YOUR MOTHER COMPANY</option>
                        <?php foreach ($all_establishment = all_companies() as $key => $estpval): ?>
                          <?php if ($estpval['company_id'] == $est_data_by_id[0]['company_type']): ?>
                              <option value="<?= $estpval['company_id']?>" selected><?= $estpval['company_name']?></option>
                              <?php else: ?>
                                  <option value="<?= $estpval['company_id']?>"><?= $estpval['company_name']?></option>
                          <?php endif; ?>

                        <?php endforeach; ?>
                      </select>
                    </div>

                      <div class="col-sm-12 mb-3 mb-sm-0">
                        <div class="row" id="mother_company_data" style="display:none;margin-top: 11px;">
                        <!-- <div class="row" id="mother_company_data" > -->
                        <h2 class="est-title-cont"><span class="est-text-title">MOTHER COMPANY ADDRESS</span></h2>
                        <div class="col-xl-12 mb-3">
                          <div class="form-group row">
                            <div class="col-xl-6">
                              <h7 class="">REGION: <span style="color:black;font-weight: 600;" id="mother_company_data_region">R7</span> </h7>
                            </div>
                            <div class="col-xl-6">
                              <h7 class=""> PROVINCE: <span style="color:black;font-weight: 600;" id="mother_company_data_province">R7</span></h7>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-12 mb-3">
                          <div class="form-group row">
                            <div class="col-xl-6">
                              <h7 class="">CITY: <span style="color:black;font-weight: 600;" id="mother_company_data_city">R7</span></h7>
                            </div>
                            <div class="col-xl-6">
                              <h7 class=""> BARANGAY: <span style="color:black;font-weight: 600;" id="mother_company_data_brgy">R7</span></h7>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-12 mb-3" style="display:none" id="mother_company_street_container">
                          <h7 class="">STREET: <span style="color:black;font-weight: 600;" id="mother_company_street">Street</span></h7>
                        </div>
                      </div>
                      </div>

                  </div>


                  <!-- hide this if main company is check  end-->

                  <div class="form-group row">
                    <div class="col-sm-12 mb-3 mb-sm-0">
                      <input type="text" name="establishment" class="form-control form-control-user" id="exampleEstablishment" placeholder="Name of Establishment/Facility" value="<?= $est_data_by_id[0]['company_name']?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-12 mb-3 mb-sm-0">
                      <select class="form-control" name="project_type"  id="select_project_type_id">
                        <option value="" selected disabled>SELECT PROJECT TYPE</option>
                        <?php
                        foreach ($project_type_data as $key => $ptval): ?>
                          <?php if ($ptval['header'] === '1'): ?>
                            <optgroup label="<?php echo $ptval['prj'] ?>">
                              <?php $display='none'; ?>
                            <?php else: ?>
                              <?php $display='block'; ?>
                          <?php endif; ?>
                          <?php if ($ptval['chap'] == '0') {
                                  $ptval['chap'] = ' ';
                                } if ($ptval['part'] == '0') {
                                  $ptval['part'] = ' ';
                                } if ($ptval['branch'] == '0') {
                                  $ptval['branch'] = ' ';
                                }; ?>

                                <?php if ($ptval['header'] === '1'): ?>
                                  <?php else: ?>
                                      <?php if ($ptval['proid'] == $est_data_by_id[0]['project_type']): ?>
                                        <option style = 'display:<?php echo $display?>' value="<?php echo $ptval['proid']?>" selected>
                                          <?php echo $ptval['base'].'.'.$ptval['chap'].'.'.$ptval['part'].'.'.$ptval['branch'].'-'.$ptval['prj']; ?></option>
                                        <?php else: ?>
                                          <option style = 'display:<?php echo $display?>' value="<?php echo $ptval['proid']?>">
                                            <?php echo $ptval['base'].'.'.$ptval['chap'].'.'.$ptval['part'].'.'.$ptval['branch'].'-'.$ptval['prj']; ?></option>
                                      <?php endif; ?>
                                <?php endif; ?>

                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-xl-12 mb-3">
                    <div class="form-group row">
                        <div class="col-xl-6">
                          <input type="number" name="comp_tel" value="<?= $est_data_by_id[0]['contact_no'] ?>" class="form-control form-control-user" placeholder="Company Telephone Number">
                        </div>
                        <div class="col-xl-6">
                          <input type="emial" name="comp_email" value="<?= $est_data_by_id[0]['email'] ?>" class="form-control form-control-user" placeholder="Company Email Address">
                        </div>
                    </div>
                  </div>

                  <div class="row">
                    <h2 class="est-title-cont"><span class="est-text-title">Establishment/Facility Address</span></h2>
                    <!-- <span class="text-center" style="color:red;font-size: 15px;padding-left: 5px;">Note: Not the head office address</span> -->
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-12 mb-3 mb-sm-0">
                      <input type="text" name="est_street" class="form-control form-control-user" id="" placeholder="Street # & Street Name:" value="<?= $est_data_by_id[0]['street']?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                      <div class="">Region</div>
                      <select class="form-control" name="est_region" onchange="Crs.est_region(this.value)" id='est_region_id'>
                        <option value="">SELECT REGION</option>
                        <?php foreach ($regions = regions() as $key => $valreg): ?>
                            <?php if ($est_data_by_id[0]['region_name'] == $valreg['rgnnum']): ?>
                                  <option value="<?= $valreg['rgnid']?>" selected><?= $valreg['rgnnam']?></option>
                                  <?php else: ?>
                                    <option value="<?= $valreg['rgnid']?>"><?= $valreg['rgnnam']?></option>
                            <?php endif; ?>

                          <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <div class="">Provinces <?= $est_data_by_id[0]['region_name'] ?></div>
                      <select class="form-control" name="est_province" id="est_province_id" onchange="Crs.est_province(this.value)">
                        <option value=""> -- </option>
                        <?php   $provinces = province($est_data_by_id[0]['region_name']) ;
                        foreach ($provinces as $key => $valueprov): ?>
                          <?php if ($est_data_by_id[0]['province_id'] == $valueprov['id']): ?>
                                <option value="<?= $valueprov['id']?>" selected><?= $valueprov['name']?></option>
                                <?php else: ?>
                                  <option value="<?= $valueprov['id']?>"><?= $valueprov['name']?></option>
                          <?php endif; ?>
                        <?php endforeach; ?>
                        <option value=""></option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <div class="">City/Municipality</div>
                      <select class="form-control" name="est_city" id="est_city_id" onchange="Crs.est_city(this.value)">
                        <option value=""> -- </option>
                        <?php   $city = city($est_data_by_id[0]['province_id']) ;
                        foreach ($city as $key => $valcity): ?>
                          <?php if ($est_data_by_id[0]['city_id'] == $valcity['id']): ?>
                                <option value="<?= $valcity['id']?>" selected><?= $valcity['name']?></option>
                                <?php else: ?>
                                  <option value="<?= $valcity['id']?>"><?= $valcity['name']?></option>
                          <?php endif; ?>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="col-sm-6 mb-3 mb-sm-0">
                      <div class="">Barangay</div>
                      <select class="form-control" name="est_barangay" id="est_barangay_id">
                        <option value=""> -- </option>
                        <?php   $baranggay = baranggay($est_data_by_id[0]['city_id']) ;
                        foreach ($baranggay as $key => $valbrgy): ?>
                          <?php if ($est_data_by_id[0]['barangay_id'] == $valbrgy['id']): ?>
                                <option value="<?= $valbrgy['id']?>" selected><?= $valbrgy['name']?></option>
                                <?php else: ?>
                                  <option value="<?= $valbrgy['id']?>"><?= $valbrgy['name']?></option>
                          <?php endif; ?>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="col-sm-6">
                      <input type="text" class="form-control form-control-user" id="" placeholder="10.330183" name="longitude" value="<?= $est_data_by_id[0]['longitude']?>">
                    </div>
                    <div class="col-sm-6">
                      <input type="text" class="form-control form-control-user" id="" placeholder="123.989404" name="latitude" value="<?= $est_data_by_id[0]['latitude']?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-xl-12 mb-3">
                              <a href="https://www.gps-coordinates.net/" class="btn btn-success btn-icon-split" target="_blank">
                                        <span class="icon text-white-50">
                                          <i class="fas fa-map-marker"></i>
                                        </span>
                                        <span class="text">GEO COORDINATES</span>
                                      </a>
                              </div>
                  </div>
                  <div class="row">
                    <h2 class="est-title-cont"><span class="est-text-title">Type of Business/ Industry Classification</span></h2>
                  </div>
                  <div class="form-group row">
                    <div class="col-md-12 mb-3">
                        (Click <a href="https://psa.gov.ph/content/philippine-standard-industrial-classification-psic" target="_blank">here</a>  to search for your PSIC Code/Description) or search in pdf </label><a target="_blank" href="<?= base_url()?>uploads/PSA_PSIC_2009-CODES.pdf"><i class="fa fa-eye" aria-hidden="true"></i></a>
                    </div>
                    <div class="col-sm-12">
                      <div class="">Philippine Standard Industry Classification Code. No.</div>
                      <input type="text" class="form-control form-control-user" id="" placeholder="e.g. 55102" name="psi_code_no" value="<?= $est_data_by_id[0]['psi_code_no']?>">
                    </div>
                    <div class="col-sm-12">
                      <div class="">Philippine Standard Industry Descriptor</div>
                      <input type="text" class="form-control form-control-user" id="" placeholder="e.g. Resort hotels" name="psi_descriptor" value="<?= $est_data_by_id[0]['psi_descriptor']?>">
                    </div>
                  </div>
                  <div class="row">
                    <h2 class="est-title-cont"><span class="est-text-title">CEO/President/Owner</span></h2>
                  </div>

                  <div class="form-group row">
                    <div class="col-sm-6">
                      <input type="text" class="form-control form-control-user" id="" placeholder="First Name" name="ceo_first_name" value="<?= $est_data_by_id[0]['ceo_fname']?>">
                    </div>
                    <div class="col-sm-6">
                      <input type="text" class="form-control form-control-user" id="" placeholder="Last Name" name="ceo_last_name" value="<?= $est_data_by_id[0]['ceo_sname']?>">
                    </div>
                  </div>
                  <!-- qwerty -->
                  <div class="form-group row">
                    <div class="col-sm-6">
                      <input type="text" class="form-control form-control-user" id="" placeholder="Tel #" name="ceo_phone_no" value="<?= $est_data_by_id[0]['ceo_contact_num']?>">
                    </div>
                    <div class="col-sm-6">
                      <input type="text" class="form-control form-control-user" id="" placeholder="Fax #" name="ceo_fax_no" value="<?= $est_data_by_id[0]['ceo_fax_no']?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-12">
                      <input type="email" class="form-control form-control-user" id="" placeholder="Email Address" name="ceo_email" value="<?= $est_data_by_id[0]['ceo_email']?>">
                    </div>
                  </div>
                  <div class="row">
                    <h2 class="est-title-cont"><span class="est-text-title">Plant Manager</span></h2>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-12">
                      <input type="text" class="form-control form-control-user" id="" placeholder="FULL NAME" name="plant_manager" value="<?= $est_data_by_id[0]['plant_manager_name']?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-12">
                      <input type="text" class="form-control form-control-user" id="" placeholder="Certificate of Accreditation No." name="plant_manager_coe" value="<?= $est_data_by_id[0]['plant_manager_coe']?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-12">
                      <input type="email" class="form-control form-control-user" id="" placeholder="Email Address" name="plant_manager_email" value="<?= $est_data_by_id[0]['plant_manager_email']?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-4">
                      <input type="text" class="form-control form-control-user" id="" placeholder="Tel #" name="plant_manager_phone_no" value="<?= $est_data_by_id[0]['plant_manager_tel_num']?>">
                    </div>
                    <div class="col-sm-4">
                      <input type="text" class="form-control form-control-user" id="" placeholder="Fax #" name="plant_manager_fax_no" value="<?= $est_data_by_id[0]['plant_manager_fax_num']?>">
                    </div>
                    <div class="col-sm-4">
                      <input type="text" class="form-control form-control-user" id="" placeholder="Mobile #" name="plant_manager_mobile_no" value="<?= $est_data_by_id[0]['plant_manager_mobile_num']?>">
                    </div>
                  </div>
                  <div class="row">
                    <h2 class="est-title-cont"><span class="est-text-title">Pollution Control Officer</span></h2>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-12">
                      <input type="text" class="form-control form-control-user" id="" placeholder="FULL NAME" name="pollution_officer" value="<?= $est_data_by_id[0]['pco']?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-12">
                      <input type="text" class="form-control form-control-user" id="" placeholder="Certificate of Accreditation No." name="pollution_officer_coa_no" value="<?= $est_data_by_id[0]['pco_coe']?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-12">
                      <input type="email" class="form-control form-control-user" id="" placeholder="Email Address" name="pollution_officer_email" value="<?= $est_data_by_id[0]['pco_email']?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-4">
                      <input type="text" class="form-control form-control-user" id="" placeholder="Tel #" name="pollution_officer_tel_no" value="<?= $est_data_by_id[0]['pco_tel_num']?>">
                    </div>
                    <div class="col-sm-4">
                      <input type="text" class="form-control form-control-user" id="" placeholder="Fax #" name="pollution_officer_fax_no" value="<?= $est_data_by_id[0]['pco_fax_num']?>">
                    </div>
                    <div class="col-sm-4">
                      <input type="text" class="form-control form-control-user" id="" placeholder="Mobile #" name="pollution_officer_mobile_no" value="<?= $est_data_by_id[0]['pco_mobile_num']?>">
                    </div>
                  </div>

                  <div class="row">
                    <h2 class="est-title-cont"><span class="est-text-title">MANAGING HEAD</span></h2>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-12">
                      <input type="text" class="form-control form-control-user" id="" placeholder="FULL NAME" name="managing_head" value="<?= $est_data_by_id[0]['managing_head']?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-12">
                      <input type="email" class="form-control form-control-user" id="" placeholder="Email Address" name="managing_head_email" value="<?= $est_data_by_id[0]['managing_head_email']?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-4">
                      <input type="text" class="form-control form-control-user" id="" placeholder="Tel #" name="managing_head_tel_no" value="<?= $est_data_by_id[0]['managing_head_tel_no']?>">
                    </div>
                    <div class="col-sm-4">
                      <input type="text" class="form-control form-control-user" id="" placeholder="Fax #" name="managing_head_fax_no" value="<?= $est_data_by_id[0]['managing_head_fax_no']?>">
                    </div>
                    <div class="col-sm-4">
                      <input type="text" class="form-control form-control-user" id="" placeholder="Mobile #" name="managing_head_mobile_no" value="<?= $est_data_by_id[0]['managing_head_mobile_no']?>">
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="col-sm-9">
                      <input id="certified_doc_id" style="width:unset!important" type="checkbox" class="" name="certified_doc" value="" <?= ($est_data_by_id[0]['ceo_last_name'])? 'checked' : ''?> required>
                      <div class="" style=" display: inline-block;">We hereby certify that the above information are true and correct.
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <!-- <button type="submit" class="btn btn-primary btn-user btn-block" name="button">SAVE </button> -->
                      <button type="submit" class="btn btn-primary btn-user btn-block" name="button" id="save_user_data_btn">Save</button>
                      <button type="button" class="btn btn-primary btn-user btn-block buttonload" name="button" disabled style="display:none">  <i class="fa fa-spinner fa-spin"></i>Please Wait</button>

                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
      </div>
  </div>
  <style media="screen">
  input[name="authorization_letter_new_comp"] {
    font-size: 14px !important;
  }
  </style>
  <?php if ($this->session->flashdata('update_establishment_msg') != ''): ?>
  <script type="text/javascript">
   $(document).ready(function() {
     Swal.fire({
       title: 'Establishment has been successfully updated.',
       text: '',  // title:
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
<script type="text/javascript">

function ValidateSingleInput(filename) {
  var ext = filename.value.split('.').pop();
  if (ext != "pdf") {
    alert('UPLOADED FILE IS NOT PDF !');
    filename.value = null;
    return false;
  }
  return true;
};
$(window).on('load',function(){
   // PAGE IS FULLY LOADED
   // FADE OUT YOUR OVERLAYING DIV
   $('#overlay').fadeOut();
});
  $(document).ready(function(e){
      // for authorization letter
    $('#file-input').on('change',function(){
      var ext = $(this).val().split('.').pop();
      if (ext != "pdf") {
        alert('UPLOADED FILE IS NOT PDF !');
        return false;
      }else {
        if ($(this).val() != ''){
          $('#submit_req_btn').attr('disabled',false).show();
          $('#span_error_file').css('color','black').text($(this)[0].files[0].name);
        }else {
          $('#submit_req_btn').attr('disabled',false);
        }
      }
    })


    $('.update_permit').on('click',function(){
      $(this).next().show()
    })

    if ($('#establishment-id').val() == '')
        $('#submit_req_btn').hide();

    var radioValue = $("input[name='est-type']:checked").val();
    if (radioValue == 'main') {
        $('#slc-mother-est').hide();
    }else {
      $('#slc-mother-est').show();
      $('#all_establishment_id-selectized').parent().css({'border-color':'green','border-radius':'20px'});
    }

    $('#establishment-id').selectize();
    $('#all_establishment_id').selectize();
    $('#select_project_type_id').selectize();
    $('#main_company_id').selectize();
    $('#btn-show-all-est').click(function(){
      $('#select_region_id').removeAttr('required');
      $('#select_province_id').removeAttr('required');
    });

    $( "input[name*='est-type']" ).on('click',function(e){
      var est_type = $(this).val();
      if (est_type == 'branch') {
        $('#main_company_id').attr('required','required');
        $('#slc-mother-est').show();
        $('#all_establishment_id-selectized').parent().css({'border-color':'green','border-radius':'20px'});
      }else {
        $('#slc-mother-est').hide();
        $('#main_company_id').removeAttr('required');
      }
    });



    $('#save_user_data_btn').on('click',function(){
      // if($('input:radio[name=system_inquery_smr]').is(':checked') || $('input:radio[name=system_inquery_hwms]').is(':checked')){

         $("#add_new_establishment_id").validate({
           ignore: ':hidden:not([class~=selectized]),:hidden > .selectized, .selectize-control .selectize-input input',
          rules: {
            establishment: "required",
            project_type: "required",
            est_street: "required",
            est_region: "required",
            est_province: "required",
            est_city: "required",
            est_barangay: "required",
            ceo_first_name: "required",
            ceo_last_name: "required",
            ceo_phone_no: "required",
            ceo_fax_no: "required",
            longitude: "required",
            latitude: "required",
          ceo_email: {
           required: true,
           email: true
           }
          },
          messages:{
             establishment:  "Specify establishment name",
             project_type:   "Specify project type",
             est_street:     "Specify street",
             est_region:     "Specify region",
             est_province: "Specify province",
             est_city:     "Specify city",
             est_barangay: "Specify baranggy",
             ceo_first_name: "Specify ceo first name",
             ceo_last_name: "Specify ceo last name",
             ceo_phone_no: "Specify ceo phone #",
             ceo_fax_no: "Specify ceo fax #",
             ceo_email: "Specify ceo email",
             longitude: "Specify correct longitude",
             latitude: "Specify correct latitude",
          },

         });
     // }else {
     //   alert('PLEASE CHOOSE SYSTEM INQUERY');
     //   $('html, body').animate({ scrollTop: 0 }, 'fast');
     //    return false;
     // }
     if ($("#add_new_establishment_id").valid()) {
       $('#save_user_data_btn').hide();
       $('.buttonload').show();
      }

    });


    $('#submit_req_btn').on('click',function(){
      if (!confirm('Is this your establishment ?')) {
        return false;
      }else {
        this.form.submit();
      }
     //  if($('input:radio[name=system_inquery_smr]').is(':checked') || $('input:radio[name=system_inquery_hwms]').is(':checked')){
     // }else {
     //   alert('PLEASE CHOOSE SYSTEM INQUERY');
     //    return false;
     // }

    });

 });
  // function system_inquery_type(){
  //   if ($('input:radio[name=system_inquery_smr]').is(':checked')) {
  //    $('.system_inquery_type_id').val('smr_inquery');
  //   }
  //   if ($('input:radio[name=system_inquery_hwms]').is(':checked')) {
  //    $('.system_inquery_type_id').val('hwms_inquery');
  //   }
  //   if ($('input:radio[name=system_inquery_hwms]').is(':checked') && $('input:radio[name=system_inquery_smr]').is(':checked')) {
  //    $('.system_inquery_type_id').val('hwms_smr_inquery');
  //   }
  // }
</script>

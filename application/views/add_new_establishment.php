<?php  echo $banner;?>
<?php //echo "<pre>";print_r($region_list); ?>
<div id="content-wrapper" class="d-flex flex-column">
  <div id="content">
     <div class="container">
       <?php echo $tabs_menu; ?>
       <div class="card o-hidden border-0 my-4">
         <div class="card-header">
           <h6 class="m-0 font-weight-bold text-primary text-center">ESTABLISHMENT DATA</h6>
         </div>
         <div class="card-body p-0">

         </div>
       </div>
        <?php if ($est_data_by_id[0]['company_id'] != ''): ?>
          <p><span style="color:red">Note:</span> Registered establishment details are for viewing only. Updating of establishment details applicable only after the approval of request due to validation and data protection. Please proceed on the next step. Thank you.</p>
        <?php endif; ?>
           <?php //echo "<pre>";print_r($est_data_by_id); ?>
       <!-- <h2 class="est-title-cont"><span class="est-text-title"></span></h2> -->
       <form class="user" id="add_new_establishment_id" action="<?php echo base_url(); ?>Establishment_/add_establishment_steps/4/<?php echo $this->session->userdata('selected_company'); ?>" method="post" enctype="multipart/form-data">
         <div class="form-group row">
           <div class="col-sm-6 mb-3 mb-sm-0">
             <span>MAIN</span>
             <?php if ($est_data_by_id[0]['company_id'] == $est_data_by_id[0]['company_type']): ?>
               <input type="radio" name="est-type" value="main" checked><br>
             <?php else: ?>
               <?php if ($est_data_by_id[0]['company_type'] == 0): ?>
                 <input type="radio" name="est-type" value="main" checked><br>
                 <?php else: ?>
                  <input type="radio" name="est-type" value="main" ><br>
               <?php endif; ?>
             <?php endif; ?>
             <span>If your establishment is a mother company.</span>
           </div>
           <div class="col-sm-6">
             <span>BRANCH</span>
             <?php if ($est_data_by_id[0]['company_id'] == $est_data_by_id[0]['company_type']): ?>
               <input type="radio" name="est-type" value="branch" ><br>
             <?php else: ?>
               <?php if ($est_data_by_id[0]['company_type'] == 0): ?>
                 <input type="radio" name="est-type" value="branch" ><br>
                 <?php else: ?>
                   <input type="radio" name="est-type" value="branch" checked><br>
               <?php endif; ?>
             <?php endif; ?>
             <span>If your establishment is under a mother company.</span>
           </div>
         </div>
         <!-- hide this if main company is check -->
         <?php //echo "<pre>";print_r($est_data_by_id); ?>
         <div class="form-group row" style="display:none" id="slc-mother-est">
           <div class="branch_comp col-xl-12 mb-3">
             <hr>
             <div class="row">
               <div class="col-xl-11">
                 <div class="h6 mb-0 font-weight-bold text-gray-800">Main Company: <span class="error_req">( required )</div>
                   <input readonly type="text" name="" value="<?=$main_company[0]['company_name']?>" id="add_main_company_name" class="form-control project_name" placeholder="">
                   <input type="hidden" name="main_company_id" value="<?= $main_company[0]['company_id'] ?>" id="add_main_company_id" class="form-control project_name" placeholder="">
                 </div>
                 <div class="col-xl-1">
                   <button type="button" style="margin-top:22px" data-toggle='modal' data-target='#add_main_company_modal' class="btn btn-primary" name="button"><i class="fas fa-pencil-alt"></i></button>
                 </div>
               </div>
               <hr>
             </div>
           </div>
           <!-- hide this if main company is check  end-->
           <div class="form-group row">
             <div class="col-sm-12 mb-3 mb-sm-0">
               <input type="text" name="establishment" class="form-control form-control-user" id="exampleEstablishment" placeholder="Name of Establishment/Facility" value="<?=preg_replace('/\s+/',' ',$est_data_by_id[0]['company_name']);?>">
             </div>
           </div>
           <div class="form-group row">
             <div class="col-sm-12 mb-3 mb-sm-0">
               <select class="form-control" name="project_type"  id="select_project_type_id">
                 <option value="" selected disabled>SELECT PROJECT TYPE</option>
                 <?php foreach ($project_type_data as $key => $ptval): ?>
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
                       <input type="text" name="comp_tel" value="<?= $est_data_by_id[0]['contact_no'] ?>" class="form-control form-control-user" placeholder="Company Telephone Number" required>
                     </div>
                     <div class="col-xl-6">
                       <input type="email" name="comp_email" value="<?= $est_data_by_id[0]['email'] ?>" class="form-control form-control-user" placeholder="Company Email Address">
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
                       <?php foreach ($region_list as $key => $valreg): ?>
                         <?php if ($est_data_by_id[0]['region_name'] == $valreg['rgnnum']): ?>
                           <option value="<?= $valreg['rgnid']?>" selected><?= $valreg['rgnnam']?></option>
                         <?php else: ?>
                           <option value="<?= $valreg['rgnid']?>"><?= $valreg['rgnnam']?></option>
                         <?php endif; ?>

                       <?php endforeach; ?>
                     </select>
                   </div>
                   <div class="col-sm-6 mb-3 mb-sm-0">
                     <div class="">Province</div>
                     <select class="form-control" name="est_province" id="est_province_id" onchange="Crs.est_province(this.value)">
                       <option value=""> -- </option>
                       <option value=""></option>
                     </select>
                   </div>
                 </div>
                 <div class="form-group row">
                   <div class="col-sm-6 mb-3 mb-sm-0">
                     <div class="">City/Municipality</div>
                     <select class="form-control" name="est_city" id="est_city_id" onchange="Crs.est_city(this.value)">
                       <option value=""> -- </option>
                       <option value=""></option>
                     </select>
                   </div>
                   <div class="col-sm-6 mb-3 mb-sm-0">
                     <div class="">Barangay</div>
                     <select class="form-control" name="est_barangay" id="est_barangay_id">
                       <option value=""> -- </option>
                       <option value=""></option>
                     </select>
                   </div>
                 </div>

                 <div class="form-group row">
                   <div class="col-sm-6">
                     <div class="">Latitude</div>
                     <input type="text" class="form-control form-control-user" id="txtLat" placeholder="10.3349698" name="latitude" value="<?= $est_data_by_id[0]['latitude']?>">
                   </div>
                   <div class="col-sm-6">
                     <div class="">Longitude</div>
                     <input type="text" class="form-control form-control-user" id="txtLon" placeholder="123.98613809999999" name="longitude" value="<?= $est_data_by_id[0]['longitude']?>">
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
                     <input type="text" class="form-control form-control-user" id="" placeholder="Certificate of Accreditation No." name="plant_manager_coa_no" value="<?= $est_data_by_id[0]['plant_manager_coe']?>">
                   </div>
                 </div>
                 <div class="form-group row">
                   <div class="col-sm-12">
                     <input type="email" class="form-control form-control-user" id="" placeholder="Email Address" name="plant_manager_email" value="<?= $est_data_by_id[0]['plant_manager_email']?>">
                   </div>
                 </div>
                 <div class="form-group row">
                   <div class="col-sm-4">
                     <input type="text" class="form-control form-control-user" id="" placeholder="Tel #" name="plant_manager_phone_no" value="<?= $est_data_by_id[0]['plant_manager_phone_no']?>">
                   </div>
                   <div class="col-sm-4">
                     <input type="text" class="form-control form-control-user" id="" placeholder="Fax #" name="plant_manager_fax_no" value="<?= $est_data_by_id[0]['plant_manager_fax_no']?>">
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
                     <input type="text" class="form-control form-control-user" id="" placeholder="Certificate of Accreditation No." name="pollution_officer_coa_no" value="<?=$est_data_by_id[0]['pco_coe']?>">
                   </div>
                 </div>
                 <div class="form-group row">
                   <div class="col-sm-12">
                     <input type="email" class="form-control form-control-user" id="" placeholder="Email Address" name="pollution_officer_email" value="<?= $est_data_by_id[0]['pco_email']?>">
                   </div>
                 </div>
                 <div class="form-group row">
                   <div class="col-sm-4">
                     <input type="text" class="form-control form-control-user" id="" placeholder="Tel #" name="pollution_officer_phone_no" value="<?= $est_data_by_id[0]['pco_tel_num']?>">
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
                 <hr>
                 <?php if (empty($company_id) || $company_id == ''): ?>

                      <div class="row">
                        <h2 class="est-title-cont"><span class="est-text-title">PERMITS</span></h2>
                      </div>
                       <div class="form-group row">
                         <div class="col-md-12 text-center mb-3">
                           <h7 style="font-weight: bold;">Discharge Permit (DP)</h7>
                         </div>
                           <div class="col-sm-3" style="text-align:center">
                             <span for="">APPLICABLE</span>
                             <input type="radio" class="" name="dp_status" value="1" checked>
                           </div>
                           <div class="col-sm-3" style="text-align:center">
                               <span for="">ON-PROCESS</span>
                             <input type="radio" class="" name="dp_status" value="2">
                           </div>
                           <div class="col-sm-3" style="text-align:center">
                             <span for="">NONE</span>
                             <input type="radio" class="" name="dp_status" value="3">
                           </div>
                           <div class="col-sm-3" style="text-align:center">
                             <span for="">NOT APPLICABLE</span>
                             <input type="radio" class="" name="dp_status" value="4">
                           </div>
                       </div>
                       <div class="form-group row dp_section-row">
                         <div class="col-md-1"></div>
                         <div class="col-md-8"><input type="text" class="form-control" name="dp_no[]" value="" placeholder="DP NO." required></div>
                         <div class="col-md-3"><input type="file" class="" name="dp_no_file[]" value="" required></div>
                       </div>
                       <div class="form-group row dp_section">
                         <!-- <div class="col-md-1">

                         </div> -->
                         <div class="col-md-11"></div>

                         <div class="col-md-1" style="display:contents">
                              <button type="button" style="float:left" class="dp_btn_rmv btn-danger"><i class="fa fa-remove" aria-hidden="true"></i></button>
                           <button type="button" id="dp_btn" name="button" style="float:right" class="btn-primary"><i class="fa fa-plus" aria-hidden="true" ></i></button>
                         </div>
                       </div>
                       <hr>
                       <div class="form-group row">
                        <div class="col-md-12 text-center mb-3">
                           <h7 style="font-weight: bold;">Certificate of Non-Coverage (CNC)</h7>

                         </div>
                           <div class="col-sm-3" style="text-align:center">
                             <span for="">APPLICABLE</span>
                             <input type="radio" class="" name="cnc_status" value="1" checked>
                           </div>
                           <div class="col-sm-3" style="text-align:center">
                               <span for="">ON-PROCESS</span>
                             <input type="radio" class="" name="cnc_status" value="2">
                           </div>
                           <div class="col-sm-3" style="text-align:center">
                             <span for="">NONE</span>
                             <input type="radio" class="" name="cnc_status" value="3">
                           </div>
                           <div class="col-sm-3" style="text-align:center">
                             <span for="">NOT APPLICABLE</span>
                             <input type="radio" class="" name="cnc_status" value="4">
                           </div>
                       </div>
                       <div class="form-group row cnc_section-row">
                         <div class="col-md-1"></div>
                         <div class="col-md-8"><input type="text" class="form-control" name="cnc_no[]" value="" placeholder="CNC NO." required></div>
                         <div class="col-md-3"><input type="file" name="cnc_no_file[]" required></div>
                       </div>
                       <div class="form-group row cnc_section">
                         <div class="col-md-11">

                         </div>
                        <div class="col-md-1" style="display:contents">
                           <button type="button" style="float:left" class="cnc_btn_rmv btn-danger"><i class="fa fa-remove" aria-hidden="true"></i></button>
                           <button type="button"  id="cnc_btn" name="button" style="float:right" class="btn-primary"><i class="fa fa-plus" aria-hidden="true"></i></button>
                         </div>
                       </div>
                       <hr>
                       <div class="form-group row">
                           <div class="col-md-12 text-center mb-3">
                           <h7 style="font-weight: bold;">Environmental Compliance Certificate (ECC)</h7>

                         </div>
                           <div class="col-sm-3" style="text-align:center">
                             <span for="">APPLICABLE</span>
                             <input type="radio" class="" name="ecc_status" value="1" checked>
                           </div>
                           <div class="col-sm-3" style="text-align:center">
                               <span for="">ON-PROCESS</span>
                             <input type="radio" class="" name="ecc_status" value="2">
                           </div>
                           <div class="col-sm-3" style="text-align:center">
                             <span for="">NONE</span>
                             <input type="radio" class="" name="ecc_status" value="3">
                           </div>
                           <div class="col-sm-3" style="text-align:center">
                             <span for="">NOT APPLICABLE</span>
                             <input type="radio" class="" name="ecc_status" value="4">
                           </div>
                       </div>
                       <div class="form-group row ecc_section-row">
                         <div class="col-md-1"></div>
                         <div class="col-md-8"><input type="text" class="form-control" name="ecc_no[]" value="" placeholder="ECC NO." required></div>
                         <div class="col-md-3"><input type="file" class="" name="ecc_no_file[]" value="" required></div>
                       </div>
                       <div class="form-group row ecc_section">
                         <div class="col-md-11">

                         </div>
                         <div class="col-md-1" style="display:contents">
                            <button type="button" style="float:left" class="ecc_btn_rmv btn-danger"><i class="fa fa-remove" aria-hidden="true" ></i></button>
                           <button type="button" id="ecc_btn" name="button" style="float:right" class="btn-primary"><i class="fa fa-plus" aria-hidden="true" ></i></button>
                         </div>
                       </div>
                       <hr>
                       <div class="form-group row">
                          <div class="col-md-12 text-center mb-3">
                           <h7 style="font-weight: bold;">Permit to Operate (PO)</h7>
                         </div>
                           <div class="col-sm-3" style="text-align:center">
                             <span for="">APPLICABLE</span>
                             <input type="radio" class="" name="po_status" value="1" checked>
                           </div>
                           <div class="col-sm-3" style="text-align:center">
                               <span for="">ON-PROCESS</span>
                             <input type="radio" class="" name="po_status" value="2">
                           </div>
                           <div class="col-sm-3" style="text-align:center">
                             <span for="">NONE</span>
                             <input type="radio" class="" name="po_status" value="3">
                           </div>
                           <div class="col-sm-3" style="text-align:center">
                             <span for="">NOT APPLICABLE</span>
                             <input type="radio" class="" name="po_status" value="4">
                           </div>
                       </div>
                       <div class="form-group row po_section-row">
                         <div class="col-md-1"></div>
                         <div class="col-md-8"><input type="text" class="form-control" name="po_no" value="" placeholder="PO NO." required></div>
                         <div class="col-md-3"><input type="file" name="po_no_file[]" required></div>
                       </div>
                 <?php endif; ?>

                  <div class="row">
                    <h2 class="est-title-cont"><span class="est-text-title">AUTHORIZATION LETTER</span></h2>
                  </div>
                     <div class="form-group row">
                       <div class="col-md-10">
                          <span><h7 style="color:red">Note:</h7>
                            <p> Authorization letter is required from this establishment, you may use this <a href="<?php echo base_url(); ?>/uploads/AUTHORIZATION-Letter-for-CRS.docx">(LETTER)</a> template as reference.</p>
                        </span>
                       </div>
                       <div class="col-md-2">
                            <input type="file" name="authorization_letter_existing_comp" id="authorization_letter_file" onchange="ValidateSingleInput(this);" required/>
                       </div>

                    </div>
                    <hr>
                 <div class="form-group row">
                   <div class="col-sm-3">
                        <button type="button" onclick="goBack()" class="btn btn-primary btn-user btn-block" value="1" id="previous-page">PREVIOUS</button>
                   </div>
                   <div class="col-sm-6">
                   </div>

                   <div class="col-sm-3">
                     <!-- <button type="submit" class="btn btn-primary btn-user btn-block" name="button">SAVE </button> -->
                     <button type="submit" class="btn btn-primary btn-user btn-block" name="button" id="save_user_data_btn">NEXT</button>
                     <button type="button" class="btn btn-primary btn-user btn-block buttonload" name="button" disabled style="display:none">  <i class="fa fa-spinner fa-spin"></i>Please Wait</button>

                   </div>
                 </div>
        </form>
     </div>
   </div>
 </div>
 <div class="modal fade" id="add_main_company_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" style="z-index:99999">
   <div class="modal-dialog modal-lg" role="document" style="max-width: 1000px!important;">
     <div class="modal-content">
       <div class="modal-header" style="background-color:#018E7F;">
         <h7 class="modal-title" style="color:#FFF;" id="useraccountsModalLabel">MAIN COMPANY - Check the checkbox to add main company.</h7>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#FFF;">
           <span aria-hidden="true">&times;</span>
         </button>
       </div>
       <div class="modal-body">
         <div class="col-xl-12 mb-3">
           <div class="row">
               <div class="col-md-6">

               </div>
               <div class="col-md-6">

                 <select class="form-control" name="" id="add_sort_by_company_region" style="float:right">
                   <option value="">--SEARCH REGION--</option>
                   <?php foreach ($region_list as $key => $rgnval): ?>
                     <option value="<?php echo $rgnval['rgnnum']; ?>" ><?php echo $rgnval['rgnnam']; ?></option>
                   <?php endforeach; ?>
                 </select>
               </div>
           </div>
         </div>
         <div class="table-responsive" style="margin-top: 10px;">
           <table class="table table-hover" id="add_main_company_list" width="100%" cellspacing="0">
             <thead>
               <tr>
                 <!-- <th><input type="checkbox" name="select_all" value="1" id="example-select-all"></th> -->
                 <td></td>
                 <th>Emb Id</th>
                 <th>Company Name</th>
                 <th>Location</th>
               </tr>
             </thead>
             <tbody>
             </tbody>
           </table>
         </div>

       </div>
       <div class="modal-footer">
         <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
       </div>
     </div>
   </div>
 </div>

 <?php if($this->session->flashdata('client_request_est_msg')): ?>

 <script type="text/javascript">
  $(document).ready(function() {
    Swal.fire({
      title: 'Establishment has been successfully save.',
      text: 'We will send the request status to your registered email. <?php echo $_SESSION['email']; ?> after EMB Evaluation / Verification.Thank you',  // title:
      imageUrl: '<?php echo base_url(); ?>assets/images/logo.png',
      imageWidth: 135,
      imageHeight: 50,
      imageAlt: 'Custom image',
    });
  });
 </script>
 <?php endif; ?>

<script type="text/javascript">
function goBack() {
  var prev_url = '<?=base_url()?>/Establishment_/add_establishment_steps/2/<?=$this->session->userdata('selected_company')?>';
    window.location.replace(prev_url);
}
// for authorization letter
function ValidateSingleInput(filename) {
     if (filename.length > 0) {
       $('#save_user_data_btn').attr('disabled',false);
     }else {
       var ext = filename.value.split('.').pop();
       if (ext != "pdf") {
         alert('UPLOADED FILE IS NOT PDF !');
         filename.value = null;
          $('#save_user_data_btn').attr('disabled',true);
         return false;
       }
       $('#save_user_data_btn').attr('disabled',false);
       return true;
     }

   };

 $(document).ready(function(e){
   // for Discharge permit
   $("input[name='dp_status']").on('click',function(){
     if ($(this).val() == 1) {
       $(".dp_section-row :input").prop("required", true);
       $('.dp_section-row').show();
       $('.dp_section').show();
     }else {
       $(".dp_section-row :input").prop("required", false);
       $('.dp_section-row').hide();
       $('.dp_section').hide();
     }
   })
   $dprow = $('.dp_section-row').clone();
   $('#dp_btn').click(function(){
      $dprow.clone().insertBefore($('.dp_section'));
   });
   $('.dp_btn_rmv').on('click',function(){
     $(this).parent().parent().prev().remove();
   });

   // for cnc to operate
   $("input[name='cnc_status']").on('click',function(){
     if ($(this).val() == 1) {
       $(".cnc_section-row :input").prop("required", true);
       $('.cnc_section-row').show();
       $('.cnc_section').show();
     }else {
       $(".cnc_section-row :input").prop("required", false);
       $('.cnc_section-row').hide();
       $('.cnc_section').hide();
     }
   })

   $cnc = $('.cnc_section-row').clone();
   $('#cnc_btn').click(function(){
      $cnc.clone().insertBefore($('.cnc_section'));
   });
   $('.cnc_btn_rmv').on('click',function(){
     $(this).parent().parent().prev().remove();
   });

   // for ecc
   $("input[name='ecc_status']").on('click',function(){
     if ($(this).val() == 1) {
        $(".ecc_section-row :input").prop("required", true);
       $('.ecc_section-row').show();
       $('.ecc_section').show();
     }else {
       $(".ecc_section-row :input").prop("required", false);
       $('.ecc_section-row').hide();
       $('.ecc_section').hide();
     }
   })

   // for po
   // for cnc to operate
   $("input[name='po_status']").on('click',function(){
     if ($(this).val() == 1) {
       $(".po_section-row :input").prop("required", true);
       $('.po_section-row').show();
       $('.po_section').show();
     }else {
       $(".po_section-row :input").prop("required", false);
       $('.po_section-row').hide();
       $('.po_section').hide();
     }
   })

   $ecc = $('.ecc_section-row').clone();
   $('#ecc_btn').click(function(){
      $ecc.clone().insertBefore($('.ecc_section'));
   });
   $('.ecc_btn_rmv').on('click',function(){
     $(this).parent().parent().prev().remove();
   });



   var prov_val = "<?php echo  $est_data_by_id[0]['province_id'] ?>";
   var reg_val = "<?php echo  $region_id[0]['rgnid'] ?>";
   var city_id = "<?php echo  $est_data_by_id[0]['city_id'] ?>";
   var brgy_id = "<?php echo  $est_data_by_id[0]['barangay_id'] ?>";
   // var est_city_id =
   var static_b_url =  '<?php echo  base_url() ?>';
    $.ajax({
      url: static_b_url + 'Establishment_/select_region',
      type: 'POST',
      data: {ext_region:reg_val},
      success:function(response)
        {
          $('#est_province_id').html(response);
          if (prov_val != '')
            $("#est_province_id").val(prov_val).find("option[value=" + prov_val +"]").attr('selected', true);
        }
    });
    // for province
    $.ajax({
      url: static_b_url + 'Establishment_/select_province',
      type: 'POST',
      data: {est_province_id:prov_val},
      success:function(response)
        {
          $('#est_city_id').html(response);
          $('#est_barangay_id option').remove();

          if (city_id != '')
           $("#est_city_id").val(city_id).find("option[value=" + city_id +"]").attr('selected', true);
        }
    });

    $.ajax({
      url: static_b_url + 'Establishment_/select_city',
      type: 'POST',
      data: {est_city_id:city_id},
      success:function(response)
        {
          $('#est_barangay_id').html(response);
         if (brgy_id != '')
           $("#est_barangay_id").val(brgy_id).find("option[value=" + brgy_id +"]").attr('selected', true);
        }
    });



   var radioValue = $("input[name='est-type']:checked").val();
   if (radioValue == 'main') {
       $('#slc-mother-est').hide();
   }else {
     $('#slc-mother-est').show();
   }
   $('#all_establishment_id').selectize();
   $('#select_project_type_id').selectize();
   $('#main_company_id').selectize();
   $( "input[name*='est-type']" ).on('click',function(e){
     var est_type = $(this).val();
     if (est_type == 'branch') {
       $('#slc-mother-est').show();
       $('#add_main_company_name').attr('required','required');
     }else {
       $('#slc-mother-est').hide();
       $('#add_main_company_name').attr('required',false);
     }
   });
   var company_id = '<?= $est_data_by_id[0]['company_id'] ?>'
  if (company_id != '') {
    var select = $("#select_project_type_id").selectize();
      var selectize = select[0].selectize;
      selectize.disable();
     $("#add_new_establishment_id input").attr("readonly", 'readonly');
     $("#add_new_establishment_id select").attr('readonly','readonly');
     $("#add_new_establishment_id input:radio").attr('disabled',true);
     $('#authorization_letter_file').attr("disabled",false);
     $('#authorization_letter_file').attr("readonly",false);
     $('#btn-crs-4').attr('disabled', true);
  }else {

    $.validator.addMethod('latCoord', function(value, element) {
      return this.optional(element) ||
      value.length >= 4 && /^(?=.)-?((8[0-5]?)|([0-7]?[0-9]))?(?:\.[0-9]{1,20})?$/.test(value);
    }, 'Your Latitude format has error.')

    $.validator.addMethod('longCoord', function(value, element) {
      return this.optional(element) ||
      value.length >= 4 && /^(?=.)-?((0?[8-9][0-9])|180|([0-1]?[0-7]?[0-9]))?(?:\.[0-9]{1,20})?$/.test(value);
    }, 'Your Longitude format has error.')

    $('#save_user_data_btn').on('click',function(){
            $("#add_new_establishment_id").validate({
              ignore: ':hidden:not([class~=selectized]),:hidden > .selectized, .selectize-control .selectize-input input',
             rules: {
               "dp_no[]": "required",
               "dp_no_file[]": "required",
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
               // longitude: "required",
               latitude: {
                required: true,
                latCoord: true
              },
              longitude: {
                required: true,
                longCoord: true
              },
               // latitude: "required",
               managing_head: "required",
               managing_head_email: "required",
               managing_head_tel_no: "required",
               managing_head_fax_no: "required",
               managing_head_mobile_no: "required",
               ceo_email: {
               required: true,
               email: true
              },
              comp_email: {
               required: true,
               email: true
             },
               },
             messages:{
               "dp_no[]": "This field is required",
               "dp_no_file[]": "This field is required",
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
                // longitude: "Specify correct longitude",
                // latitude: "Specify correct latitude",
                managing_head: "Specify correct managing head",
                managing_head_email: "Specify correct email",
                managing_head_tel_no: "Specify correct telephone number",
                managing_head_fax_no: "Specify correct fax number",
                managing_head_mobile_no: "Specify correct mobile number",
                ceo_email: "Specify company email",
             },

            });

          if ($("#add_new_establishment_id").valid()) {
            $('#save_user_data_btn').hide();
            $('.buttonload').show();
         }

    });


  }


});
</script>
<script type="text/javascript">
// $('#add_sort_by_company_id').selectize();
$(document).ready(function(){

 var selected_main_company_id = $('#add_main_company_id').val();
   initDatatable();
});
$('#add_sort_by_company_region').on('change',function(){
 initDatatable($(this).val());
})
function initDatatable(region){
 var table = $('#add_main_company_list').DataTable({
   responsive: true,
   orderFixed: [ 0, 'asc' ],
   paging: true,
   destroy:true,
   deferRender: true,
   lengthMenu:[[ 5,10, 25, 50, -1],[ 5,10, 25, 50, "ALL"]],
   pageLength: 5,

   "serverSide": true,
   "ajax": {
     "url": "<?php echo base_url(); ?>Serverside/add_main_company_list",
     "data": {
       "region": region
     }
   },
   "columns": [
     { "data": null, defaultContent: '' },
     { "data": "emb_id","searchable": true},
     { "data": "company_name","searchable": true},
     { "data": 'province_name',"searchable": false},
   ],
   'columnDefs': [{
        'targets': 0,
        'searchable': false,
        'orderable': false,
        'className': 'dt-body-center',
        'render': function (data, type, full, meta){

            return '<input type="checkbox" class="add_main_company_class" name="" value="'+data.company_id+'" onclick="Crs.add_main_company('+data.company_id+')">';
        }
     }],
     'order': [[1, 'asc']]
 });
}

</script>

<div id="content-wrapper" class="d-flex flex-column">
<!-- Main Content -->
  <div id="content">

  <!-- Topbar -->
    <div class="container">
      <div class="row">
        <h2 class="est-title-cont"><span class="est-text-title">PERMIT PER ESTABLISHMENT (APPROVED)</span></h2>
      </div>
      <?php foreach ($establishment as $key => $estval): ?>
        <div id="#accordion" class="col-md-12 btn btn-default btn-sm collapsed" type="button" data-toggle="collapse" data-target="#multiCollapseExample<?=$estval['req_id']?>" aria-expanded="false" aria-controls="multiCollapseExample<?=$estval['req_id']?>" style="color:#FFF;background-color:#535F6F;margin-bottom: 10px;" onClick="Crs.view_apr_company_permits(<?=$estval['req_id']?>,this)">
          <?=$estval['company_name']?>
        </div><br>
        <div class="row">
          <div class="col">
            <div class="collapse multi-collapse" id="multiCollapseExample<?=$estval['req_id']?>">
              <div class="col-md-12 mb-3 text-center">
                <h7 style="font-weight: bold;">Discharge Permit (DP)</h7>
              </div>
                <!-- <div class="form-group row dp_section-options">
                    <div class="col-sm-3" style="text-align:center">
                      <span for="">APPLICABLE</span>
                      <input type="radio" class="form-control" name="dp_status" value="1" >
                    </div>
                    <div class="col-sm-3" style="text-align:center">
                        <span for="">ON-PROCESS</span>
                      <input type="radio" class="form-control" name="dp_status" value="2">
                    </div>
                    <div class="col-sm-3" style="text-align:center">
                      <span for="">NONE</span>
                      <input type="radio" class="form-control" name="dp_status" value="3">
                    </div>
                    <div class="col-sm-3" style="text-align:center">
                      <span for="">NOT APPLICABLE</span>
                      <input type="radio" class="form-control" name="dp_status" value="4">
                    </div>
                </div> -->
                      <div class="multiple_dp_permits_data"></div>
                     <div class="form-group row dp_section-row<?=$estval['req_id']?>">
                       <input type="hidden" name="upload_req_id" value="<?=$estval['req_id']?>" id="upload_new_req_id">
                       <div class="col-md-9"><input type="text" class="form-control" name="dp_no" value="" placeholder="DP NO." ></div>
                       <div class="col-md-2"><input type="file" value="" id="uploadpermitnewdp" class="uploadpermitnewdp"></div>
                        <div class="col-md-1">
                          <button type="button" name="button" class="btn-primary" onClick="Crs.upload_new_attachment_apr_est('1',this)"><i class="fa fa-upload" aria-hidden="true"></i></button>
                        </div>
                     </div>
                     <div class="form-group row dp_section">

                       <div class="col-md-11"></div>
                       <div class="col-md-2" style="display:contents">
                         <!-- <button type="button" name="button" class="btn-primary dp_btn" value="dp_section-row<?=$estval['req_id']?>" ><i class="fa fa-plus" aria-hidden="true" ></i></button> -->
                         <!-- <button type="button"  class="dp_btn_rmv btn-danger"><i class="fa fa-remove" aria-hidden="true"></i></button> -->

                       </div>
                     </div>

                     <!-- for cnc -->

                            <hr>
                            <div class="col-md-12 mb-3 text-center">
                              <h7 style="font-weight: bold;">Certificate of Non-Coverage (CNC)</h7>
                            </div>
                               <!-- <div class="form-group row cnc_status-options">
                                <div class="col-sm-3" style="text-align:center">
                                  <span for="">APPLICABLE</span>
                                  <input type="radio" class="form-control" name="cnc_status" value="1" >
                                </div>
                                <div class="col-sm-3" style="text-align:center">
                                    <span for="">ON-PROCESS</span>
                                  <input type="radio" class="form-control" name="cnc_status" value="2">
                                </div>
                                <div class="col-sm-3" style="text-align:center">
                                  <span for="">NONE</span>
                                  <input type="radio" class="form-control" name="cnc_status" value="3">
                                </div>
                                <div class="col-sm-3" style="text-align:center">
                                  <span for="">NOT APPLICABLE</span>
                                  <input type="radio" class="form-control" name="cnc_status" value="4">
                                </div>
                            </div> -->

                              <div class="multiple_cnc_permits_data"></div>
                              <div class="form-group row cnc_section-row">
                                <!-- <div class="col-md-1"></div> -->
                                <div class="col-md-9"><input type="text" class="form-control" name="cnc_no" value="" placeholder="CNC NO." required></div>
                                <!-- <div class="col-md-3"><input type="file" name="cnc_no_file[]" required></div> -->
                                <div class="col-md-2"><input type="file" value="" id="uploadpermitnewcnc"></div>
                                <div class="col-md-1"><button type="button" name="button" class="btn-primary" onClick="Crs.upload_new_attachment_apr_est('2',this)"><i class="fa fa-upload" aria-hidden="true"></i></button></div>
                              </div>

                            <!-- <div class="form-group row cnc_section">
                              <div class="col-md-11"></div>
                             <div class="col-md-1" style="display:contents">
                                <button type="button" class="cnc_btn_rmv btn-danger"><i class="fa fa-remove" aria-hidden="true"></i></button>
                                <button type="button"  id="cnc_btn" name="button"  class="btn-primary"><i class="fa fa-plus" aria-hidden="true"></i></button>
                              </div>
                            </div> -->
                            <hr>
                            <!-- for ecc -->
                            <div class="col-md-12 mb-3 text-center">
                              <h7 style="font-weight: bold;">Environmental Compliance Certificate (ECC)</h7>

                            </div>
                               <!-- <div class="form-group row ecc_section-options">
                                   <div class="col-sm-3" style="text-align:center">
                                     <span for="">APPLICABLE</span>
                                     <input type="radio" class="form-control" name="ecc_status" value="1" >
                                   </div>
                                   <div class="col-sm-3" style="text-align:center">
                                       <span for="">ON-PROCESS</span>
                                     <input type="radio" class="form-control" name="ecc_status" value="2">
                                   </div>
                                   <div class="col-sm-3" style="text-align:center">
                                     <span for="">NONE</span>
                                     <input type="radio" class="form-control" name="ecc_status" value="3">
                                   </div>
                                   <div class="col-sm-3" style="text-align:center">
                                     <span for="">NOT APPLICABLE</span>
                                     <input type="radio" class="form-control" name="ecc_status" value="4">
                                   </div>
                               </div> -->

                             <div class="multiple_ecc_permits_data"></div>


                                <div class="form-group row ecc_section-row">
                                  <!-- <div class="col-md-1"></div> -->
                                  <div class="col-md-9"><input type="text" class="form-control" name="ecc_no" value="" placeholder="ECC NO." required></div>
                                  <!-- <div class="col-md-3"><input type="file" class="" name="ecc_no_file[]" value="" required></div> -->
                                  <div class="col-md-2"><input type="file" value="" id="uploadpermitnewecc"></div>
                                  <div class="col-md-1"><button type="button" name="button" class="btn-primary" onClick="Crs.upload_new_attachment_apr_est('3',this)"><i class="fa fa-upload" aria-hidden="true"></i></button></div>
                                </div>


                            <!-- <div class="form-group row ecc_section">
                              <div class="col-md-11"></div>
                              <div class="col-md-1" style="display:contents">
                                <button type="button"  class="ecc_btn_rmv btn-danger"><i class="fa fa-remove" aria-hidden="true" ></i></button>
                                <button type="button" id="ecc_btn" name="button" class="btn-primary"><i class="fa fa-plus" aria-hidden="true" ></i></button>
                              </div>
                            </div> -->
                            <hr>
                            <!-- for po -->
                           <div class="col-md-12 mb-3 text-center">
                             <h7 style="font-weight: bold;">Permint to Operate (PO)</h7>
                           </div>
                              <!-- <div class="form-group row po_section-options">
                               <div class="col-sm-3" style="text-align:center">
                                 <span for="">APPLICABLE</span>
                                 <input type="radio" class="form-control" name="po_status" value="1" >
                               </div>
                               <div class="col-sm-3" style="text-align:center">
                                   <span for="">ON-PROCESS</span>
                                 <input type="radio" class="form-control" name="po_status" value="2">
                               </div>
                               <div class="col-sm-3" style="text-align:center">
                                 <span for="">NONE</span>
                                 <input type="radio" class="form-control" name="po_status" value="3">
                               </div>
                               <div class="col-sm-3" style="text-align:center">
                                 <span for="">NOT APPLICABLE</span>
                                 <input type="radio" class="form-control" name="po_status" value="4">
                               </div>
                           </div> -->
                           <div class="multiple_po_permits_data"></div>

                         <div class="form-group row po_section-row">
                           <!-- <div class="col-md-1"></div> -->
                           <div class="col-md-9"><input type="text" class="form-control" name="po_no" value="" placeholder="PO NO." required></div>
                           <!-- <div class="col-md-3"><input type="file" class="" name="po_no_file[]" value="" required></div> -->
                           <div class="col-md-2"><input type="file" value="" id="uploadpermitnewpo"></div>
                           <div class="col-md-1"><button type="button" name="button" class="btn-primary" onClick="Crs.upload_new_attachment_apr_est('4',this)"><i class="fa fa-upload" aria-hidden="true"></i></button></div>
                         </div>


                     <!-- <div class="form-group row po_section">
                       <div class="col-md-11"></div>
                       <div class="col-md-1" style="display:contents">
                          <button type="button"  class="po_btn_rmv btn-danger"><i class="fa fa-remove" aria-hidden="true" ></i></button>
                         <button type="button" id="po_btn" name="button" class="btn-primary"><i class="fa fa-plus" aria-hidden="true" ></i></button>
                       </div>
                     </div> -->
            </div>
          </div>
        </div>
      <?php endforeach; ?>

    </div>
  </div>
</div>


<div class="modal fade" id="update_permit_attachment_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" style="z-index:99999">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header btn-primary" >
        <h5 class="modal-title" style="color:#FFF;" id="useraccountsModalLabel">UPDATE PERMIT</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#FFF;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="req_id" value="" id="file_directory_id">
        <input type="hidden" name="file_id" value="" id="file_id">
        <input type="hidden" name="old_file_name" value="" id="old_file_name_id">
        <input type="hidden" name="dp_no_id" value="" id="permit_unq_no_id">
        <input type="hidden" name="permit_type" value="" id="permit_type_id">
        <div class="alert alert-success" role="alert" id="update_dp_permit_messsage" style="display:none">
            Successfully updated !
          </div>
        <label for="permit_no_id" id="permit_name">PERMIT NO.</label>
        <input type="text" name="permit_no" value="" id="permit_no_id"  class="form-control">
        <br>
        <div class="input-group mb-3">
        <div class="input-group-prepend">
        <span class="input-group-text">Upload</span>
        </div>
        <div class="custom-file">
        <input type="file" class="custom-file-input" id="uploadpermitfile">
        <label class="custom-file-label" for="uploadpermitfile">Choose file</label>
        </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" onClick='Crs.update_permit_per_establishment()'>Update</button>
      </div>
    </div>
  </div>
</div>
<style media="screen">
  .attch_perm_name{
    white-space: nowrap;
  width: 50px;
  overflow: hidden;
  text-overflow: ellipsis;
  }
  .custom-file-label{
    white-space: nowrap;
  /* width: 50px; */
  overflow: hidden;
  text-overflow: ellipsis;
  }

</style>
<script
  src="https://code.jquery.com/jquery-3.5.1.min.js"
  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
  crossorigin="anonymous"></script>
<script type="text/javascript">
  $(document).ready(function(){
    var selected_company = '<?= $selected_est; ?>'
    // console.log(selected_company);
    if (selected_company != '') {
      $('#multiCollapseExample'+selected_company).addClass('show');
      Crs.view_apr_company_permits(selected_company,this);
    }
    $("input[name='dp_status']").each(function(x,y){
     if ($(this).val() == 1) {
      $(this).prop('checked',true)
     }
   })
    $('#uploadpermitfile').change(function(e){
      var fileName = e.target.files[0].name;
      $('.custom-file-label').text(fileName);
   });

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

    $('.dp_btn').click(function(){
       $dprow = $(this).parent().parent().prev().clone()
       $dprow.clone().insertBefore($(this).closest($('.dp_section')));
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
    // $cnc = $(this).parent().parent().prev().clone()
    // $('#cnc_btn').click(function(){
    //    $cnc = $(this).parent().parent().prev().clone()
    //    $cnc.clone().insertBefore($(this).closest($('.cnc_section')));
    // });
    // $('.cnc_btn_rmv').on('click',function(){
    //   $(this).parent().parent().prev().remove();
    // });


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

    $('#ecc_btn').click(function(){
       $ecc = $(this).parent().parent().prev().clone()
       $ecc.clone().insertBefore($(this).closest($('.ecc_section')));
    });
    $('.ecc_btn_rmv').on('click',function(){
      $(this).parent().parent().prev().remove();
    });

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

    $('#po_btn').click(function(){
       $po = $(this).parent().parent().prev().clone()
       $po.clone().insertBefore($(this).closest($('.po_section')));
    });
    $('.po_btn_rmv').on('click',function(){
      $(this).parent().parent().prev().remove();
    });

  })
</script>


<div id="content-wrapper" class="d-flex flex-column">
      <!-- Main Content -->
      <div id="content">
        <!-- Topbar -->
        <div class="container-fluid">
          <h1 class="h6 mb-4 text-gray-600" style="text-decoration: underline;">DASHBOARD</h1>
          <div class="row">
              <div class="col-md-12">
                <div class="card shadow mb-4">
                  <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">APPROVED ESTABLISHMENTS</h6>
                       <p style="color:red"><span style="font-weight: 900;">Note:</span> We highly recommend to upload/update your updated permits click file icon on the table to update, or please see <a target="_blank" href="<?= base_url()?>uploads/steps_crs_new.pdf">USER MANUAL <i class="fa fa-book" aria-hidden="true"></i></a> for more details.</p>


                  </div>
                  <div class="card-body">
                    <table class="table table-striped table-bordered table-hover" id="approved_est_tbl">
                      <thead>
                        <tr>
                        <th>Company Reference ID</th>
                        <th>Establishment</th>
                        <th>Street</th>
                        <th>Baranggay</th>
                        <th>City/Municipality</th>
                         <th>Province</th>
                         <th>Date Approved</th>
                         <th>Status</th>
                         <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                        <td colspan="7" class="dataTables_empty">Loading data from server</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
          </div>

          <div class="row">
            <!-- Area Chart -->
            <div class="col-xl-12 col-lg-12">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">PENDING ESTABLISHMENTS</h6>
                </div>
                <!-- Card Body -->
                  <div class="card-body">
                    <div class="table-responsive" style="margin-top: 10px;">
                      <table class="table table-hover" id="pending_est_list" width="100%" cellspacing="0">
                        <thead>
                          <tr>
                          <th>Facility</th>
                          <th>Street</th>
                          <th>Baranggay</th>
                          <th>City/Municipality</th>
                          <th>Province</th>
                          <th>Status</th>
                          <th>Date Submitted</th>
                          <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
                    </div>
                  </div>
              </div>
            </div>
          </div>

          <!-- <div class="row">
              <div class="col-md-12">
                <div class="card shadow mb-4">
                  <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">PENDING ESTABLISHMENTS</h6>

                  </div>
                    <div class="card-body">
                      <table class="table table-hover" id="pending_est_list" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                        <th>Facility</th>
                        <th>Street</th>
                        <th>Baranggay</th>
                        <th>City/Municipality</th>
                        <th>Province</th>
                        <th>Status</th>
                        <th>Date Submitted</th>
                        <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                        <td colspan="7" class="dataTables_empty">Loading data from server</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
          </div> -->
          <!-- Content Row -->
        </div>
        <!-- /.container-fluid -->
      </div>
      <!-- End of Footer -->

    </div>
      <div class="modal fade" id="view_dissapproved_data_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" style="z-index:99999">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header btn-primary" >
              <h5 class="modal-title" style="color:#FFF;" id="useraccountsModalLabel">DISAPPROVED REASON</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#FFF;">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p id="view_dissapproved_data_container"></p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="update_mobile_number_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Account</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="" action="<?=base_url();?>/User/update_mobile_number" method="post">
        <div class="modal-body">
          <p><span style="color:red">Note:</span> Enter your number if you want to recieve notifications through SMS.</p>
            <label for="">Mobile number:</label>
            <!-- <input type="number" name="mobile_number" value="" minlength="8" required> -->
            <input name="mobile_number" pattern=".{11,11}" required title="Please enter valid mobile number" class="form-control">
        </div>
        <div class="modal-footer">
          <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
          <button type="submit" name="button" class="btn btn-danger">No Thanks</button>
          <button type="submit" class="btn btn-primary">Add</button>
        </div>
        </form>
    </div>
  </div>
</div>
      <!-- <div class="modal fade" id="update_mobile_number_modal" tabindex="-1" role="dialog" aria-labelledby="useraccountsModalLabel" aria-hidden="true">
        <div class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md" role="document">
          <div class="modal-content" style="border: none;">
            <div class="modal-header">
              <h5 class="modal-title" id="useraccountsModalLabel">Update Account</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form class="" action="<?=base_url();?>/User/update_mobile_number" method="post">
              <div class="modal-body">
                  <label for="">Mobile number:</label>
                  <input type="text" name="" value="" placeholder="09232214142" min="11" class="formcontrol">
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">update</button>
              </div>
            </form>
          </div>
        </div>
      </div> -->


    <?php if ($this->session->flashdata('client_removed_est_msg') != ''): ?>
    <script type="text/javascript">
     $(document).ready(function() {
       Swal.fire({
         title: 'Successfully removed.',
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
    <!-- <?php if (empty($cnt_number[0]['mobile_number']) || $cnt_number[0]['mobile_number'] == 0): ?>
      <script type="text/javascript">
        $(document).ready(function(){
          $('#update_mobile_number_modal').show().addClass('show');
        });
      </script>
      <?php else: ?>
        <script type="text/javascript">
          $(document).ready(function(){
            $('#update_mobile_number_modal').hide();
          });
        </script>
    <?php endif; ?> -->
    <script type="text/javascript">
        $(document).ready(function(){

          var client_id = '<?= $this->session->userdata('client_id') ?>';
          // console.log(client_id);
          var table1 = $('#approved_est_tbl').DataTable({
              responsive: true,
              paging: true,
              "serverSide": true,
              processing: true,
              language: {
                "infoFiltered": "",
                processing: "<img src='<?php echo base_url('assets/images/loader/embloader.gif'); ?>' alt='load_logo' style='width:50px; height:50px;' />&nbsp;&nbsp;<img src='<?php echo base_url('assets/images/loader/prcloader.gif'); ?>' alt='load_prc' style='width:120px; height:50px;' />"
              },
              "ajax": "<?php echo base_url('Serverside/approved_view_est_list');?>",
              "columns": [
                { "data": 'emb_id',"searchable": true},
                { "data": 'company_name',"searchable": true},
                { "data": 'street', "searchable": true},
                { "data": 'barangay_name',"searchable": true},
                { "data": 'city_name',"searchable": true},
                { "data": 'province_name',"searchable": true},
                { "data": "input_date", "searchable": true },
                { "data": 'status',"searchable": true},
                {
                    "data": null,'ClassName':'btn-group',
                      "render": function(data, type, row, meta){
                        data = "<a href='<?= base_url('Establishment_/view_approved_establishment/');?>"+row['company_id']+"' target='_blank'><i class='fa fa-eye'></i></a>&nbsp;<a href='<?= base_url('Establishment_/check_permits_apr_establishment/');?>"+row['req_id']+"' target='_blank'><i class='fa fa-file'></i></a>";
                        return data;
                      }
                  },
              ]

          });

          var table2 = $('#pending_est_list').DataTable({
              responsive: true,
              paging: true,
              "serverSide": true,
              "order": [[ 6,"DESC" ]],
              processing: true,
              language: {
                "infoFiltered": "",
                processing: "<img src='<?php echo base_url('assets/images/loader/embloader.gif'); ?>' alt='load_logo' style='width:50px; height:50px;' />&nbsp;&nbsp;<img src='<?php echo base_url('assets/images/loader/prcloader.gif'); ?>' alt='load_prc' style='width:120px; height:50px;' />"
              },
              "columnDefs": [
                 { "width": "20%", "targets": 0 }
               ],
              "ajax": "<?php echo base_url('Serverside/pending_view_est_list');?>",
              "columns": [
                { "data": 'establishment',"searchable": true},
                { "data": 'est_street', "searchable": true},
                { "data": 'name.brgy_name',"searchable": true},
                { "data": 'name.city_name',"searchable": true},
                { "data": 'name.prov_name',"searchable": true},
                {
                    "data": null,'ClassName':'btn-group',
                      "render": function(data, type, row, meta){
                        if (row['status'] == 'Disapproved' || row['status'] == 'Disapproved/Requested' ) {
                        data = "<a tag='"+row['emb_id']+"' data-id='"+row['emb_id']+"'  href='#'  data-toggle='modal' data-target='#view_dissapproved_data_modal' onClick='Crs.view_dissapproved_data("+row['req_id']+")' style='color:red;text-decoration:underline'>"+row['status']+"</a>";

                        }else {
                          data = "<a tag='"+row['emb_id']+"' data-id='"+row['emb_id']+"'  href='#'  onClick='Crs.view_dissapproved_data("+row['req_id']+")' style='color:#000;'>"+row['status']+"</a>";
                        }
                        return data;
                      }
                  },
                { "data": "date_created", "orderData": 6 },
                {
                    "data": null,'ClassName':'btn-group',
                      "render": function(data, type, row, meta){
                        if (row['status'] == 'Requested/For Emb Approval' || row['status'] == 'Disapproved/Requested' ) {
                          data = "<a onClick='Crs.remove_request("+row['req_id']+")'  style='color:red;'><i class='fa fa-trash'></i></a>";
                        }else {
                          data = "<a tag='"+row['est_id']+"' data-id='"+row['est_id']+"' id='edit_btn' href='<?= base_url('Establishment_/view_est_data');?>/"+row['est_id']+"' target='_blank' style='color:#000;'><i class='fa fa-edit fa-fw'></i></a>&nbsp;&nbsp;<a onClick='Crs.remove_request("+row['req_id']+")'  style='color:red;'><i class='fa fa-trash'></i></a>&nbsp;&nbsp;<a href='<?= base_url('Establishment_/check_permits/');?>"+row['req_id']+"' target='_blank'><i class='fa fa-file'></i></a>";
                          
                          // if (client_id == 16033) {
                          //   data = "<a tag='"+row['est_id']+"' data-id='"+row['est_id']+"' id='edit_btn' href='<?= base_url('Establishment_/view_est_data');?>/"+row['est_id']+"' target='_blank' style='color:#000;'><i class='fa fa-edit fa-fw'></i></a>&nbsp;&nbsp;<a onClick='Crs.remove_request("+row['req_id']+")'  style='color:red;'><i class='fa fa-trash'></i></a>&nbsp;&nbsp;<a href='<?= base_url('Establishment_/check_permits/');?>"+row['req_id']+"' target='_blank'><i class='fa fa-file'></i></a>";
                          // }else {
                          //   data = "<a tag='"+row['est_id']+"' data-id='"+row['est_id']+"' id='edit_btn' href='<?= base_url('Establishment/view_est_data');?>/"+row['est_id']+"' target='_blank' style='color:#000;'><i class='fa fa-edit fa-fw'></i></a>&nbsp;&nbsp;<a onClick='Crs.remove_request("+row['req_id']+")'  style='color:#000;'><i class='fa fa-trash'></i></a>";
                          // }
                        }
                        return data;
                      }
                  },
              ]

          });

        });
    </script>

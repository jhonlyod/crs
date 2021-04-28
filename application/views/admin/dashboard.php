<div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <div class="container-fluid">
          <!-- <div class="d-sm-flex align-items-center justify-content-between mb-4"> -->
          <!-- </div> -->

          <div class="row">
              <div class="col-md-12">
                <div class="card shadow mb-4">
                  <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">USER LIST - RESEND USER CREDENTIALS</h6>
                  </div>
                  <div class="card-body">
                    <table class="table table-striped table-bordered table-hover" id="user_list">
                      <thead>
                        <tr>
                        <th>CLIENT ID</th>
                        <th>REGION</th>
                        <th>USERNAME</th>
                        <th>PASSWORD</th>
                        <th>CLIENT NAME</th>
                        <th>EMAIL</th>
                        <th>RESEND EMAIL STATUS</th>
                        <th>ACTION</th>
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
              <div class="col-md-12">
                <div class="card shadow mb-4">
                  <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">USER LIST - RESEND HWMS CREDENTIALS</h6>
                  </div>
                  <div class="card-body">
                    <table class="table table-striped table-bordered table-hover" id="hwms_resend_email">
                      <thead>
                        <tr>
                        <th>EMB ID</th>
                        <th>COMPANY NAME</th>
                        <th>CLIENT NAME</th>
                        <th>CLIENT EMAIL</th>
                        <th>RESEND STATUS</th>
                        <th>ACTION</th>
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
          <!-- Content Row -->

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Footer -->

    </div>
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
    <script type="text/javascript">
        $(document).ready(function(){
          var table3 = $('#user_list').DataTable({
            responsive: true,
            paging: true,
            deferRender: true,
            lengthMenu:[[ 10, 25, 50, -1],[ 10, 25, 50, "ALL"]],
            pageLength: 10,
              "serverSide": true,
              // "order": [[ 6,"DESC" ]],
              "ajax": "<?php echo base_url('Serverside/user_list');?>",
              "columns": [
                { "data": 'client_id',"searchable": true},
                { "data": 'region',"searchable": true},
                { "data": 'username',"searchable": true},
                { "data": 'raw_password',"searchable": true},
                { "data": 'client_name',"searchable": true},
                { "data": 'email',"searchable": true},
                { "data": 'status',"searchable": true},
                {
                    "data": null,'ClassName':'btn-group',
                      "render": function(data, type, row, meta){
                            data = "<a onClick='Crs.resend_verification_email("+row['client_id']+")'  style='color:#000;'><i class='fa fa-paper-plane' aria-hidden='true'></i></a>";

                        return data;
                      }
                  },
              ]

          });
          var table5 = $('#hwms_resend_email').DataTable({
            responsive: true,
            paging: true,
            deferRender: true,
            lengthMenu:[[ 10, 25, 50, -1],[ 10, 25, 50, "ALL"]],
            pageLength: 10,
              "serverSide": true,
              // "order": [[ 6,"DESC" ]],
              // <th>EMB ID</th>
              // <th>CLIENT NAME</th>
              // <th>CLIENT EMAIL</th>
              // <th>RESEND STATUS</th>
              // <th>ACTION</th>
              "ajax": "<?php echo base_url('Serverside/resend_hwms_credentials');?>",
              "columns": [
                { "data": 'emb_id',"searchable": true},
                  { "data": 'company_name',"searchable": true},
                { "data": 'client_name',"searchable": true},
                { "data": 'email',"searchable": true},
                { "data": 'status',"searchable": true},
                {
                    "data": null,'ClassName':'btn-group',
                      "render": function(data, type, row, meta){
                            data = "<a onClick='Crs.resend_hwms_email("+row['client_req_id']+")'  style='color:#000;'><i class='fa fa-paper-plane' aria-hidden='true'></i></a>";

                        return data;
                      }
                  },
              ]

          });
        });
    </script>

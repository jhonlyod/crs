<div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <div class="container-fluid">
          <!-- <div class="d-sm-flex align-items-center justify-content-between mb-4"> -->
          <!-- </div> -->
          <div class="row" style="display:none">
              <div class="col-md-12">
                <div class="card shadow mb-4">
                  <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">ADMIN APPROVED ESTABLISHMENTS - <?= $_SESSION['region_name']?></h6>
                  </div>
                  <div class="card-body">
                    <table class="table table-striped table-bordered table-hover" id="approved_est_tbl">
                      <thead>
                        <tr>
                        <th>Emb id</th>
                        <th>Establishment</th>
                        <th>Client</th>
                        <th>Street</th>
                        <th>Baranggay</th>
                        <th>City/Municipality</th>
                         <th>Province</th>
                         <th>Date Approved</th>
                         <th>Status</th>
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
          <div class="row" style="display:none">
              <div class="col-md-12">
                <div class="card shadow mb-4">
                  <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">ADMIN PENDING ESTABLISHMENTS - <?= $_SESSION['region_name']?></h6>
                  </div>
                  <div class="card-body">
                    <table class="table table-striped table-bordered table-hover" id="pending_est_list">
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
          </div>

          <div class="row">
              <div class="col-md-12">
                <div class="card shadow mb-4">
                  <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">USER LIST</h6>
                  </div>
                  <div class="card-body">
                    <table class="table table-striped table-bordered table-hover" id="co_user_list">
                      <thead>
                        <tr>
                        <th>CLIENT ID</th>
                        <th>CLIENT NAME</th>
                        <th>EMAIL</th>
                        <th>RESEND EMAIL STATUS</th>
                        <th>ACCOUNT STATUS</th>
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
    <script type="text/javascript">
        $(document).ready(function(){

          var table = $('#co_user_list').DataTable({
              responsive: true,
              paging: true,
              "serverSide": true,
              // "order": [[ 6,"DESC" ]],
              "ajax": "<?php echo base_url('Serverside/co_user_list');?>",
              "columns": [
                { "data": 'client_id',"searchable": true},
                { "data": 'client_name',"searchable": true},
                { "data": 'email',"searchable": true},
                { "data": 'status',"searchable": true},
                  { "data": 'verified',"searchable": true},
              ]

          });
        });
    </script>

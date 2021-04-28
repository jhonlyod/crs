<div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <div class="container-fluid">
          <div class="row">
              <div class="col-md-12">
                <div class="card shadow mb-4">
                  <div class="card-header py-3">
                    <div class="row">
                      <div class="col-md-6">
                        <h6 class="m-0 font-weight-bold text-primary" style="padding-top: 9px;">SWM MONITORING REPORT</h6>
                      </div>
                      <div class="col-md-6">
                        <a href="<?php echo base_url().'swm/map'; ?>" target="_blank" style="float:right;" class="btn btn-info btn-sm"><span class="fa fa-map-marker"></span>&nbsp;MAP VIEW</a>
                      </div>
                    </div>
                  </div>
                  <div class="card-body">
                    <table class="table table-striped table-bordered table-hover" id="sweetreport" style="text-align:center;">
                      <thead>
                        <tr>
                          <th></th>
                          <th></th>
                          <th></th>
                          <th></th>
                          <th>LGU Patrolled</th>
                          <th>Barangay</th>
                          <th>Type of Report</th>
                          <th>Date Patrolled</th>
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

          <!-- Content Row -->

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Footer -->

    </div>

    <script type="text/javascript">
        $(document).ready(function(){
          var table1 = $('#sweetreport').DataTable({
              responsive: true,
              paging: true,
              "serverSide": true,
              language: {
                "infoFiltered": "",
              },
              "bLengthChange": false,
              "bInfo" : false,
              // "order": [[ 6,"DESC" ]],
              "ajax": "<?php echo base_url('SWMON/Serverside/getsweetdata');?>",
              "columns": [
                { "data": 0,"visible": false},
                { "data": 1,"visible": false},
                { "data": 'report_number',"visible": false},
                { "data": 'cnt',"visible": false},
                { "data": 'lgu_patrolled_name',"searchable": true,"sortable": false, },
                { "data": 'barangay_name',"searchable": true,"sortable": false,},
                { "data": 'report_type',"searchable": true,"sortable": false,},
                { "data": 'time_patrolled',"searchable": true,"sortable": false,},
                { "data": 'status',"searchable": true,"sortable": false,},
                {
                  "data": null,
                    "render": function(data, type, row, meta){
                        data = "<a title='View Report' class='btn btn-danger btn-sm' href='https://iis.emb.gov.ph/embis/Swm/Form?token="+row[1]+"&rn="+row['report_number']+"&cnt="+row['cnt']+"' target='_blank'><span class='fa fa-file'></span>&nbsp;View Report</a>";
                        data += "&nbsp;<a title='Add feedback to EMB' href='#' onclick=addfeedback('"+row[0]+"','"+row['report_number']+"'); class='btn btn-success btn-sm' data-toggle='modal' data-target='#add_feedback'><span class='fa fa-bullhorn' style='color:#FFF;'></span>&nbsp;Add Feedback</a>";
                        return data;
                    }
                },
              ]

          });
        });

        var base_url = window.location.origin+"/crs";
        function addfeedback(token, rn){
          $.ajax({
               url: base_url+"/SWMON/Ajax/addfeedback",
               type: 'POST',
               async : true,
               data: { token : token, rn : rn },
               success:function(response)
                 {
                   $("#add_feedback_").html(response);
                   dynamicdiv(token, rn);
                 }

           });
        }

        function onsite_photo_lgu(token, tkn, rn){
          var form_data = new FormData();

          // Read selected files
          var totalfiles = document.getElementById('site_photo_lgu').files.length;
          for (var index = 0; index < totalfiles; index++) {
            form_data.append("site_photo_lgu[]", document.getElementById('site_photo_lgu').files[index]);
          }
          form_data.append("token", token);

          document.getElementById("swsitephotolgu_").style.display = 'block';
          // AJAX request
          $.ajax({
           url: base_url+'/SWMON/Postdata/onsite_photo_lgu',
           type: 'post',
           data: form_data,
           dataType: 'json',
           xhr: function() {
                  var sendfilesXHR = $.ajaxSettings.xhr();
                  if(sendfilesXHR.upload){
                      sendfilesXHR.upload.addEventListener('progress',swuserphotoprogresslgu, false);
                  }
                  return sendfilesXHR;
          },
           cache: false,
           contentType: false,
           processData: false,
           success: function (response) {
             document.getElementById('site_photo_lgu').value = '';
             if(response.status == 'success'){
               alert('Photo successfully uploaded.');
             }else if(response.status == 'failed'){
               alert('File upload unsuccessful. Please retry.');
             }else{
               alert('File upload unsuccessful. Please retry.');
             }
             document.getElementById("swsitephotolgu_").style.display = 'none';
             dynamicdiv(tkn, rn);
           }
          });
        }

        function dynamicdiv(token, rn){
          $.ajax({
               url: base_url+"/SWMON/Ajax/dynamicdiv",
               type: 'POST',
               async : true,
               data: { token : token, rn : rn },
               success:function(response)
                 {
                   $("#dynamicdiv_").html(response);
                 }

           });
        }

        function swuserphotoprogresslgu(e){
            if(e.lengthComputable){
                var max = e.total;
                var current = e.loaded;

                var Percentage = (current * 100)/max;
                document.getElementById("swsitephotouploadprogressbar_").style.width = Math.round(Percentage)+"%";
                var percent = document.getElementById("swsitephotoprogresspercentage_");
                percent.innerHTML = Math.round(Percentage)+"%";

                if(Percentage >= 100){ }
            }
       }

       function removeimage(token, rn, imagename){
         $.ajax({
              url: base_url+"/SWMON/Ajax/removeimage",
              type: 'POST',
              async : true,
              data: { token : token, rn : rn, imagename : imagename },
              success:function(response)
              {
                dynamicdiv(token, rn);
              }

          });
       }
    </script>

    <div class="modal fade" id="add_feedback" tabindex="-1" role="dialog" aria-labelledby="useraccountsModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document" style="max-width: 80% !important;">
        <div class="modal-content">
          <div class="modal-header" style="background-color:#F8F9FC;">
            <h5 class="modal-title" id="useraccountsModalLabel">Add Feedback</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
            <div id="add_feedback_"></div>
        </div>
      </div>
    </div>

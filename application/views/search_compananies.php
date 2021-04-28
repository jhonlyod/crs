 <?php  echo $banner;?>
<div id="content-wrapper" class="d-flex flex-column">
  <div id="content">
     <div class="container">

       <?php  echo $tabs_menu;?>
         <div class="card o-hidden border-0 shadow-lg my-4">
           <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary text-center">SEARCH EMB REGISTERED COMPANIES <?=
                (!empty($this->session->userdata('selected_region'))  ? 'IN '.$this->session->userdata('selected_region') : '');?></h6>
           </div>
               <div class="card-body p-0">
                 <div class="row">
                   <div class="col-lg-12">
                     <div class="p-5">
                       <form class="" action="" method="post" id="establishment_registration" enctype="multipart/form-data">
                         <div class="row">
                           <div class="col-md-6">
                                <input type="hidden" name="company" id="selected_company_id" value="<?=$this->session->userdata('selected_company')?>">
                           </div>
                           <div class="col-md-6">
                             <select class="form-control" name="company_view_options" id="company_view_options_id">
                               <?php if (!empty($this->session->userdata('selected_company'))): ?>
                                   <option value="0" selected>SELECTED COMPANY</option>
                                   <?php else: ?>
                                    <option value="0">SELECTED COMPANY</option>
                               <?php endif; ?>

                                <option value="1">SHOW ALL</option>
                             </select>
                           </div>
                         </div>


                         <div class="form-group row">
                           <div class="col-sm-12 mb-3 mb-sm-0">
                              <div class="col-xl-12 mb-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                        </div>
                                        <div class="col-md-6">
                                        </div>
                                    </div>
                                  </div>
                                  <div class="table-responsive" style="margin-top: 10px;">
                                    <table class="table table-hover" id="select_existing_company" width="100%" cellspacing="0">
                                      <thead>
                                        <tr>
                                          <td></td>
                                          <th>Company Name</th>
                                          <th>Location</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                      </tbody>
                                    </table>
                                  </div>
                           </div>
                           </div>
                           <div class="row">
                             <div class="col-md-6">  <a  style="text-decoration:none" href="<?=base_url()?>Establishment_/add_establishment_steps/3/0"><button type="button" class="btn btn-danger btn-user btn-block"  name="button">NOT IN THE LIST</button></a></div>
                             <div class="col-md-6">
                               <div class="row form-group">
                                 <div class="col-md-6">
                                      <button type="button" onclick="goBack()" class="btn btn-primary btn-user btn-block" value="1" id="previous-page">PREVIOUS</button>
                                 </div>
                                 <div class="col-md-6">
                                      <button type="button" name="btn_est_add" class="btn btn-primary btn-user btn-block" value="1" id="submit-selected-company">NEXT</button>
                                 </div>
                               </div>


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
  <style media="screen">
      div.dataTables_wrapper div.dataTables_processing {
       top: 5%;
      }
      th { font-size: 13px; }
      td { font-size: 13px; }
  </style>
  <script type="text/javascript">
  function goBack() {
    var base_url = '<?=base_url()?>';
    window.location.replace(base_url+"Establishment_/add_establishment_steps/1");
  }
  $(document).ready(function(){
    var base_url = '<?=base_url()?>';
    $('#submit-selected-company').on('click',function(){
      if ($('#selected_company_id').val() == '') {
        alert('CLICK NOT IN THE LIST IF YOUR ESTABLISHMENT IS NOT YET REGISTERED , THANK YOU !');
        return false;
      }else {
        window.location.replace(base_url+"Establishment_/add_establishment_steps/3/"+$('#selected_company_id').val() );
        // this.form.submit();
      }
    })

   var selected_main_company_id = $('#add_main_company_id').val();
     initDatatable();
  });
  $('#company_view_options_id').on('change',function(){
   initDatatable($(this).val());
  })
  function initDatatable(selected_company){
     var html = '';

   var table = $('#select_existing_company').DataTable({
     responsive: true,
     orderFixed: [ 0, 'asc' ],
     paging: true,
     destroy:true,
     deferRender: true,
     lengthMenu:[[ 5,10, 25, 50, -1],[ 5,10, 25, 50, "ALL"]],
     pageLength: 5,

     "serverSide": true,
     "ajax": {
       "url": "<?php echo base_url(); ?>Serverside/select_existing_company",
       "data": {
         "selected_company": selected_company
       }
     },
     "columns": [
        { "data": null, defaultContent: '' },
       { "data": "company_name","searchable": true},
       { "data": 'province_name',"searchable": false},
     ], 'columnDefs': [{
           'targets': 0,
           'searchable': false,
           'orderable': false,
           'className': 'dt-body-center',
           'render': function (data, type, full, meta){
               var selected_company_id = "<?=$this->session->userdata('selected_company')?>";
               data ='<input type="radio" id="select_existing_company" name="select_existing_company" value="'+data.company_id+'" '+ (data.company_id == selected_company_id ? ' checked="checked"' : '') + ' onclick="Crs.select_existing_company('+data.company_id+')">';
             return data;

           }
        }],
       'order': [[1, 'asc']]
   });
  }

  </script>
<style media="screen">
.dataTables_filter input {
  width: 338px!important;
}
</style>

 <?php  echo $banner;?>
<div id="content-wrapper" class="d-flex flex-column">
  <div id="content">
     <div class="container">

       <?php  echo $tabs_menu;?>
         <div class="card o-hidden border-0 shadow-lg my-4">
           <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary text-center">SELECT REGION THE ESTABLISHMENT IS LOCATED</h6>
           </div>
               <div class="card-body p-0">
                 <div class="row">
                   <div class="col-lg-12">
                     <div class="p-5">
                       <form class="" action="<?=base_url();?>add_establishment_steps/2" method="post" id="establishment_registration" enctype="multipart/form-data">
                         <div class="form-group row">
                           <div class="col-sm-12 mb-3 mb-sm-0">
                             <select class="form-control" name="est_region" required id="select_region_id">
                               <option value="">---</option>
                               <?php foreach ($region_list as $key => $value): ?>
                                 <?php if ($this->session->userdata('selected_region') == $value['rgnnum']): ?>
                                     <option value="<?=$value['rgnnum']?>" selected><?=$value['rgnnam']?></option>
                                    <?php else: ?>
                                        <option value="<?=$value['rgnnum']?>"><?=$value['rgnnam']?></option>
                                 <?php endif; ?>
                               <?php endforeach; ?>
                             </select>
                           </div>
                           </div>
                           <div class="row">
                             <div class="col-md-8"></div>
                             <div class="col-md-4">
                               <button type="submit" name="btn_est_add" class="btn btn-primary btn-user btn-block" value="1" style="float:right">NEXT</i>
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

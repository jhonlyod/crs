<?php (!empty($this->session->userdata('selected_company')))? $company_id = $this->session->userdata('selected_company'): $company_id = 0; ?>
<ul id="tabs_menu" class="nav nav-pills">
    <div class="col-md-12 crs_tabs_menu">
      <div class="row">
      <div class="col-md-3">
        <!-- <a href="<?=$mod1link.'/'.$company_id;?>" ><button type="button" name="button" class="btn btn-user btn-block <?=@$mod1;?>">1</button></a> -->
          <a href="#"><button type="button" name="button" class="btn btn-user btn-block <?=@$mod1;?>">1</button></a>
      </div>
      <div class="col-md-3">
          <!-- <a href="<?=$mod2link.'/'.$company_id;?>" ><button type="button" name="button" class="btn btn-user btn-block <?=@$mod2;?>">2</button></a> -->
          <a href="#" ><button type="button" name="button" class="btn btn-user btn-block <?=@$mod2;?>">2</button></a>
      </div>
      <div class="col-md-3">
        <!-- <a href="<?=$mod3link.'/'.$company_id;?>" ><button type="button" name="button" class="btn btn-user btn-block <?=@$mod3;?>">3</button></a> -->
          <a href="#" ><button type="button" name="button" class="btn btn-user btn-block <?=@$mod3;?>">3</button></a>
      </div>
      <div class="col-md-3">
          <!-- <a href="<?=$mod4link.'/'.$company_id;?>" ><button type="button" name="button" class="btn btn-user btn-block <?=@$mod4;?>" id="btn-crs-4">4</button></a> -->
            <a href="#" ><button type="button" name="button" class="btn btn-user btn-block <?=@$mod4;?>" id="btn-crs-4">4</button></a>
      </div>
    </div>

  </div>

</ul>

<style media="screen">
  .crs_tabs_menu .col-md-3{
    border: solid 1px green;
    border-radius: 30px;
  }
  .crs_tabs_menu .active{
    font-weight: bold;
    background: green;
    color: white;
    width: 43px;
    margin: auto;
    text-align: center;
    border-radius: 1px;
  }
  #tabs_menu{
    margin-bottom: 20px;
  }

</style>

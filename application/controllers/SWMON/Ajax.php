<?php

 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ajax extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->helper(array('form', 'url'));
    $this->load->library('session');
    $this->load->database();
    $this->load->model('SWM_model');

    session_start();
    if ( ! $this->session->userdata('is_login'))
    {
          $this->session->sess_destroy();
          redirect('Login/logout_user');
    }

    // echo $this->session->userdata('logged_in');

  }

  function addfeedback(){
    $token = $this->input->post('token', TRUE);
    $rn = $this->input->post('rn', TRUE);

    $wheredata = $this->db->where('sff.trans_no = "'.$this->encrypt->decode($token).'" AND sff.report_number = "'.$rn.'" AND status = "Active" ORDER BY sff.cnt ASC');
    $querydata = $this->SWM_model->selectdata('embis.sweet_form_feedback AS sff','','',$wheredata);

    ?>
      <form action="<?php base_url(); ?>SWMON/Postdata/savedata" method="post" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="col-md-12">
            <a style="width:100%;" class="btn btn-info btn-sm" data-toggle="collapse" href="#collapsefeedbacks" role="button" aria-expanded="false" aria-controls="collapsefeedbacks">
              View recent feedback(s)
            </a>
            <div class="collapse" id="collapsefeedbacks" style="margin-top:15px;border: 1px solid #D1D3E2;padding: 7px;">
              <?php if(!empty($querydata[0]['cnt'])){ ?>
                <div class="col-md-12">
                  <table id="lgufeedbackdttbl" class="table table-striped table-hover" style="text-align:center; zoom: 90%;width:100%;">
                  <thead class="thead-dark">
                    <tr>
                      <td>Report Type</td>
                      <td>Date</td>
                      <td>Remarks</td>
                      <td>Attachment(s)</td>
                    </tr>
                  </thead>
                  <tbody>
                    <?php for ($i=0; $i < sizeof($querydata); $i++) { ?>
                      <?php
                        $attachment = '';
                        if(!empty($querydata[$i]['attachments'])){
                          $wheredataselect = $this->db->where('sf.trans_no = "'.$this->encrypt->decode($token).'"');
                          $queryselect = $this->SWM_model->selectdata('embis.sweet_form AS sf','sf.date_created, sf.region','',$wheredataselect);
                          $explodedata = explode('|',$querydata[$i]['attachments']);
                          for ($a=0; $a < count($explodedata); $a++) {
                            if(!empty($explodedata[$a])){
                              $attachment .= "<a style='width:100%;margin-bottom:5px;' href='".base_url()."../iis-images/sweet_report/".date('Y', strtotime($queryselect[0]['date_created']))."/".$queryselect[0]['region']."/".$this->encrypt->decode($token)."/".$explodedata[$a]."' target='_blank' class='btn btn-info btn-sm'>".$explodedata[$a]."</a><br>";
                            }
                          }
                        }
                      ?>
                      <tr>
                        <td><?php echo $querydata[$i]['report_type']; ?></td>
                        <td><?php echo date('F d, Y, H:i a', strtotime($querydata[$i]['datefeedback'])); ?></td>
                        <td><?php echo $querydata[$i]['remarks']; ?></td>
                        <td><?php echo $attachment; ?></td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
                </div>
              <?php }else{ ?>
                <div class="col-md-12" style="text-align:center;margin-top: 7px;">
                  <label><i>No feedbacks yet</i></label>
                </div>
              <?php } ?>
            </div>
          </div>
          <div class="col-md-12">
            <input type="hidden" name="token" class="form-control" value="<?php echo $token.'|'.$rn; ?>" readonly>
          </div>
          <div class="col-md-12"><hr>
            <label>Attachment: <i style="color:orange;" class="fa fa-info-circle" title="e.g Site update / current status of site"></i></label>
            <input type="file" id="site_photo_lgu" name="site_photo_lgu[]" class="form-control" accept="image/*" onchange="onsite_photo_lgu('<?php echo $token.'|'.$rn; ?>','<?php echo $token; ?>','<?php echo $rn; ?>');">
            <div class="progress" id="swsitephotolgu_" style="display:none; margin-top:5px;">
              <div class="progress-bar progress-bar-striped progress-bar-animated" id="swsitephotouploadprogressbar_" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                <span id="swsitephotoprogresspercentage_"></span>
              </div>
            </div>
          </div>
          <div id="dynamicdiv_"></div>
          <div class="col-md-12" style="margin-top:5px;">
            <label>Remarks:</label>
            <textarea class="form-control" name="remarks" rows="8" cols="80" required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-send"></i>&nbsp;Send</button>
        </div>
      </form>
      <script type="text/javascript">
        $(document).ready(function() {
          $('#lgufeedbackdttbl').DataTable({
            responsive: true,
            language: {
              "infoFiltered": "",
            },
          });
        } );
      </script>
    <?php
  }

  function dynamicdiv(){
    $token = $this->input->post('token', TRUE);
    $rn = $this->input->post('rn', TRUE);
    $wheredata = $this->db->where('sfl.trans_no = "'.$this->encrypt->decode($token).'" AND sfl.report_number = "'.$rn.'" AND sff.status = "Inactive"');
    $joindata = $this->db->join('embis.sweet_form_feedback AS sff','sff.trans_no = sfl.trans_no','left');
    $querydata = $this->SWM_model->selectdata('embis.sweet_form_log AS sfl','sfl.date_created, sfl.region, sff.attachments, sff.attachment_name,sff.cnt','',$joindata,$wheredata);
    $explodedata = explode('|',$querydata[0]['attachments']);
    $explodedataname = explode('|',$querydata[0]['attachment_name']);
    ?>
      <?php if(!empty($querydata[0]['attachments'])){ ?>
        <div class="col-md-12"><hr>
          <label>Recently uploaded image(s):</label><br>
          <?php for ($i=0; $i < count($explodedata); $i++) { ?>
            <?php if(!empty($explodedata[$i])){ ?>
              <div style="display:flex;">
                <a title="Click to view image" style="margin-bottom:5px; width: 80%;" href="<?php echo base_url().'../iis-images/sweet_report/'.date('Y', strtotime($querydata[0]['date_created'])).'/'.$querydata[0]['region'].'/'.$this->encrypt->decode($token).'/'.$explodedata[$i]; ?>" target="_blank" class="btn btn-info btn-sm"><?php echo $explodedataname[$i]; ?></a>
                <button type="button" onclick="removeimage('<?php echo $token; ?>','<?php echo $rn; ?>','<?php echo $this->encrypt->encode($explodedata[$i].'|'.$explodedataname[$i]); ?>');" style="margin-bottom:5px;margin-left:5px;width:20%;" class="btn btn-danger btn-sm">Remove</button>
              </div>
            <?php } ?>
          <?php } ?>
          <hr>
        </div>
      <?php } ?>
    <?php
  }

  function removeimage(){
    $token = $this->encrypt->decode($this->input->post('token', TRUE));
    $imagename = $this->encrypt->decode($this->input->post('imagename', TRUE));
    $rn = $this->input->post('rn', TRUE);

    $explodedata = explode('|',$imagename);
    $attachments = $explodedata[0];
    $attachment_name = $explodedata[1];

    $wheredata = $this->db->where('sff.trans_no = "'.$token.'" AND sff.status = "Inactive"');
    $querydata = $this->SWM_model->selectdata('embis.sweet_form_feedback AS sff','sff.attachments, sff.attachment_name','',$wheredata);

    $explodequerydata = explode('|',$querydata[0]['attachments']);
    $explodequerydataname = explode('|',$querydata[0]['attachment_name']);

    $attachmentss = "";
    $counter = 0;
    for ($i=0; $i < count($explodequerydata); $i++) {
      if($explodequerydata[$i] != $attachments){
        $counter++;
        $con = ($counter == 1) ? '' : '|';
        $attachmentss .= $con.$explodequerydata[$i];
      }
    }

    $attachmentssname = "";
    $countername = 0;
    for ($n=0; $n < count($explodequerydataname); $n++) {
      if($explodequerydataname[$n] != $attachment_name){
        $countername++;
        $conname = ($countername == 1) ? '' : '|';
        $attachmentssname .= $conname.$explodequerydataname[$n];
      }
    }

    $setdata = array('attachments' => $attachmentss, 'attachment_name' => $attachmentssname, );
    $wheredata = array('trans_no' => $token, 'status' => 'Inactive', );
    $updatedata = $this->SWM_model->updatedata($setdata, 'embis.sweet_form_feedback', $wheredata);
    if($deletedata){
      // $pathurl = base_url().'../iis-images/sweet_report/'.date('Y', strtotime($querydata[0]['date_created'])).'/'.$querydata[0]['region'].'/'.$token.'/'.$querydata[0]['attachments'];
      // unlink($pathurl);
    }
  }
}

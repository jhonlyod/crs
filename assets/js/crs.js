var Crs = {
  base_url: 'https://client.emb.gov.ph/crs/',
  ext_region: function(val) {

    $.ajax({
      url: Crs.base_url + 'Establishment/select_region',
      type: 'POST',
      data: {ext_region:val},
      success:function(response)
        {
        $('#select_province_id').html(response);
        }
    });
	},
  select_est:function(val){
    if (val == 0){
      $('#submit_req_btn').attr('disabled',true).hide();
      $('#new_est_container').show();
      $('#authorization_letter_label').hide();
      $('#selected_company_data').hide();
      $('#notatirized_template_id').hide();
    }else {
      $('#selected_company_data').show()
      $('#submit_req_btn').attr('disabled',true).show();
      $('#new_est_container').hide();
      $('#authorization_letter_label').show();
      $('#notatirized_template_id').show();
      $.ajax({
        url: Crs.base_url + 'Establishment/selected_company_data',
        type: 'POST',
        data: {est_id:val},
        success:function(response)
          {
            var comp_data = JSON.parse(response);
            $('#selected_company_data_region').html(comp_data[0].region_name);
            $('#selected_company_data_province').html(comp_data[0].province_name);
            $('#selected_company_data_city').html(comp_data[0].city_name);
            $('#selected_company_data_brgy').html(comp_data[0].barangay_name);
            $('#selected_company_street').html(comp_data[0].street);
            if (comp_data[0].street.length  == 1)
              $('#selected_company_street_container').show();
          }
      });
    }
  },select_main:function(val){
    $.ajax({
      url: Crs.base_url + 'Establishment/selected_company_data',
      type: 'POST',
      data: {est_id:val},
      success:function(response)
        {
          var comp_data = JSON.parse(response);
          $('#mother_company_data').show();
          $('#mother_company_data_region').html(comp_data[0].region_name);
          $('#mother_company_data_province').html(comp_data[0].province_name);
          $('#mother_company_data_city').html(comp_data[0].city_name);
          $('#mother_company_data_brgy').html(comp_data[0].barangay_name);
          $('#mother_company_street').html(comp_data[0].street);
          if (comp_data[0].street.length  == 1)
            $('#mother_company_street_container').show();
        }
    });
  },
  est_region: function(val) {
    $.ajax({
      url: Crs.base_url + 'Establishment/select_region',
      type: 'POST',
      data: {ext_region:val},
      success:function(response)
        {
        $('#est_province_id').html(response);
        $('#est_city_id option').remove();
        $('#est_barangay_id option').remove();
        }
    });
  },  est_province: function(val) {
      $.ajax({
        url: Crs.base_url + 'Establishment/select_province',
        type: 'POST',
        data: {est_province_id:val},
        success:function(response)
          {
          $('#est_city_id').html(response);
          $('#est_barangay_id option').remove();
          }
      });
    },
    est_city: function(val) {
      $.ajax({
        url: Crs.base_url + 'Establishment/select_city',
        type: 'POST',
        data: {est_city_id:val},
        success:function(response)
          {
          $('#est_barangay_id').html(response);
          }
      });
    },remove_request:function(val){
      if (confirm("Are you sure you want to delete")) {
        $.ajax({
          url: Crs.base_url + 'Dashboard/remove_request',
          type: 'POST',
          data: {req_id:val},
          success:function(response)
            {
               alert('Successfully deleted !')
               location.reload(true);
            }
        });
      }else {
        return false;
      }
    },resend_verification_email:function(client_id){
        $.ajax({
          url: Crs.base_url + 'Dashboard/resend_verification_email',
          type: 'POST',
          data: {client_id:client_id},
          success:function(response)
            {
              var newmsg = JSON.parse(response);
                if (newmsg.msg == 'sent') {
                  alert('Successfully sent !')
                  location.reload(true);
                }else {
                  alert('ERROR !');
                }

            }
        });
    },resend_hwms_email:function(client_req_id){
        $.ajax({
          url: Crs.base_url + 'Dashboard/resend_verification_hwms',
          type: 'POST',
          data: {client_req_id:client_req_id},
          success:function(response)
            {
              // console.log(response);die();
              var newmsg = JSON.parse(response);
                if (newmsg.msg == 'sent') {
                  alert('Successfully sent to "'+newmsg.email+'"!')
                  location.reload(true);
                }else {
                  alert('ERROR !');
                }

            }
        });
    }, add_main_company:function(main_company_id){

      if (!confirm('Are you sure you want to add this as main company ?')) {
        return false;
      }else {
        $.ajax({
          url: Crs.base_url +"/Establishment/add_main_company",
          type: 'POST',
          async : true,
          data: {
            "main_company_id": main_company_id,
          },
          success:function(response)
          {
            var obj = JSON.parse(response);
            $('#add_main_company_name').val(obj[0]['company_name']);
            $('#add_main_company_id').val(obj[0]['company_id']);
            $('#add_main_company_modal').modal('hide');
          }
        });
      }
    },view_dissapproved_data:function(req_id){
      $.ajax({
        url: Crs.base_url +"/Dashboard/view_dissapproved_data",
        type: 'POST',
        async : true,
        data: {
          "req_id": req_id,
        },
        success:function(response)
        {
          $('#view_dissapproved_data_container').text(response)
          // var obj = JSON.parse(response);
        }
      });
    },select_existing_company:function(value){
      $('#selected_company_id').val(value);
    },view_company_permits:function(value,event){
      $('#upload_new_req_id').val(value);
      Crs.get_permits_per_establishment_attachments(value);
  },select_permit_type_per_establishment:function(file_id,file_directory_id,permit_no_id,permit_unq_no_id,type,el){
    var fileName = el.getAttribute('data-name');
    $('#file_directory_id').val(file_directory_id);
    $('#file_id').val(file_id);
    $('#permit_no_id').val(permit_no_id);
    $('.custom-file-label').text(fileName);
    $('#old_file_name_id').val(fileName);
    $('#permit_unq_no_id').val(permit_unq_no_id);
    $('#permit_type_id').val(type);
  },update_permit_per_establishment:function(permit_type){
    // alert(1);die();
      var file_directory_id = $('#file_directory_id').val();
      var file_id = $('#file_id').val();
      var permit_unq_no_id = $('#permit_unq_no_id').val();
      var permit_no_id = $('#permit_no_id').val();
      var permit_type = $('#permit_type_id').val();
      var old_file_name_id =   $('#old_file_name_id').val();
      var form_data = new FormData();

      // Read selected files
      var totalfiles = document.getElementById('uploadpermitfile').files.length;
      if(totalfiles > 0){
        for (var index = 0; index < totalfiles; index++) {
          form_data.append("uploadpermitfile[]", document.getElementById('uploadpermitfile').files[index]);
        }
        form_data.append("permit_type", permit_type);
        form_data.append("file_directory_id", file_directory_id);
        form_data.append("file_id", file_id);
        form_data.append("permit_unq_no_id", permit_unq_no_id);
        form_data.append("permit_no_id", permit_no_id);
        form_data.append("old_file_name", old_file_name_id);
        // AJAX request
        $.ajax({
         url: Crs.base_url+'/Establishment_/upload_permits',
         type: 'post',
         data: form_data,
         cache: false,
         contentType: false,
         processData: false,
         success: function (response) {
           // console.log(response);die();
           if(response == 'success'){
             var value = $('#file_directory_id').val();
             var current_url = window.location.href;

             if (current_url = Crs.base_url+'Establishment_/check_permits_apr_establishment/'+file_directory_id) {
                 Crs.get_permits_per_apr_establishment_attachments(value);
             }else {
               Crs.get_permits_per_establishment_attachments(value);
             }
              // Crs.get_permits_per_establishment_attachments(value);
           }else if(response == 'failed'){
             alert('Error! Please try again.');
           }else if(response == 'empty'){
             alert('Please attach file.');
           }else if(response == 'error'){
             alert('Some went wrong. Please contact administrator !');
           }else {
              alert('Some went wrong. Please contact administrator !');
           }
         }
        });
      }else{
        alert('Please attach file(s).');
      }
    },upload_new_attachment:function(permit_type,el){
      var req_id = $('#upload_new_req_id').val();
      var form_data = new FormData();
      if (permit_type == 1) {
        var dp_no = $('#multiCollapseExample'+req_id+' [name ="dp_no"]').val();
        form_data.append("dp_no", dp_no);
        var totalfiles = $('#multiCollapseExample'+req_id+' #uploadpermitnewdp')[0].files.length;
        form_data.append('uploadpermitnewfile[]', $('#multiCollapseExample'+req_id+' #uploadpermitnewdp')[0].files[0]);
      }

      if (permit_type == 2) {
        var cnc_no = $('#multiCollapseExample'+req_id+' [name ="cnc_no"]').val();
        form_data.append("cnc_no", cnc_no);
        var totalfiles = $('#multiCollapseExample'+req_id+' #uploadpermitnewcnc')[0].files.length;
        form_data.append('uploadpermitnewfile[]', $('#multiCollapseExample'+req_id+' #uploadpermitnewcnc')[0].files[0]);

      }

      if (permit_type == 3) {
        var ecc_no = $('#multiCollapseExample'+req_id+' [name ="ecc_no"]').val();
        form_data.append("ecc_no", ecc_no);
        var totalfiles = $('#multiCollapseExample'+req_id+' #uploadpermitnewecc')[0].files.length;
        form_data.append('uploadpermitnewfile[]', $('#multiCollapseExample'+req_id+' #uploadpermitnewecc')[0].files[0]);

      }

      if (permit_type == 4) {
        var po_no = $('#multiCollapseExample'+req_id+' [name ="po_no"]').val();
        form_data.append("po_no", po_no);
        var totalfiles = $('#multiCollapseExample'+req_id+' #uploadpermitnewpo')[0].files.length;
        form_data.append('uploadpermitnewfile[]', $('#multiCollapseExample'+req_id+' #uploadpermitnewpo')[0].files[0]);

      }


      if(totalfiles > 0){
        form_data.append("permit_type", permit_type);
        form_data.append("req_id", req_id);

        $.ajax({
         url: Crs.base_url+'/Establishment_/upload_new_permits',
         type: 'post',
         data: form_data,
         // dataType: 'json',
         cache: false,
         contentType: false,
         processData: false,
         success: function (response) {
           if(response == 'success'){
            Crs.get_permits_per_establishment_attachments(req_id);
            $("#uploadpermitnewdp").val(null);
            $('[name ="dp_no"]').val('');
            $("#uploadpermitnewdp").val(null);
           }else if(response == 'failed'){
             alert('Error! Please try again.');
           }else if(response == 'empty'){
             alert('Please attach file.');
           }
         }
        });
      }else{
        alert('Please attach file(s).');
      }
    },get_permits_per_establishment_attachments:function(id){
      $.ajax({
        url: Crs.base_url +"/Establishment_/get_permits_per_establishment_attachments",
        type: 'POST',
        async : true,
        data: {
          "est_id": id,
        },
        success:function(response)
        {
          var htmldp = '';
          var htmlcnc = '';
          var htmlecc = '';
          var htmlpo = '';
          var parse_data = JSON.parse(response);
          var dp_data = parse_data.dp;
          var cnc_data = parse_data.cnc;
          var ecc_data = parse_data.ecc;
          var po_data = parse_data.po;
          // console.log(po_data);
          if (dp_data.length <= 0 || cnc_data.length <= 0 || ecc_data.length <= 0 || po_data.length <= 0) {
            $('.dp_section-options').show();
            $('.cnc_status-options').show();
            $('.ecc_section-options').show();
            $('.po_section-options').show();
          }else {
             $('.dp_section-options').hide();
              $('.cnc_status-options').hide();
              $('.po_section-options').hide();
              $('.ecc_section-options').hide();
          }

          for (var i = 0; i < dp_data.length; i++) {
             htmldp += '<div class="form-group row" > <div class="col-md-8"> <input readonly type="text" class="form-control" name="dp_no[]" value="'+dp_data[i]['dp_no']+'" placeholder="DP NO."> </div><div class="col-md-2 attch_perm_name"> <a href="'+Crs.base_url+'/uploads/new_permits/dp/'+dp_data[i]['req_id']+'/'+dp_data[i]['file_name']+'" target="_blank">DP-FILE-'+i+'</a> </div><div class="col-md-1"><button type="button" name="button" style="float:right" data-toggle="modal" data-name='+dp_data[i]['file_name']+' onClick="Crs.select_permit_type_per_establishment('+dp_data[i]['dp_permit_id']+','+dp_data[i]['req_id']+','+dp_data[i]['dp_no']+','+dp_data[i]['dp_no_id']+',1,this)" data-target="#update_permit_attachment_modal" class="btn-primary dp_btn" value="dp_section-row41106"><i class="fa fa-edit" aria-hidden="true"></i></button></div></div>';
          }
            $('#multiCollapseExample'+id+' .multiple_dp_permits_data').html(htmldp);

          for (var i = 0; i < cnc_data.length; i++) {
             htmlcnc += '<div class="form-group row cnc_section-row"> <div class="col-md-8"> <input readonly type="text" class="form-control" name="cnc_no_file[]" value="'+cnc_data[i]['cnc_no']+'" placeholder="DP NO."> </div><div class="col-md-2 attch_perm_name"> <a href="'+Crs.base_url+'/uploads/new_permits/cnc/'+cnc_data[i]['req_id']+'/'+cnc_data[i]['file_name']+'" target="_blank">CNC-FILE-'+i+'</a></div><div class="col-md-1"><button type="button" name="button" style="float:right" data-toggle="modal" data-name='+cnc_data[i]['file_name']+' onClick="Crs.select_permit_type_per_establishment('+cnc_data[i]['cnc_permit_id']+','+cnc_data[i]['req_id']+','+cnc_data[i]['cnc_no']+','+cnc_data[i]['cnc_no_id']+',2,this)" data-target="#update_permit_attachment_modal" class="btn-primary cnc_btn" value="cnc_section-row41106"><i class="fa fa-edit" aria-hidden="true"></i></button></div></div> </div></div>';

          }
            $('#multiCollapseExample'+id+' .multiple_cnc_permits_data').html(htmlcnc);

          for (var i = 0; i < ecc_data.length; i++) {
             htmlecc+='<div class="form-group row ecc_section-row"> <div class="col-md-8"> <input readonly type="text" class="form-control" name="ecc_no_file[]" value="'+ecc_data[i]['ecc_no']+'" placeholder="ECC NO."> </div><div class="col-md-2 attch_perm_name"> <a href="'+Crs.base_url+'/uploads/new_permits/ecc/'+ecc_data[i]['req_id']+'/'+ecc_data[i]['file_name']+'" target="_blank">ECC-FILE-'+i+'</a></div><div class="col-md-1"><button type="button" name="button" style="float:right" data-toggle="modal" data-name='+ecc_data[i]['file_name']+' onClick="Crs.select_permit_type_per_establishment('+ecc_data[i]['ecc_permit_id']+','+ecc_data[i]['req_id']+','+ecc_data[i]['ecc_no']+','+ecc_data[i]['ecc_no_id']+',3,this)" data-target="#update_permit_attachment_modal" class="btn-primary cnc_btn" value="cnc_section-row41106"><i class="fa fa-edit" aria-hidden="true"></i></button></div></div></div></div></div></div>';
          }
            $('#multiCollapseExample'+id+' .multiple_ecc_permits_data').html(htmlecc);
            // console.log(po_data);
          for (var i = 0; i < po_data.length; i++) {
              htmlpo+=' <div class="form-group row po_section-row"> <div class="col-md-8"> <input readonly type="text" class="form-control" name="ecc_no_file[]" value="'+po_data[i]['po_no']+'" placeholder="ECC NO."> </div><div class="col-md-2 attch_perm_name"> <a href="'+Crs.base_url+'/uploads/new_permits/po/'+po_data[i]['req_id']+'/'+po_data[i]['file_name']+'" target="_blank">PO-FILE</a> </div><div class="col-md-1"><button type="button" name="button" style="float:right" data-toggle="modal" data-name='+po_data[i]['file_name']+' onClick="Crs.select_permit_type_per_establishment('+po_data[i]['po_permit_id']+','+po_data[i]['req_id']+','+po_data[i]['po_no']+','+po_data[i]['po_no_id']+',4,this)" data-target="#update_permit_attachment_modal" class="btn-primary cnc_btn" value="cnc_section-row41106"><i class="fa fa-edit" aria-hidden="true"></i></button></div></div>';

          }
            $('#multiCollapseExample'+id+' .multiple_po_permits_data').html(htmlpo);

            $("#update_dp_permit_messsage").show();
            setTimeout(function() { $("#update_dp_permit_messsage").hide(); }, 5000);
        }
      });
    },view_apr_company_permits:function(value,event){
      $('#upload_new_req_id').val(value);
      Crs.get_permits_per_apr_establishment_attachments(value);
    },upload_new_attachment_apr_est:function(permit_type,el){
      var req_id = $('#upload_new_req_id').val();
      // console.log(req_id);
      var form_data = new FormData();
      if (permit_type == 1) {
        var dp_no = $('#multiCollapseExample'+req_id+' [name ="dp_no"]').val();
        form_data.append("dp_no", dp_no);
        var totalfiles = $('#multiCollapseExample'+req_id+' #uploadpermitnewdp')[0].files.length;
        var inputdata = $('#multiCollapseExample'+req_id+' input[name="dp_no"]').val();
        form_data.append('uploadpermitnewfile[]', $('#multiCollapseExample'+req_id+' #uploadpermitnewdp')[0].files[0]);
      }

      if (permit_type == 2) {
        var cnc_no = $('#multiCollapseExample'+req_id+' [name ="cnc_no"]').val();
        form_data.append("cnc_no", cnc_no);
        var totalfiles = $('#multiCollapseExample'+req_id+' #uploadpermitnewcnc')[0].files.length;
            var inputdata = $('#multiCollapseExample'+req_id+' input[name="cnc_no"]').val();
        form_data.append('uploadpermitnewfile[]', $('#multiCollapseExample'+req_id+' #uploadpermitnewcnc')[0].files[0]);

      }

      if (permit_type == 3) {
        var ecc_no = $('#multiCollapseExample'+req_id+' [name ="ecc_no"]').val();
        form_data.append("ecc_no", ecc_no);
        var totalfiles = $('#multiCollapseExample'+req_id+' #uploadpermitnewecc')[0].files.length;
        var inputdata = $('#multiCollapseExample'+req_id+' input[name="ecc_no"]').val();
        form_data.append('uploadpermitnewfile[]', $('#multiCollapseExample'+req_id+' #uploadpermitnewecc')[0].files[0]);

      }

      if (permit_type == 4) {
        var po_no = $('#multiCollapseExample'+req_id+' [name ="po_no"]').val();
        form_data.append("po_no", po_no);
        var totalfiles = $('#multiCollapseExample'+req_id+' #uploadpermitnewpo')[0].files.length;
        var inputdata = $('#multiCollapseExample'+req_id+' input[name="po_no"]').val();
        form_data.append('uploadpermitnewfile[]', $('#multiCollapseExample'+req_id+' #uploadpermitnewpo')[0].files[0]);

      }


      if(totalfiles > 0 && inputdata != ''){
        form_data.append("permit_type", permit_type);
        form_data.append("req_id", req_id);

        $.ajax({
         url: Crs.base_url+'/Establishment_/upload_new_permits',
         type: 'post',
         data: form_data,
         // dataType: 'json',
         cache: false,
         contentType: false,
         processData: false,
         success: function (response) {
           console.log(response);
           if(response == 'success'){
            Crs.get_permits_per_apr_establishment_attachments(req_id);
            $("#uploadpermitnewdp").val(null);
            $('[name ="dp_no"]').val('');
            $("#uploadpermitnewdp").val(null);
           }else if(response == 'failed'){
             alert('Error! Please try again.');
           }else if(response == 'empty'){
             alert('Please attach file.');
           }
         }
        });
      }else{
        alert('Please fill all the required fields!');
      }
    },get_permits_per_apr_establishment_attachments:function(id){
      $.ajax({
        url: Crs.base_url +"/Establishment_/get_permits_per_apr_establishment_attch",
        type: 'POST',
        async : true,
        data: {
          "req_id": id,
        },
        success:function(response)
        {
          var htmldp = '';
          var htmlcnc = '';
          var htmlecc = '';
          var htmlpo = '';
          var parse_data = JSON.parse(response);
          var dp_data = parse_data.dp;
          var cnc_data = parse_data.cnc;
          var ecc_data = parse_data.ecc;
          var po_data = parse_data.po;
          // console.log(dp_data);
          if (dp_data.length <= 0 || cnc_data.length <= 0 || ecc_data.length <= 0 || po_data.length <= 0) {
            $('.dp_section-options').show();
            $('.cnc_status-options').show();
            $('.ecc_section-options').show();
            $('.po_section-options').show();
          }else {
             $('.dp_section-options').hide();
              $('.cnc_status-options').hide();
              $('.po_section-options').hide();
              $('.ecc_section-options').hide();
          }

          for (var i = 0; i < dp_data.length; i++) {
             htmldp += '<div class="form-group row" > <div class="col-md-8"> <input readonly type="text" class="form-control" name="dp_no[]" value="'+dp_data[i]['dp_no']+'" placeholder="DP NO."> </div><div class="col-md-2 attch_perm_name"> <a href="'+Crs.base_url+'/uploads/new_permits/dp/'+dp_data[i]['req_id']+'/'+dp_data[i]['file_name']+'" target="_blank">DP-FILE-'+i+'</a> </div><div class="col-md-1"><button type="button" name="button" style="float:right" data-toggle="modal" data-name='+dp_data[i]['file_name']+' onClick="Crs.select_permit_type_per_establishment('+dp_data[i]['dp_permit_id']+','+dp_data[i]['req_id']+','+dp_data[i]['dp_no']+','+dp_data[i]['dp_no_id']+',1,this)" data-target="#update_permit_attachment_modal" class="btn-primary dp_btn" value="dp_section-row41106"><i class="fa fa-edit" aria-hidden="true"></i></button></div></div>';
          }
            $('#multiCollapseExample'+id+' .multiple_dp_permits_data').html(htmldp);

          for (var i = 0; i < cnc_data.length; i++) {
             htmlcnc += '<div class="form-group row cnc_section-row"> <div class="col-md-8"> <input readonly type="text" class="form-control" name="cnc_no_file[]" value="'+cnc_data[i]['cnc_no']+'" placeholder="DP NO."> </div><div class="col-md-2 attch_perm_name"> <a href="'+Crs.base_url+'/uploads/new_permits/cnc/'+cnc_data[i]['req_id']+'/'+cnc_data[i]['file_name']+'" target="_blank">CNC-FILE-'+i+'</a></div><div class="col-md-1"><button type="button" name="button" style="float:right" data-toggle="modal" data-name='+cnc_data[i]['file_name']+' onClick="Crs.select_permit_type_per_establishment('+cnc_data[i]['cnc_permit_id']+','+cnc_data[i]['req_id']+','+cnc_data[i]['cnc_no']+','+cnc_data[i]['cnc_no_id']+',2,this)" data-target="#update_permit_attachment_modal" class="btn-primary cnc_btn" value="cnc_section-row41106"><i class="fa fa-edit" aria-hidden="true"></i></button></div></div> </div></div>';

          }
            $('#multiCollapseExample'+id+' .multiple_cnc_permits_data').html(htmlcnc);

          for (var i = 0; i < ecc_data.length; i++) {
             htmlecc+='<div class="form-group row ecc_section-row"> <div class="col-md-8"> <input readonly type="text" class="form-control" name="ecc_no_file[]" value="'+ecc_data[i]['ecc_no']+'" placeholder="ECC NO."> </div><div class="col-md-2 attch_perm_name"> <a href="'+Crs.base_url+'/uploads/new_permits/ecc/'+ecc_data[i]['req_id']+'/'+ecc_data[i]['file_name']+'" target="_blank">ECC-FILE-'+i+'</a></div><div class="col-md-1"><button type="button" name="button" style="float:right" data-toggle="modal" data-name='+ecc_data[i]['file_name']+' onClick="Crs.select_permit_type_per_establishment('+ecc_data[i]['ecc_permit_id']+','+ecc_data[i]['req_id']+','+ecc_data[i]['ecc_no']+','+ecc_data[i]['ecc_no_id']+',3,this)" data-target="#update_permit_attachment_modal" class="btn-primary cnc_btn" value="cnc_section-row41106"><i class="fa fa-edit" aria-hidden="true"></i></button></div></div></div></div></div></div>';
          }
            $('#multiCollapseExample'+id+' .multiple_ecc_permits_data').html(htmlecc);
            // console.log(po_data);
          for (var i = 0; i < po_data.length; i++) {
              htmlpo+=' <div class="form-group row po_section-row"> <div class="col-md-8"> <input readonly type="text" class="form-control" name="ecc_no_file[]" value="'+po_data[i]['po_no']+'" placeholder="ECC NO."> </div><div class="col-md-2 attch_perm_name"> <a href="'+Crs.base_url+'/uploads/new_permits/po/'+po_data[i]['req_id']+'/'+po_data[i]['file_name']+'" target="_blank">PO-FILE</a> </div><div class="col-md-1"><button type="button" name="button" style="float:right" data-toggle="modal" data-name='+po_data[i]['file_name']+' onClick="Crs.select_permit_type_per_establishment('+po_data[i]['po_permit_id']+','+po_data[i]['req_id']+','+po_data[i]['po_no']+','+po_data[i]['po_no_id']+',4,this)" data-target="#update_permit_attachment_modal" class="btn-primary cnc_btn" value="cnc_section-row41106"><i class="fa fa-edit" aria-hidden="true"></i></button></div></div>';

          }
            $('#multiCollapseExample'+id+' .multiple_po_permits_data').html(htmlpo);

            $("#update_dp_permit_messsage").show();
            setTimeout(function() { $("#update_dp_permit_messsage").hide(); }, 5000);
        }
      });
    }

}

 <?php  echo $banner;?>
<div id="content-wrapper" class="d-flex flex-column">
  <div id="content">
     <div class="container">
       <?php echo $tabs_menu ?>

       <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary text-center">DOCUMENTS</h6>
       </div>
       <div class="col-xl-12 mb-3">
           <div class="add_comp_label">Please attached the following ID's: COMPANY,GOVERNMENT,AUTHORIZATION LETTER</div>
           <div class="col-md-12" style="margin-top:10px;">
             <div class="row">
               <div class="form-group erattdropzone" style="border:1px solid; border: 1px solid #D1D3E2;padding: 0px 0px 0px 10px;width: 100%;border-radius:5px;">
                 <label>Attachment:</label><span class="set_note"> (max. 20mb / file)</span><br />
                 <span class="set_note">* please upload attachment(s)</span>
                 <div id="actions" class="row">
                     <div class="col-md-12">
                       <button type="button" class="btn btn-outline-primary btn-sm fileinput-button">
                         <i class="fas fa-plus-circle"></i>
                         <span>Add Files</span>
                       </button>
                       <button type="button" class="btn btn-outline-info btn-sm start">
                         <i class="fas fa-upload"></i>
                         <span>Upload All</span>
                       </button>
                       <button type="button" class="btn btn-outline-danger btn-sm cancel">
                         <i class="fas fa-times-circle"></i>
                         <span>Remove All</span>
                       </button>
                     </div>

                     <div class="col-lg-5">
                       <!-- The global file processing state -->
                       <span class="fileupload-process">
                         <div id="total-progress" class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                           <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress=""></div>
                         </div>
                       </span>
                     </div>
                 </div>

                 <div class="table table-striped dropzone_table upload_div files" id="previews">
                     <div id="att_template" class="file-row dz-image-preview row">
                         <!-- file name, and error message -->
                         <div class="col-md-5">
                           <p class="name" data-dz-name></p>
                           <strong class="error text-danger" data-dz-errormessage></strong>
                         </div>
                         <!-- file size, and progress bar -->
                         <div class="col-md-4">
                           <p class="size" data-dz-size></p>
                           <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                             <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                           </div>
                         </div>
                         <!-- file upload, remove, and delete button -->
                         <div class="col-md-3">
                             <button type="button" class="btn btn-outline-info btn-sm start">
                               <i class="fas fa-upload"></i>
                             </button>
                             <button data-dz-remove type="button" class="btn btn-outline-warning btn-sm cancel">
                               <i class="fas fa-window-close"></i>
                             </button>
                             <button data-dz-remove type="button" class="btn btn-outline-danger btn-sm delete">
                               <i class="fas fa-trash"></i>
                             </button>
                         </div>
                     </div>
                 </div>

               </div>
             </div>
           </div>
       </div>
     </div>
   </div>
</div>
<script src="<?php echo base_url(); ?>assets/dropzone/dropzone.js"></script>
<script type="text/javascript">
      Dropzone.autoDiscover = false;
      $(document).ready(function() {
        //Dropzone
        // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
        var previewNode = document.querySelector("#att_template");
        previewNode.id = "";
        var previewTemplate = previewNode.parentNode.innerHTML;
        previewNode.parentNode.removeChild(previewNode);

        var myDropzone = new Dropzone("div.erattdropzone", { // Make the whole body a dropzone
          url: "<?php echo base_url('Company/Add_company/fileUpload'); ?>", // Set the url
          params: {

          },
          maxFilesize: 20,
          parallelUploads: 20,
          timeout: 0,
          acceptedFiles: "image/*",
          previewTemplate: previewTemplate,
          autoQueue: false, // Make sure the files aren't queued until manually added
          previewsContainer: "#previews", // Define the container to display the previews
          clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
        });


        myDropzone.on("addedfile", function(file) {
          // Hookup the start button
          file.previewElement.querySelector(".start").onclick = function() { myDropzone.enqueueFile(file); };
        });

        // Update the total progress bar
        myDropzone.on("totaluploadprogress", function(progress) {
          document.querySelector("#total-progress .progress-bar").style.width = progress + "%";
        });

        myDropzone.on("sending", function(file,xhr, formData) {

          formData.append('attachment_token', jQuery('#attachment_token_id').val());
          // Show the total progress bar when upload starts
          document.querySelector("#total-progress").style.opacity = "1";
          // And disable the start button
          file.previewElement.querySelector(".start").setAttribute("disabled", "disabled");
        });

        // Hide the total progress bar when nothing's uploading anymore
        myDropzone.on("queuecomplete", function(progress) {
          document.querySelector("#total-progress").style.opacity = "0";
        });

        // for deleting uploaded file
        myDropzone.on("success", function(file, response) {
          $(file.previewTemplate).append('<span class="server_file" style="display:none">'+response+'</span>');
        });
        myDropzone.on("removedfile", function(file) {
          var server_file = $(file.previewTemplate).children('.server_file').text();
          var base_url = '<?php echo base_url(); ?>';
          $.post(base_url+"Comapany/Add_company/removeuploadedfile", { file_to_be_deleted: server_file } );
        });

        // Setup the buttons for all transfers
        // The "add files" button doesn't need to be setup because the config
        // `clickable` has already been specified.
        document.querySelector("#actions .start").onclick = function() {
          myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED));
        };
        document.querySelector("#actions .cancel").onclick = function() {
          myDropzone.removeAllFiles(true);
        };

      });

  </script>

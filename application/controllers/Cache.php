<?php
   class Cache extends CI_Controller
   {

      public function index() {
         $this->output->cache(1);
         $this->load->view('cache_view');
      }

      public function delete_file_cache() {
         $this->output->delete_cache('cache'); 
      }
   }
?>

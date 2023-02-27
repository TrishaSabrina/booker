 <?php $this->load->view('templates/header');?>
 <!-- container --> 
  <section class="showcase">
    <div class="container">
      <div class="pb-2 mt-4 mb-2 border-bottom">
        <h2>Integrate Google Calendar API with Codeigniter Calendar Library</h2>
      </div>
      <div class="pb-2 mt-4 mb-2 border-bottom">
        <a href="javascript:void(0);" data-toggle="modal" data-target="#gc-create-event" data-year="<?php print date('Y', time()); ?>" data-month="<?php print date('m', time()); ?>" data-days="<?php print date('d', time()); ?>"  class="add-gc-event btn btn-sm btn-primary">Create Event</a>
        <a href="<?php print site_url();?>gc/auth/logout" class="add-gc-event btn btn-sm btn-danger">Logout</a>
      </div>
      <span id="success-msg"></span>       
      <div id="event-calendar">
     <div class="text-center"><i class="fa fa-spinner fa-pulse fa-5x fa-fw"></i></div>
   </div>
    
    </div>
  </section>
<?php $this->load->view('google-calendar/popup/event');?>   
<?php $this->load->view('google-calendar/popup/create');?>      
<?php $this->load->view('templates/footer');?>        

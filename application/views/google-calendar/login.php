
 <!-- container --> 
  <section class="showcase">
    <div class="container">
      <div class="pb-2 mt-4 mb-2 border-bottom">
        <h2>Integrate Google Calendar API with Codeigniter Calendar Library</h2>
      </div> 
      <form action="<?php print site_url();?>auth/doLogin" class="remember-login-frm" id="remember-login-frm" method="post" accept-charset="utf-8" enctype="multipart/form-data">
      <div class="row justify-content-center">
		<div class="col-12 col-md-8 col-lg-6 pb-5">
		      <div class="row"><?php echo validation_errors('<div class="col-12 col-md-12 col-lg-12"><div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert">&times;</button>', '</div></div>'); ?></div>
            <!--Form with header-->
            <div class="card border-info rounded-0">
                <div class="card-header p-0">
                    <div class="bg-info text-white text-center py-2">
                        <h3><i class="fab fa-google-plus-g"></i> Login</h3> 
                    </div>
                </div>
                <div class="card-body p-3">                
                    <div class="text-center">
                        <a href="<?php print $loginUrl; ?>" id="contact-send-a" class="btn btn-danger btn-block rounded-0 py-2"><i class="fab fa-google-plus-g"></i> Login with Google</a>
                    </div>
                    
                </div>
            </div> 
          </div>
        </div>
    </form>
    </div>
  </section>     

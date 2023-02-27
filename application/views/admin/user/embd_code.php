<?php
$business_slug = $this->business->slug;
function getEmbeddedCode($business_slug){
  $tmpHostname = base_url();
  ob_start();
  ?>

<!-- embed code start -->
<section class="embed-container" data-slug="<?php echo $business_slug; ?>" data-url="<?php echo base_url() ?>"></section>
<script type="text/javascript" src="<?php echo $tmpHostname; ?>assets/embed/embed.js" ></script>
<!-- end embed code-->

<?php
  $ret = ob_get_clean();
  //die($ret);
  return $ret;
}
?>
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <?php $this->load->view('admin/include/breadcrumb'); ?>

    <!-- Main content -->
    <div class="content">
      <div class="container">
        <div class="row">

            <?php $this->load->view('admin/user/include/settings_menu.php'); ?>

            <div class="col-lg-9 pl-3">
                <div class="card">
                    <?php if (isset($page_title) && $page_title == 'Embedded Settings'): ?>
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                              <p class="lead"><span class="badge badge-secondary-soft btn-clipboard2"  data-id="embeddedCodeTextContainer"><i class="far fa-code"></i> <?php echo trans('embed-code-copy') ?></span></p>

                              <div class="bd-clipboard"><button type="button" class="btn-clipboard btn btn-outline-primary btn-sm" title="<?php echo trans('copy'); ?>" data-id="embeddedCodeTextContainer" data-title2=" <?php echo trans('copied');?>" data-original-title="Copy to clipboard"><i class="far fa-clone"></i> <?php echo trans('copy');?></button></div>
                            </div>
                            
                            <div class="highlight bg-light mt-3"><pre class="chroma"><code class="language-html text-dark" data-lang="html" id="embeddedCodeTextContainer">

                              <?php echo htmlspecialchars(getEmbeddedCode($business_slug)); ?></code></pre></div>

                            <p class="mb-3 lead"><span class="badge badge-success-soft badge-pill fs-16"><i class="fas fa-eye"></i> <?php echo trans('preview') ?></span></p>
                            <div class="mcontainer">
                              <div class="mrow">
                                <div class="mcolumn mleft">
                                  <span class="mdot" style="background:#ED594A;"></span>
                                  <span class="mdot" style="background:#FDD800;"></span>
                                  <span class="mdot" style="background:#5AC05A;"></span>
                                </div>
                                <div class="mcolumn mmiddle">
                                  <span class="mUrlText"><?php if(isset($business_slug)){echo base_url($business_slug);} ?></span>
                                </div>
                                <div class="mcolumn mright">
                                  <div style="float:right">
                                    <span class="mbar"></span>
                                    <span class="mbar"></span>
                                    <span class="mbar"></span>
                                  </div>
                                </div>
                              </div>

                              <div class="mcontent">
<?php echo getEmbeddedCode($business_slug); ?>
                              </div>
                            </div>
                            <!-- <div class="row">
                              <div class="col-12"><?php //echo getEmbeddedCode('ez_user'); ?></div>
                            </div> -->
                        </div>
                    <?php else: ?>
                        <div class="card-body">
                            <p class="lead"><span class="badge badge-secondary-soft"><i class="fas fa-share-alt"></i> <?php echo trans('share-qr-code') ?></span></p>
                            <img class="img-thumbnail opacity-40" src="<?php echo base_url($company->qr_code) ?>">

                            <p class="mt-3"><a href="<?php echo base_url('admin/settings/download_qrcode') ?>" class="btn btn-primary btn-sm"><i class="lni lni-cloud-download"></i> <?php echo trans('download') ?></a></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>

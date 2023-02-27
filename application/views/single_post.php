<section class="pt-8">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="service-banner-img" style="background-image: url(<?php echo base_url($post->image) ?>);"></div>
                <h2 class="mb-5 mt-3"><?php echo html_escape($post->title) ?></h2>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-9">
                <article>
                    <p><?= ($post->details) ?></p>
					<?php if (!empty($tags)): ?>
						<div class="my-6 my-md-11">
							<div class="h5"><?php echo trans('tags') ?>:</div>
							<?php foreach ($tags as $tag): ?>
								<a href="#" class="badge badge-light">#<?php echo html_escape($tag->tag) ?></a>
							<?php endforeach ?>
						</div>
					<?php endif ?>

                    <!-- Comments -->
                    <?php if (!empty($comments)): ?>
		                <div class="w-100 w-lg-90 my-6 my-lg-9">
		                    <h3>Comments - <?php echo html_escape(count($comments)) ?></h3>
		                    <ul class="m-0 p-0">
		                        <?php foreach ($comments as $comment): ?>
			                        <li class="media mt-6">
			                            <a href="#">
			                                <img class="sm-avatar mr-3 border-light rounded-circle" src="<?php echo base_url() ?>assets/images/avatar.png" alt="...">
			                            </a>
			                            <div class="media-body">
			                                <h4 class="h6 mb-1"><?php echo html_escape($comment->name); ?> <span class="small ml-2 text-muted"><?php echo get_time_ago($comment->created_at); ?></span></h4>
			                                <p class="mb-1">
			                                    <?php echo html_escape($comment->message); ?>
			                                </p>
			                            </div>
			                        </li>
		                        <?php endforeach ?>
		                    </ul>
		                </div>
	            	<?php endif ?>
	                <!-- End Comments -->
                </article>


                <div class="w-100 w-md-90">
                    <h3><?php echo trans('leave-a-reply') ?></h3>
                    <!-- Form -->
                    <form method="post" action="<?php echo base_url('home/send_comment/'.html_escape($post->id)); ?>">
                        <div class="form-row">
                            <div class="col-sm">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="name" placeholder="Your Name">
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="form-group">
                                    <input type="email" class="form-control" name="email" placeholder="Email Address" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <textarea name="message" rows="6" class="form-control" placeholder="Your message" required></textarea>
                        </div>
                        <div>
                        	<!-- csrf token -->
          					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                            <button class="btn btn-primary btn-wide" type="submit"><?php echo trans('submit') ?></button>
                        </div>
                    </form>
                    <!-- End Form -->
                </div>
            </div>
        </div>
    </div>
</section>





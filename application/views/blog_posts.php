
<section class="pt-6">
	<div class="container">
		<?php if (empty($posts)): ?>
			<div class="row align-items-center justify-content-center">
				<div class="col-lg-10 col-xl-8 text-center">
               		<?php include'include/not_found_msg.php'; ?>
               	</div>
            </div>
		<?php else: ?>

		<div class="row align-items-center justify-content-center">
			<div class="col-lg-10 col-xl-8 text-center">
				<h2 class="mb-1 custom-font"><?php echo trans('blog-news') ?></h2>
				<p class="mb-5 w-90 w-md-70 mx-auto"><?php echo trans('learn-more-empower-yourself') ?></p>
				<form class="w-sm-90 mx-auto mx-lg-0 rounded-pill pl-4 pr-0 newsletter-form bg-white mb-4" action="<?php echo base_url('blogs') ?>">
                    <div class="input-group">
                        <input type="text" class="form-control border-0 pl-0 pr-2" name="search" placeholder="<?php echo trans('search-blog-posts') ?>">
                        <div class="input-group-append">
                            <button class="btn btn-white text-secondary m-0 px-4" type="submit"><i class="lni lni-search-alt"></i></button>
                        </div>
                    </div>
                </form>
			</div>
		</div>

		<div class="row">
			<?php $b=1; foreach ($posts as $post): ?>
                <?php include'include/blog_post_item.php'; ?>
            <?php $b++; endforeach ?>
		</div>

		<div class="mt-8 mt-lg-10">
			<?php echo $this->pagination->create_links(); ?>
		</div>

		<?php endif; ?>

	</div>
</section>
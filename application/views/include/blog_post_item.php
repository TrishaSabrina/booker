<div class="col-md-6 col-lg-4 mb-4 mb-md-5 mb-lg-0 mt-6">
    <article class="card shadow-hover h-100 border-1" data-aos="fade-up" data-aos-delay="<?= $b * 100; ?>"> 
        <a href="<?php echo base_url('post/'.$post->slug) ?>">
            <img class="img-fluid card-img-top" src="<?php echo base_url($post->image) ?>" alt="Image">
        </a>
        <div class="card-body p-4 p-xl-6">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <a href="#" class="badge badge-pill badge-primary-soft"><?php echo character_limiter($post->category, 12) ?></a>
                <span class="small"><?php echo my_date_show($post->created_at) ?></span>
            </div>
            <h3 class="h5">
                <a class="text-dark" href="<?php echo base_url('post/'.$post->slug) ?>"><h5><?php echo html_escape($post->title) ?></h5></a>
            </h3>
        </div>
    </article>
</div>
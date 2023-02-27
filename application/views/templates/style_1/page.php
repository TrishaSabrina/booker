<section class="bg-light p-6">
    <div class="container">
        <div class="rows d-flex justify-content-center hide-xs">
            <h2 class="pt-2"><?php echo html_escape($pages->title) ?></h2>
        </div>
    </div>
</section>

<section class="section pt-6">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="content-container minh-400">
                    <div class="faq">
                        <div class="accordion-container text-dark">
                            <p><?= $pages->details ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
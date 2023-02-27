<section class="bg-light pb-20 pt-8">
    <div class="container cw-14">
        <div class="rows d-flex justify-content-between hide-xs">
            <h4 class="pt-2"><?php echo trans('staff-panel') ?></h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a class="text-muted" href="<?php echo base_url() ?>"><?php echo trans('home') ?></a></li>
                    <li class="breadcrumb-item active"><?php echo trans('staff') ?></li>
                    <li class="breadcrumb-item text-primary"><?php echo trans($page_lang) ?></li>
                </ol>
            </nav>
        </div>
    </div>
</section>

<style type="text/css">
    .ui-datepicker-prev:after {
        transform: rotate(45deg);
        margin: -42px 0px 0px 8px;
    }
    .ui-datepicker-next {
        float: right;
        margin-right: 12px;
    }
    .ui-datepicker-next:after {
        transform: rotate(-135deg);
        margin: -42px 0px 0px 0px;
    }
</style>
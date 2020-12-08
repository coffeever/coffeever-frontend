<?php defined('INDEX') or die(); ?>
<?php if(isset($item) && !empty($item)): ?>
    <div class="product product-category col-auto">
        <div class="category__item">
            <div class="category__image-wrapper">
                <div class="aspect__ratio aspect__ratio-75 aspect__ratio-crop">
                    <a href="/kategori/<?php echo $item['alias'] ?>" class="aspect__ratio-container">
                        <div class="aspect__ratio-image category__image lazyload"
                             data-bgset="<?php echo getTimthumbImage($item['image'],180,210)?> 180w 210h,<?php echo getTimthumbImage($item['image'],360,420)?> 360w 420h,<?php echo getTimthumbImage($item['image'],540,630)?> 540w 630h,<?php echo getTimthumbImage($item['image'],720,840)?> 720w 840h,<?php echo getTimthumbImage($item['image'],900,1050)?> 900w 1050h,<?php echo getTimthumbImage($item['image'],1000,1167)?> 1000w 1167h"
                             data-sizes="auto"
                             data-parent-fit="cover"
                             style="background-image:url(/assets/img/transparent.png.jpg);">
                        </div>
                    </a>
                </div>
            </div>
            <div class="category__content">
                <div class="category__details">
                    <a href="/kategori/<?php echo $item['alias'] ?>">
                        <?php /*<div class="more-products"><?php echo $item['productCount']; ?> ürün</div>*/?>
                        <h2 class="category__title"><?php echo $item['title'] ?></h2>
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php endif;?>
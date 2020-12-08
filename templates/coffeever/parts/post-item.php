<?php defined('INDEX') or die(); ?>
<?php if (isset($item) && !empty($item)):  ?>
    <div class="article__listing has-thumbnail <?php echo $isVertical ?? 'd-flex flex-wrap' ?> <?php echo $postClass ?? '' ?>">
        <div class="article__image">
            <div class="aspect__ratio aspect__ratio-crop aspect__ratio-15">
                <a href="/yazilar/<?php echo $item['alias']; ?>" class="aspect__ratio-container prllx" data-prllx="45">
                    <div class="aspect__ratio-image lazyload"
                         data-bgset="<?php echo getTimthumbImage($item['image'], 180, 113, 0) ?> 180w 113h,<?php echo getTimthumbImage($item['image'], 360, 225, 0) ?> 360w 225h,<?php echo getTimthumbImage($item['image'], 540, 338, 0) ?> 540w 338h,<?php echo getTimthumbImage($item['image'], 720, 450, 0) ?> 720w 450h,<?php echo getTimthumbImage($item['image'], 900, 563, 0) ?> 900w 563h,<?php echo getTimthumbImage($item['image'], 1080, 675, 0) ?> 1080w 675h,<?php echo getTimthumbImage($item['image'], 1290, 818, 0) ?> 1296w 810h,<?php echo getTimthumbImage($item['image'], 1512, 948, 0) ?> 1512w 945h,<?php echo getTimthumbImage($item['image'], 1600, 1000, 0) ?> 1600w 1000h"
                         data-sizes="auto" data-parent-fit="cover" style="background-position:center;background-image:url(<?php echo getTimthumbImage($item['image'], 360, 225, 0) ?>);"></div>
                </a>
            </div>
            <div class="article__meta">
                <time class="article__date" datetime="<?php echo formatDateTime($item['createdAt']); ?>"><span><?php echo formatDateTime($item['createdAt']); ?></span></time>
            </div>
        </div>
        <div class="article__content" data-parallax='{"y": -40, "smoothness": 10}'>
            <h2 class="article__title">
                <a href="/yazilar/<?php echo $item['alias']; ?>"><?php echo $item['title']; ?></a>
            </h2>
            <div class="article__excerpt">
                <p><?php echo excerptStringByWord($item['description'], 20); ?></p>
            </div>
            <a href="/yazilar/<?php echo $item['alias']; ?>" class="article__more">Devamını Oku</a>
        </div>
        <div class="clearfix"></div>
    </div>

<?php endif; ?>
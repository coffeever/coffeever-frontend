<?php defined('INDEX') or die(); ?>
<?php if(isset($item) && !empty($item)): ?>
<?php
$price = $item['price'];
$calculatedPrice = calculatePrice($price, (isset($item['priceCurrency']) && !empty($item['priceCurrency'])) ? $item['priceCurrency']: 'usd', $item['discountType'], $item['discountAmount'], $item['isTaxIncluded'], $item['taxRate']);
$oldPrice = calculatePrice($price, (isset($item['priceCurrency']) && !empty($item['priceCurrency'])) ? $item['priceCurrency']: 'usd', 'not', $item['discountAmount'], $item['isTaxIncluded'], $item['taxRate']);
if (isset($item['selectedVV']) && !empty($item['selectedVV'])) {
    foreach ($item['selectedVV'] as $variants) {
        if (isset($variants['price']) && !empty($variants['price']) && $variants['price'] < $price) {
            $price = $variants['price'];
            $calculatedPrice = calculatePrice($price, $variants['priceCurrency'], $variants['discountType'], $variants['discountAmount'], $variants['isTaxIncluded'], 8);
            $oldPrice = calculatePrice($price, $variants['priceCurrency'], 'not', $variants['discountAmount'], $variants['isTaxIncluded'], 8);
        }
    }
}
$item['newPrice'] = $calculatedPrice;
$item['oldPrice'] = $oldPrice;
    ?>
    <?php $image1 = count($item['photos'])>=1 ? $item['photos'][0] : ''; ?>
    <?php $image2 = count($item['photos'])>=2 ? $item['photos'][1] : $image1; ?>
    <div class="product col-auto">
        <div class="product__item">
            <div class="product__image-wrapper">
                <div class="product__image-inner">
                    <div class="aspect__ratio aspect__ratio-75 aspect__ratio-crop">
                        <a href="/urun-detay/<?php echo $item['alias']?>" class="aspect__ratio-container">
                            <div class="product__overlay overlay-0"></div>
                            <div class="aspect__ratio-image product__image product__image-featured lazyload"
                                 data-bgset="<?php echo getTimthumbImage($image1,180,210 )?> 180w 210h,<?php echo getTimthumbImage($image1,360,420 )?> 360w 420h,<?php echo getTimthumbImage($image1,540,630 )?> 540w 630h,<?php echo getTimthumbImage($image1,720,840 )?> 720w 840h,<?php echo getTimthumbImage($image1,900,1050 )?> 900w 1050h,<?php echo getTimthumbImage($image1,1000,1167 )?> 1000w 1167h"
                                 data-sizes="auto" style="background-image:url(/assets/img/transparent.png.jpg);">
                            </div>
                            <div class="aspect__ratio-image product__image product__image-second lazyload lazypreload"
                                 data-bgset="<?php echo getTimthumbImage($image2,180,210 )?> 180w 210h,<?php echo getTimthumbImage($image2,360,420 )?> 360w 420h,<?php echo getTimthumbImage($image2,540,630 )?> 540w 630h,<?php echo getTimthumbImage($image2,720,840 )?> 720w 840h,<?php echo getTimthumbImage($image2,900,1050 )?> 900w 1050h,<?php echo getTimthumbImage($image2,1000,1167 )?> 1000w 1167h"
                                 data-sizes="auto" style="background-image:url(/assets/img/transparent.png.jpg);"></div>
                        </a>
                    </div>
                </div>
                <div class="product__buttons">
                    <div class="d-flex align-items-center justify-content-center">
                        <button type="button" class="btn quickview_btn has-tooltip" data-product_handle="portable-bluetooth-speaker" data-collection_handle="all" data-quick-view-data="<?php echo base64_encode(json_encode($item)) ?>">
                            <span class="tooltip">Hızlı gör</span>
                        </button>
                        <a href="/urun-detay/<?php echo $item['alias']?>" class="btn product_btn" data-id="<?php echo $item['_id']?>" data-link="/urun-detay/<?php echo $item['alias']?>" data-image="<?php echo getTimthumbImage($image1,180,210)?>" data-price="<?php echo $item['newPrice'];?>">
                            <span class="tooltip">Satın Al</span>Satın Al</a>
                        <a href="#" class="btn addwishlist_btn has-tooltip hide"
                           data-added="Browse Wishlist"
                           data-product_handle="portable-bluetooth-speaker"
                           data-product_id="<?php echo $item['_id']?>"
                           data-customer_id=""
                           data-shop_domain="rt-barberry.myshopify.com">
                            <span class="tooltip">Favorilere ekle</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="product__content">
                <div class="product__details d-flex flex-nowrap justify-content-between">
                    <h3 class="product__title">
                        <div class="product__review"><span class="shopify-product-reviews-badge" data-id="<?php echo $item['_id']?>"></span></div>
                        <a class="product__link" href="/urun-detay/<?php echo $item['alias']; ?>" title="<?php echo htmlspecialchars($item['title']); ?>"><?php echo $item['title']; ?></a>
                    </h3>
                    <div class="product__price">
                        <?php if ($oldPrice != $calculatedPrice): ?>
                        <del class="compare_at_price">
                            <span class="price">
                                <span class="money">
                                    <span class="currency_symbol">₺</span><?php echo number_format($oldPrice, 0);?>
                                </span>
                            </span>
                        </del>
                        <?php endif; ?>
                        <ins>
                            <span class="price">
                                <span class="money">
                                    <span class="currency_symbol">₺</span><?php echo number_format($item['newPrice'], 0);?>
                                </span>
                            </span>
                        </ins>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="quantity" value="1"/>
        <select class="hide" name="id">
            <option value="<?php echo $item['_id']; ?>"><?php echo $item['title']; ?></option>
        </select>
    </div>
<?php endif;?>
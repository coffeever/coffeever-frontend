<?php
defined('INDEX') or die();

if(isset($pageData['alias']) && !empty($pageData['alias'])){
    $product = makeRequest("get", ["alias" => $pageData['alias']], ["collection" => "products"]);
    $productCategory = makeRequest("get", ["_id" => $product['category']], ["collection" => "productCategories"]);
    $productBrand = makeRequest("get", ["_id" => $product['brand']], ["collection" => "productBrands"]);
    $productReviews = makeRequest('getList', ['productId'=>$product['_id'], 'status'=>true], ['collection'=>'reviews', 'sort'=>['createdAt'=>-1]]);
    $relatedProducts = makeRequest("getList",  ["category"=> $product['category']], ["collection" => "products", "sort" => ["createdAt" => 1]]);

    $index = null;
    foreach($relatedProducts as $key => $relatedProduct) {
        if ($relatedProduct['_id'] == $product['_id']) {
            $index = $key;
            break;
        }
    }
    if ($index != null) {
        if ($index == count($relatedProducts) - 1) {
            $relatedProduct = $relatedProducts[0];
        } else {
            $relatedProduct = $relatedProducts[$index + 1];
        }
    }
}

$additionalSettings = getConfigParam('additionalSettings');
$wpMessageString = str_replace("%product_title%", $product['title'], $additionalSettings['wpMessage2']);
$wpMessageString = str_replace("%stock_code%", $product['stockCode'], $wpMessageString);

$sliderImages = [];
$cropperImage = '';
if (isset($product['photos']) && !empty($product['photos'])) {
    if (count($product['photos']) == 1) {
        $cropperImage = $product['photos'][0];
        $sliderImages = $product['photos'];
    } else {
        $cropperImage = end($product['photos']);
        $sliderImages = array_slice($product['photos'], 0, -1);
    }
}

$price = $product['price'];
$calculatedPrice = calculatePrice($price, (isset($product['priceCurrency']) && !empty($product['priceCurrency'])) ? $product['priceCurrency']: 'usd', $product['discountType'], $product['discountAmount'], $product['isTaxIncluded'], $product['taxRate']);
$oldPrice = calculatePrice($price, (isset($product['priceCurrency']) && !empty($product['priceCurrency'])) ? $product['priceCurrency']: 'usd', 'not', $product['discountAmount'], $product['isTaxIncluded'], $product['taxRate']);
if (isset($product['selectedVV']) && !empty($product['selectedVV'])) {
    foreach ($product['selectedVV'] as $variants) {
        if (isset($variants['price']) && !empty($variants['price']) && $variants['price'] < $price) {
            $price = $variants['price'];
            $calculatedPrice = calculatePrice($price, $variants['priceCurrency'], $variants['discountType'], $variants['discountAmount'], $variants['isTaxIncluded'], 8);
            $oldPrice = calculatePrice($price, $variants['priceCurrency'], 'not', $variants['discountAmount'], $variants['isTaxIncluded'], 8);
        }
    }
}
$xml = simplexml_load_file('http://www.tcmb.gov.tr/kurlar/today.xml');
$dolar = $xml->Currency[0]->ForexSelling;
?>
<style>
    .AddToCart-product-template.btn:after{
        transition: none !important;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.9/cropper.min.css" />
<div id="shopify-section-product-template" class="shopify-section">
    <div class="message-box alert alert-<?php echo isset($actionResult['status']) && $actionResult['status'] ? 'success' : 'danger' ?> fade show" role="alert" style="display: <?php echo isset($actionResult) && !empty($actionResult['message']) ? 'block' : 'none'; ?>">
        <?php echo isset($actionResult['message']) ? $actionResult['message'] : ''; ?>
    </div>
    <div class="ProductSection-product-template product__2246988726372 product-template__container content-area" itemscope itemtype="http://schema.org/Product" data-section-id="product-template" data-section-type="product-template" data-enable-history-state="true" data-product_swatch_color_advanced="true" data-product_swatch_color="true" data-product_swatch_size="true">
        <div class="product-single__nav product-single__nav-product-template">
            <a href="/urun-detay/<?php echo $relatedProduct['alias']; ?>" class="next-product">
                <div class="product_text">
                    <p class="link">Sonraki Ürün</p>
                </div>
                <div class="preview">
                    <div class="intrinsic">
                        <div class="image-center d-flex align-items-center justify-content-center">
                            <div class="image">
                                <img class="lazyload"
                                     src="<?php echo getTimthumbImage($relatedProduct['photos'][0],360,360)?>"
                                     data-src="<?php echo getTimthumbImage($relatedProduct['photos'][0],360,360)?>"
                                     data-widths="[360, 360]"
                                     data-aspectratio="0.856898029134533"
                                     data-sizes="auto"
                                     alt="<?php echo $relatedProduct['title']; ?>" />
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="product-single container">
            <div class="row row-0">
                <?php if (isset($sliderImages) && !empty($sliderImages)): ?>
                <div class="col-12 col-md-6">
                    <div class="product-single__photos bottom">
                        <div class="slider-for">
                            <?php foreach ($sliderImages as $photo): ?>
                                <div>
                                    <a class="img-popup" href="<?php echo getTimthumbImage($photo, 1000, 1000); ?>">
                                        <img src="<?php echo getTimthumbImage($photo, 1000, 1000); ?>" />
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="slider-nav">
                            <?php foreach ($sliderImages as $photo): ?>
                                <div>
                                    <img src="<?php echo getTimthumbImage($photo, 480, 480); ?>" />
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <div class="col-12 col-md-6">
                    <div class="product-single__content">
                        <div class="product-single__top">
                            <div class="page-header">
                                <div class="title-section">
                                    <div class="title-wrapper">
                                        <div class="box-share-master-container">
                                            <a href="javascript:void(0);" class="social-sharing placeholder-icon has-tooltip" data-share_img="<?php echo getTimthumbImage($sliderImages[0], 500, 500); ?>" data-title="<?php echo $product['title']?>" data-name="Paylaş" data-share_elem="facebook,twitter,google,pinterest">
                                                <span class="tooltip">Paylaş</span>
                                            </a>
                                        </div>
                                        <ol class="breadcrumbs d-flex align-items-center justify-content-center">
                                            <li>
                                                <a href="/">
                                                    <span>Anasayfa </span><span>/ </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo getSafeUrl("/categories/".$productCategory['alias']); ?>">
                                                    <span><?php echo $productCategory['title']?> </span>
                                                </a>
                                            </li>
                                        </ol>
                                        <div class="page-title-wrapper">
                                            <h1 class="product_title product-single__title"><?php echo $product['title']?></h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-single__middle">
                            <div class="clearfix"></div>
                            <div class="clearfix"></div>
                            <div class="product-single__short">
                                <p><?php echo $product['shortDescription']; ?></p>
                            </div>
                            <?php if ($productCategory['alias'] == "pano-perde"): ?>
                            <div class="product-image-cropper" style="margin-bottom: 20px;">
                                <div>
                                    <img id="image-crop" src="<?php echo getTimthumbImage($cropperImage, 500)?>" style="display: block;max-width: 100%;width: 100%" alt="">
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="product-single__bottom">
                            <form method="post" accept-charset="UTF-8" class="product-single__form product-single__form-product-template" enctype="multipart/form-data" data-section="product-template">
                                <input type="hidden" value="<?php echo $product['_id'];?>" id="productId">
                                <input type="hidden" value="<?php echo $product['title'];?>" id="productTitle">
                                <input type="hidden" value="<?php echo getTimthumbImage($product['photos'][0],180,210,0)?>" id="productImage">
                                <input type="hidden" value="/urun-detay/<?php echo $product['alias'];?>" id="productLink">
                                <input type="hidden" value="<?php echo $calculatedPrice;?>" id="productUnitPrice">
                                <input type="hidden" class="price-section-input" value="" id="productPrice">
                                <input type="hidden" value="<?php echo $product['discountType'];?>" id="productDiscountType">
                                <input type="hidden" value="<?php echo $product['discountAmount'];?>" id="productDiscountAmount">
                                <input type="hidden" value="<?php echo $product['isTaxIncluded'];?>" id="productIsTaxIncluded">
                                <input type="hidden" value="<?php echo $product['taxRate'];?>" id="productTaxRate">
                                <div class="product-specs_group align-items-center" data-for="<?php echo $productCategory['alias']; ?>">
                                    <div class="product-spec-item hide row" id="wrapper-parca-sayisi">
                                        <label class="col-md-5" for="parca-sayisi">Parça(Kanat) Sayısı</label>
                                        <input class="col-md-7 requiredForBuy" type="number" id="parca-sayisi" name="parca-sayisi" value="1" onchange="handleChange(this, 1)" onkeyup="numberOnly(this,false);">
                                    </div>
                                    <div class="product-spec-item row <?php echo ($productCategory['alias'] == 'yastik') ? 'hide' : '' ?>" id="wrapper-width">
                                        <label class="col-md-5" for="width-spec">En(cm)</label>
                                        <input class="col-md-7 requiredForBuy" type="number" id="width-spec" name="width-spec" onchange="handleChange(this, 20);" onkeyup="numberOnly(this,false);" <?php if ($productCategory['alias'] == 'yastik'):?> value="45" disabled <?php endif;?>>
                                    </div>
                                    <div class="product-spec-item row <?php echo ($productCategory['alias'] == 'yastik') ? 'hide' : '' ?>" id="wrapper-height">
                                        <label class="col-md-5" for="height-spec">Boy(cm)</label>
                                        <input class="col-md-7 requiredForBuy" type="number" id="height-spec" name="height-spec" onchange="handleChange(this, 20);" onkeyup="numberOnly(this,false);" <?php if ($productCategory['alias'] == 'yastik'):?> value="45" disabled <?php endif;?>>
                                    </div>
                                    <?php if (isset($product['selectedPV']) && !empty($product['selectedPV'])): ?>
                                        <?php foreach ($product['selectedPV'] as $index => $productVariant): ?>
                                        <?php if ($productVariant['_id'] == 'C3vxGGKifpEGn2aQC'): ?>
                                        <?php else: ?>
                                            <div class="product-spec-item modal-open row" id="wrapper-option-<?php echo $productVariant['_id']; ?>" data-id="<?php echo $productVariant['_id']; ?>">
                                                <label class="col-md-5" for="spec-option-<?php echo $productVariant['_id']; ?>"><?php echo $productVariant['title']; ?></label>
                                                <input variant-data="" data-name="variantPrice" type="text" disabled class="col-md-7" name="<?php echo $productVariant['title']; ?>" id="<?php echo $productVariant['_id']; ?>" value="Seçiniz">
                                            </div>
                                            <div id="modal-<?php echo $productVariant['_id']; ?>" class="modal modal-perde-turu">
                                                <div class="row">
                                                    <?php foreach ($productVariant['variantValues'] as $key => $productVariantValue): ?>
                                                        <div class="col-4 modal-option" data-for="<?php echo $productVariant['_id']; ?>" data-id="<?php echo $productVariantValue['itemId']; ?>">
                                                            <img style="width: 100%" src="<?php echo (isset($productVariantValue['image']) && !empty($productVariantValue['image'])) ? getTimthumbImage($productVariantValue['image'],300,300) : '/assets/img/default.jpg'; ?>">
                                                            <a style="display: block"><?php echo (isset($productVariantValue['title']) && !empty($productVariantValue['title'])) ? $productVariantValue['title'] : ''; ?></a>
                                                            <p style="font-size: 14px;margin-bottom: 0px;line-height: 1.3;font-weight: 400;"><?php echo (isset($productVariantValue['description']) && !empty($productVariantValue['description'])) ? $productVariantValue['description'] : ''; ?></p>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                    <?php if (isset($product['selectedVV']) && !empty($product['selectedVV'])): ?>
                                        <?php foreach ($product['selectedVV'] as $index => $productVariantDetail): ?>
                                            <div class="product-spec-item hide row">
                                                <input data-name="<?php echo $productVariantDetail['name']; ?>" type="text" disabled class="col-md-7" name="variant-price-<?php echo $productVariantDetail['id']; ?>" id="<?php echo $productVariantDetail['id']; ?>" value="<?php echo calculatePrice($productVariantDetail['price'], $productVariantDetail['priceCurrency'], $productVariantDetail['discountType'], $productVariantDetail['discountAmount'], $productVariantDetail['isTaxIncluded'], 8); ?>">
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                    <?php if (isset($product['specs']) && !empty($product['specs'])): ?>
                                        <?php foreach ($product['specs'] as $index => $productSpec): ?>
                                        <?php if ($productSpec['title'] == 'Pile Oranı'): ?>
                                            <div class="product-spec-item modal-open row <?php echo $index == 0 ? '' : 'hide'?>" id="wrapper-option-<?php echo $productSpec['_id']; ?>" data-id="<?php echo $productSpec['_id']; ?>">
                                                <label class="col-md-5" for="spec-option-<?php echo $productSpec['_id']; ?>"><?php echo $productSpec['title']; ?></label>
                                                <select id="spec-option-<?php echo $productSpec['_id']; ?>" name="<?php echo $productSpec['title']; ?>" class="spec-select-pile col-md-7">
                                                    <option value="Seçiniz">Seçiniz</option>
                                                    <?php foreach ($productSpec['specValues'] as $productSpecValue): ?>
                                                        <option value="<?php echo (isset($productSpecValue['title']) && !empty($productSpecValue['title'])) ? $productSpecValue['title'] : ''; ?>"><?php echo (isset($productSpecValue['title']) && !empty($productSpecValue['title'])) ? $productSpecValue['title'] : ''; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        <?php else: ?>
                                            <div class="product-spec-item modal-open row <?php echo $index == 0 ? '' : 'hide'?>" id="wrapper-option-<?php echo $productSpec['_id']; ?>" data-id="<?php echo $productSpec['_id']; ?>">
                                                <label class="col-md-5" for="spec-option-<?php echo $productSpec['_id']; ?>"><?php echo $productSpec['title']; ?></label>
                                                <input data-name="" type="text" disabled class="col-md-7" name="<?php echo $productSpec['title']; ?>" id="<?php echo $productSpec['_id']; ?>" value="Seçiniz">
                                            </div>
                                            <div id="modal-<?php echo $productSpec['_id']; ?>" class="modal modal-perde">
                                                <div class="row">
                                                    <?php foreach ($productSpec['specValues'] as $productSpecValue): ?>
                                                        <div class="col-4 modal-option" data-for="<?php echo $productSpec['_id']; ?>" data-id="<?php echo $productSpecValue['id']; ?>">
                                                            <img style="width: 100%" src="<?php echo (isset($productSpecValue['image']) && !empty($productSpecValue['image'])) ? getTimthumbImage($productSpecValue['image'],300,300) : '/assets/img/default.jpg'; ?>">
                                                            <a style="display: block"><?php echo (isset($productSpecValue['title']) && !empty($productSpecValue['title'])) ? $productSpecValue['title'] : ''; ?></a>
                                                            <p style="font-size: 14px;margin-bottom: 0px;line-height: 1.3;font-weight: 400;"><?php echo (isset($productSpecValue['description']) && !empty($productSpecValue['description'])) ? $productSpecValue['description'] : ''; ?></p>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                                <div class="product-spec-alert alert-parca hide"></div>
                                <div class="product-spec-alert alert-pile hide"></div>
                                <div class="product-addtocart_button_group d-flex align-items-center row">
                                    <div class="col-4 col-md-6">
                                        <div class="product-form__item--submit">
                                            <button type="submit" name="add" class="AddToCart-product-template btn btn-primary progress-btn product-form__cart-submit" disabled="disabled">
                                                <span class="AddToCartText-product-template btn-text">Sepete Ekle</span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-8 col-md-6">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <p class="product-single__price product-single__price-product-template" style="text-align: end;">
                                                    <span class="money">
                                                        Birim Fiyat:
                                                    </span>
                                                    <?php if ($oldPrice != $calculatedPrice): ?>
                                                    <del class="compare_at_price">
                                                        <span class="price ComparePrice-product-template">
                                                            <span class="money">
                                                                <span class="currency_symbol">₺</span><?php echo number_format($oldPrice, 0);?>
                                                            </span>
                                                        </span>
                                                    </del>
                                                    <?php endif; ?>
                                                    <ins class="product_price">
                                                        <span class="price ProductPrice-product-template">
                                                            <span class="money">
                                                                <span class="currency_symbol">₺</span><?php echo number_format($calculatedPrice, 0);?>
                                                            </span>
                                                        </span>
                                                    </ins>
                                                </p>
                                            </div>
                                            <div class="col-sm-12">
                                                <div style="text-align: right">
                                                    <span class="product_price">
                                                        <span class="price ProductPrice-product-template">
                                                            <span class="money">
                                                                <a class="full-price-section"></a>
                                                            </span>
                                                        </span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-form__item--exts">
                                    <p style="font-size: 18px; margin-bottom: 5px;"><i>*Yapacağınız sipariş ile ilgili değişiklik talebiniz için bizimle whatsapptan iletişime geçebilirsiniz.</i></p><br>
                                    <a href="whatsapp://send?phone=<?php echo $additionalSettings['wpNumber'];?>&text=<?php echo urlencode($wpMessageString)?>" class="btn btn-info">
                                        <i class="fa fa-question-circle"></i>
                                        <span class="tooltip">Bu ürün hakkında bilgi almak istiyorum</span>
                                    </a><br>
                                    <a href="#" class="btn-ext sizechart_btn">Ürün Rehberi</a>
                                    <div class="sizechart-modal">
                                        <div class="sizechart_container">
                                            <h3 class="sizechart_title">Ürün Rehberi</h3>
                                            <div class="sizechart_content">
                                                <?php echo $product['extraDescription']?>
                                            </div>
                                            <div class="sizechart_close close-icon"></div>
                                        </div>
                                        <div class="sizechart_overlay"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="product-single__inview">
            <div class="product-single__tabs tabs-layout-tabs">
                <div class="container">
                    <ul class="product-tabs">
                        <li class="description_tab"><a class="product-tabs__title active" href="#tab-description">Açıklama</a></li>
                        <li class="reviews_tab"><a class="product-tabs__title" href="#tab-reviews">Yorumlar</a></li>
                        <!--<li class="additional_tab"><a class="product-tabs__title" href="#tab-additional">Kargo</a></li>-->
                    </ul>
                    <div class="product-tabs__wrapper">
                        <div class="row row-0 justify-content-center">
                            <div class="col-12 col-md-9 col-lg-8">
                                <div class="product-tabs__title-wrap"><a class="product-tabs__title active" href="#tab-description">Açıklama</a></div>
                                <div id="tab-description" class="product-tabs__panel active" itemprop="description" style="display: block;">
                                    <?php echo $product['description']; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="product-tabs__wrapper">
                        <div class="row row-0 justify-content-center">
                            <div class="col-12 col-md-9 col-lg-8">
                                <div class="product-tabs__title-wrap"><a class="product-tabs__title" href="#tab-reviews">Yorumlar</a></div>
                                <div id="tab-reviews" class="product-tabs__panel">
                                    <div id="shopify-product-reviews" data-id="2247014940772" class="customized">
                                        <style scoped="">.spr-container {
                                                padding: 24px;
                                                border-color: #ECECEC;}
                                            .spr-review, .spr-form {
                                                border-color: #ECECEC;
                                            }
                                        </style>
                                        <div class="spr-container">
                                            <div class="spr-header">
                                                <h2 class="spr-header-title">Yorumlar</h2>
                                                <div class="spr-summary">
                                                    <span class="spr-starrating spr-summary-starrating">
                                                        <i class="spr-icon spr-icon-star"></i><i class="spr-icon spr-icon-star"></i><i class="spr-icon spr-icon-star"></i><i class="spr-icon spr-icon-star"></i><i class="spr-icon spr-icon-star"></i>
                                                    </span>
                                                    <span class="spr-summary-caption"><span class="spr-summary-actions-togglereviews"><?php echo count($productReviews); ?> Yorum</span></span>
                                                </div>
                                                <?php if (isset($productReviews) && !empty($productReviews)): ?>
                                                <?php foreach ($productReviews as $review): ?>
                                                <div class="spr-reviews" id="reviews_2247014940772">
                                                    <div class="spr-review" id="spr-review-92018206">
                                                        <div class="spr-review-header">
                                                            <span class="spr-starratings spr-review-header-starratings" aria-label="<?php echo $review['review']; ?> of 5 stars" role="img">
                                                                <?php for ($i = 0; $i<intval($review['review']); $i++) {
                                                                    echo '<i class="fa fa-star" style="color: orange"></i>';
                                                                } ?>
                                                            </span>
                                                            <h3 class="spr-review-header-title"><?php echo $review['reviewTitle']; ?></h3>
                                                            <span class="spr-review-header-byline"><strong><?php echo $review['name']; ?></strong>, <strong><?php echo formatDateTime($review['createdAt']); ?></strong></span>
                                                        </div>
                                                        <div class="spr-review-content">
                                                            <p class="spr-review-content-body"><?php echo $review['reviewMessage']; ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php endforeach; ?>
                                                <?php endif; ?>
                                            </div>
                                            <div class="spr-content">
                                                <div class="spr-form" id="form_2247014940772">
                                                    <form method="post" action="" id="review-form" class="new-review-form">
                                                        <input type="hidden" name="_nonce" value="<?php echo md5(INDEX); ?>">
                                                        <input type="hidden" name="action" value="send_review">
                                                        <input type="hidden" name="productId" value="<?php echo $product['_id']?>">
                                                        <input type="hidden" name="review-rate" id="review-rate" value="0">
                                                        <h3 class="spr-form-title">Yorum yazın</h3>
                                                        <fieldset class="spr-form-contact">
                                                            <div class="spr-form-contact-name">
                                                                <label class="spr-form-label" for="review_author">İsim</label>
                                                                <input required class="spr-form-input spr-form-input-text" id="review_author" type="text" name="review-name" placeholder="İsminizi girin">
                                                            </div>
                                                            <div class="spr-form-contact-email">
                                                                <label class="spr-form-label" for="review_email">E-posta</label>
                                                                <input required class="spr-form-input spr-form-input-email " id="review_email" type="email" name="review-email" placeholder="test@ornek.com">
                                                            </div>
                                                        </fieldset>
                                                        <fieldset class="spr-form-review">
                                                            <div class="spr-form-review-rating">
                                                                <label class="spr-form-label" for="review_rate">Puan</label>
                                                                <div class="rating">
                                                                    <input class="star-rating" type="radio" id="star5" name="rating" value="5" /><label for="star5"></label>
                                                                    <input class="star-rating" type="radio" id="star4" name="rating" value="4" /><label for="star4"></label>
                                                                    <input class="star-rating" type="radio" id="star3" name="rating" value="3" /><label for="star3"></label>
                                                                    <input class="star-rating" type="radio" id="star2" name="rating" value="2" /><label for="star2"></label>
                                                                    <input class="star-rating" type="radio" id="star1" name="rating" value="1" /><label for="star1"></label>
                                                                </div>
                                                            </div>
                                                            <div class="spr-form-review-body">
                                                                <label class="spr-form-label" for="review_title">
                                                                    Başlık
                                                                </label>
                                                                <div class="spr-form-input">
                                                                    <input class="spr-form-input spr-form-input-email " id="review_title" type="text" name="review-title">
                                                                </div>
                                                            </div>
                                                            <div class="spr-form-review-body">
                                                                <label class="spr-form-label" for="review_body">
                                                                    Yorum
                                                                </label>
                                                                <div class="spr-form-input">
                                                                    <textarea required class="spr-form-input spr-form-input-textarea " id="review_body" name="review-message" rows="10" placeholder="Yorumunuzu buraya yazın..."></textarea>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                        <fieldset class="spr-form-actions">
                                                            <input type="submit" class="spr-button spr-button-primary button button-primary btn btn-primary" id="send-review" value="Gönder">
                                                        </fieldset>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--
                    <div class="product-tabs__wrapper">
                        <div class="row row-0 justify-content-center">
                            <div class="col-12 col-md-9 col-lg-8">
                                <div class="product-tabs__title-wrap"><a class="product-tabs__title" href="#tab-additional">Kargo</a></div>
                                <div id="tab-additional" class="product-tabs__panel">
                                    <?php include(ROOT_DIR."/templates/adahome/parts/in-progress.php"); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    -->
                </div>
            </div>
            <div class="product-single__meta">
                <div class="d-flex flex-wrap justify-content-center">
                    <ul class="col-12 col-lg-9">
                        <li>Kategori:
                            <span class="product-single__categories">
                                <a href="<?php echo getSafeUrl("/kategori/". $productCategory['alias']);?>" title="<?php echo $productCategory['title'];?>"><?php echo $productCategory['title'];?></a>
                            </span>
                        </li>
                    </ul>
                </div>
                <?php if (!empty($product['tags'])): ?>
                    <footer class="article__meta">
                        <ul class="article__tags">
                            <li>Etiketler: </li>
                            <?php foreach ($product['tags'] as $tag): ?>
                                <li>
                                    <a href="/etiket/<?php echo $tag;?>" title="Şu etikete sahip ürünleri görüntüle: <?php echo $tag;?>">
                                        <?php echo $tag;?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </footer>
                <?php endif; ?>
            </div>
        </div>
        <script type="application/json" class="ProductJson-product-template">
            {"id":2246988726372,
                "title":"Portable Bluetooth Speaker",
                "handle":"portable-bluetooth-speaker",
                "description":"\u003cdiv class=\"row\"\u003e\n\u003cdiv class=\"col-6 col-lg-4\"\u003e\n\u003cdiv class=\"attr-title\"\u003eColor\u003c\/div\u003e\n\u003cdiv class=\"attr-excerpt\"\u003e\n\u003cp\u003eAqua, Red, White, Yellow\u003c\/p\u003e\n\u003c\/div\u003e\n\u003c\/div\u003e\n\u003cdiv class=\"col-6 col-lg-4\"\u003e\n\u003cdiv class=\"attr-title\"\u003eMaterial\u003c\/div\u003e\n\u003cdiv class=\"attr-excerpt\"\u003e\n\u003cp\u003eGlass, Metal, Wood\u003c\/p\u003e\n\u003c\/div\u003e\n\u003c\/div\u003e\n\u003cdiv class=\"col-6 col-lg-4\"\u003e\n\u003cdiv class=\"attr-title\"\u003eDimensions\u003c\/div\u003e\n\u003cdiv class=\"attr-excerpt\"\u003e\n\u003cp\u003e13\"H x 10\"W x 8\"D\u003c\/p\u003e\n\u003c\/div\u003e\n\u003c\/div\u003e\n\u003cdiv class=\"col-6 col-lg-4\"\u003e\n\u003cdiv class=\"attr-title\"\u003eShade\u003c\/div\u003e\n\u003cdiv class=\"attr-excerpt\"\u003e\n\u003cp\u003e7\"D x 7\"Diameter\u003c\/p\u003e\n\u003c\/div\u003e\n\u003c\/div\u003e\n\u003cdiv class=\"col-6 col-lg-4\"\u003e\n\u003cdiv class=\"attr-title\"\u003eStyle\/Type\u003c\/div\u003e\n\u003cdiv class=\"attr-excerpt\"\u003e\n\u003cp\u003eContemporary table lamp \/ task lamp\u003c\/p\u003e\n\u003c\/div\u003e\n\u003c\/div\u003e\n\u003cdiv class=\"col-6 col-lg-4\"\u003e\n\u003cdiv class=\"attr-title\"\u003eSize\u003c\/div\u003e\n\u003cdiv class=\"attr-excerpt\"\u003e\n\u003cp\u003eSmall, Large, Medium\u003c\/p\u003e\n\u003c\/div\u003e\n\u003c\/div\u003e\n\u003c\/div\u003e",
                "published_at":"2019-01-11T17:02:56+07:00",
                "created_at":"2019-01-11T17:05:21+07:00",
                "vendor":"Barberry",
                "type":"",
                "tags":["$200 — $300","Black","Olive","Polypropylene","White"],
                "price":24900,
                "price_min":24900,
                "price_max":24900,
                "available":true,
                "price_varies":false,
                "compare_at_price":null,
                "compare_at_price_min":0,
                "compare_at_price_max":0,
                "compare_at_price_varies":false,
                "variants":
                [{"id":20217266765924,
                    "title":"Default Title",
                    "option1":"Default Title",
                    "option2":null,
                    "option3":null,
                    "sku":"",
                    "requires_shipping":true,
                    "taxable":true,
                    "featured_image":null,
                    "available":true,
                    "name":"Portable Bluetooth Speaker",
                    "public_title":null,
                    "options":["Default Title"],
                    "price":24900,"weight":0,
                    "compare_at_price":null,
                    "inventory_management":null,
                    "barcode":""
                }],
                "images":["\/\/cdn.shopify.com\/s\/files\/1\/0151\/4327\/2548\/products\/portable-spkr-01.jpg?v=1547201125","\/\/cdn.shopify.com\/s\/files\/1\/0151\/4327\/2548\/products\/portable-spkr-02.jpg?v=1547201126","\/\/cdn.shopify.com\/s\/files\/1\/0151\/4327\/2548\/products\/portable-spkr-03.jpg?v=1547201127"],
                "featured_image":"\/\/cdn.shopify.com\/s\/files\/1\/0151\/4327\/2548\/products\/portable-spkr-01.jpg?v=1547201125",
                "options":["Title"],
                "media":
                [{"alt":null,
                    "id":2002372100196,
                    "position":1,
                    "preview_image":{"aspect_ratio":0.857,
                        "height":1167,
                        "width":1000,
                        "src":"https:\/\/cdn.shopify.com\/s\/files\/1\/0151\/4327\/2548\/products\/portable-spkr-01.jpg?v=1568007877"},
                    "aspect_ratio":0.857,
                    "height":1167,
                    "media_type":"image",
                    "src":"https:\/\/cdn.shopify.com\/s\/files\/1\/0151\/4327\/2548\/products\/portable-spkr-01.jpg?v=1568007877",
                    "width":1000},
                    {"alt":null,
                        "id":2002372591716,
                        "position":2,
                        "preview_image":{"aspect_ratio":0.857,
                            "height":1167,
                            "width":1000,
                            "src":"https:\/\/cdn.shopify.com\/s\/files\/1\/0151\/4327\/2548\/products\/portable-spkr-02.jpg?v=1568007877"},
                        "aspect_ratio":0.857,
                        "height":1167,
                        "media_type":"image",
                        "src":"https:\/\/cdn.shopify.com\/s\/files\/1\/0151\/4327\/2548\/products\/portable-spkr-02.jpg?v=1568007877",
                        "width":1000},
                    {"alt":null,
                        "id":2002372821092,
                        "position":3,
                        "preview_image":{"aspect_ratio":0.857,
                            "height":1167,
                            "width":1000,
                            "src":"https:\/\/cdn.shopify.com\/s\/files\/1\/0151\/4327\/2548\/products\/portable-spkr-03.jpg?v=1568007877"},
                        "aspect_ratio":0.857,
                        "height":1167,
                        "media_type":"image",
                        "src":"https:\/\/cdn.shopify.com\/s\/files\/1\/0151\/4327\/2548\/products\/portable-spkr-03.jpg?v=1568007877",
                        "width":1000}],
                "content":"\u003cdiv class=\"row\"\u003e\n\u003cdiv class=\"col-6 col-lg-4\"\u003e\n\u003cdiv class=\"attr-title\"\u003eColor\u003c\/div\u003e\n\u003cdiv class=\"attr-excerpt\"\u003e\n\u003cp\u003eAqua, Red, White, Yellow\u003c\/p\u003e\n\u003c\/div\u003e\n\u003c\/div\u003e\n\u003cdiv class=\"col-6 col-lg-4\"\u003e\n\u003cdiv class=\"attr-title\"\u003eMaterial\u003c\/div\u003e\n\u003cdiv class=\"attr-excerpt\"\u003e\n\u003cp\u003eGlass, Metal, Wood\u003c\/p\u003e\n\u003c\/div\u003e\n\u003c\/div\u003e\n\u003cdiv class=\"col-6 col-lg-4\"\u003e\n\u003cdiv class=\"attr-title\"\u003eDimensions\u003c\/div\u003e\n\u003cdiv class=\"attr-excerpt\"\u003e\n\u003cp\u003e13\"H x 10\"W x 8\"D\u003c\/p\u003e\n\u003c\/div\u003e\n\u003c\/div\u003e\n\u003cdiv class=\"col-6 col-lg-4\"\u003e\n\u003cdiv class=\"attr-title\"\u003eShade\u003c\/div\u003e\n\u003cdiv class=\"attr-excerpt\"\u003e\n\u003cp\u003e7\"D x 7\"Diameter\u003c\/p\u003e\n\u003c\/div\u003e\n\u003c\/div\u003e\n\u003cdiv class=\"col-6 col-lg-4\"\u003e\n\u003cdiv class=\"attr-title\"\u003eStyle\/Type\u003c\/div\u003e\n\u003cdiv class=\"attr-excerpt\"\u003e\n\u003cp\u003eContemporary table lamp \/ task lamp\u003c\/p\u003e\n\u003c\/div\u003e\n\u003c\/div\u003e\n\u003cdiv class=\"col-6 col-lg-4\"\u003e\n\u003cdiv class=\"attr-title\"\u003eSize\u003c\/div\u003e\n\u003cdiv class=\"attr-excerpt\"\u003e\n\u003cp\u003eSmall, Large, Medium\u003c\/p\u003e\n\u003c\/div\u003e\n\u003c\/div\u003e\n\u003c\/div\u003e"}
        </script>
        <script type="application/json" class="ProductSwatchJson-product-template">{}</script>
        <script type="application/json" id="ModelJson-product-template">
            []
        </script>
        <script type="application/json" class="ProductMoreJson-product-template">{"id":2246988726372,"variants":[{"inventory_quantity":-2,"incoming":false,"next_incoming_date":null}]}</script>
        <div class="product-template__end"></div>
    </div>
    <?php if (!empty($relatedProducts)): ?>
    <div class="product-single__inview">
        <div class="container-section products-section" style="padding:60px 0px 40px 0px;">
            <div class="wrapper container">
                <div class="headings text-center">
                    <h3 class="heading weight-600 size-42" style="color:#000;margin-bottom:60px;">Benzer Ürünler</h3>
                </div>
                <div class="related-products-product-template" >
                    <div data-section-id="1526894974391" data-section-type="products-slider-sub">
                        <div class="products-slider is-slick_slider is-slick_slider-container">
                            <div class="slick-slider slick-slider-1526894974391" data-cat_id="all" data-max_pages="2" data-grid_num="4" data-grid_row="1" data-atts="image_ratio:75,image_ratio_crop:true,image_second:true,image_overlay:0,product_hover:2,vendor:true,review:true,quickview:true,wishlist:true,compare:true">
                                <div class="row row-0 products products-grid grid-4 layout-2">
                                    <?php foreach ($relatedProducts as $key => $item): ?>
                                        <?php include(ROOT_DIR."/templates/adahome/parts/product-item.php");?>
                                        <?php if ($key == 3) break ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <!--
                            <div class="slick-arrows d-flex justify-content-center">
                                <div class="slick-arrow slick-prev">
                                    <svg class="svg-icon">
                                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#global__symbols-prev2"></use>
                                    </svg>
                                </div>
                                <div class="slick-arrow slick-next">
                                    <svg class="svg-icon">
                                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#global__symbols-next2"></use>
                                    </svg>
                                </div>
                            </div>
                            -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <!--
        <div class="container-section products-section products-slider_hide hide" style="padding:0px 0px 40px 0px;">
            <div class="wrapper container">
                <div class="headings text-center">
                    <h3 class="heading weight-600 size-42" style="color:#000;margin-bottom:60px;">Recently viewed</h3>
                </div>
                <div class="recently-viewed-product-template" >
                    <div data-section-id="1526809798198" data-section-type="products-slider-sub">
                        <div class="products-slider is-slick_slider is-slick_slider-container">
                            <div class="slick-slider slick-slider-1526809798198" data-storage_id="recentlyViewed" data-max_pages="2" data-grid_num="4" data-grid_row="1" data-atts="image_ratio:75,image_ratio_crop:true,image_second:true,image_overlay:0,product_hover:2,vendor:true,review:true,quickview:true,wishlist:true,compare:true">
                                <div class="row row-0 products products-grid grid-4 layout-2"></div>
                            </div>
                            <div class="slick-arrows d-flex justify-content-center">
                                <div class="slick-arrow slick-prev">
                                    <svg class="svg-icon">
                                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#global__symbols-prev2"></use>
                                    </svg>
                                </div>
                                <div class="slick-arrow slick-next">
                                    <svg class="svg-icon">
                                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#global__symbols-next2"></use>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        -->
    </div>
</div>
<?php ob_start(); ?>
    <script type="text/javascript">
        function calcDollar()
        {
            return <?php echo $dolar;?>;
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.9/cropper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-md5/2.18.0/js/md5.min.js"></script>
    <script src="/templates/adahome/assets/js/cropper.js?q=<?php echo DEBUG_MODE ? time() : ''?>" defer></script>
<?php printOnFooter(ob_get_contents()); ?>
<?php ob_end_clean(); ?>
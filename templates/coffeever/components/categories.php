<?php
defined('INDEX') or die();

$productCategories = makeRequest("productCategories/getProductCategoriesWithSubcategoriesWithCount", []);
?>
<div id="shopify-section-list-collections-template" class="shopify-section">
    <div class="page-list-collections" data-section-id="list-collections-template" data-section-type="list-collections">
        <div class="page-header page-title-default title-size-default color-scheme-default">
            <div class="title-section container" data-parallax='{"y" : -40, "smoothness": 10}'>
                <div class="title-section-wrapper d-flex flex-wrap flex-row align-items-center justify-content-center">
                    <div class="title-wrapper" style="margin:0;">
                        <ol class="breadcrumbs d-flex align-items-center justify-content-center" itemscope itemtype="http://schema.org/BreadcrumbList">
                            <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                                <a itemprop="item" href="/">
                                    <span itemprop="name">Anasayfa</span><span class="delimiter">/</span>
                                </a>
                                <meta itemprop="position" content="1" />
                            </li>
                            <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                                <a itemprop="item" href="/kategoriler">
                                    <span itemprop="name">Kategoriler</span>
                                </a>
                                <meta itemprop="position" content="2" />
                            </li>
                        </ol>
                        <div class="page-title-wrapper">
                            <h1 class="page-title">Kategoriler</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page-header-bg-wrapper" style="background: #fff">
                <div class="page-header-bg rellax" data-rellax-speed="-1.5"style="background-color:#f7f7f7;"></div>
            </div>
        </div>
        <div class="page-content content-area">
            <div class="container">
                <div class="row row-0 products products-grid grid-4 layout-2">
                    <?php foreach ($productCategories as $item): ?>
                        <?php include(ROOT_DIR."/templates/adahome/parts/category-item.php"); ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

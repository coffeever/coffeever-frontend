<?php
defined('INDEX') or die();

$params = ["collection" => "products", "limit" => 8];
$filters = ["state"=>"active"];
$sort = ["createdAt"=>-1];

$qs = $_SERVER['QUERY_STRING'];
$qsArray = explode("&",$qs);
$qsParams = [];
foreach($qsArray as $param){
    $pieces = explode("=",$param);
    $key = $pieces[0];
    $val = $pieces[1];
    $qsParams[$key] = $val;
}
$filters = ["state"=>"active"];
$sort = ["createdAt"=>-1];
if(isset($qsParams["sort"]) && !empty($qsParams["sort"])){
    $ps = explode(",",$qsParams["sort"]);
    if(!empty($ps) && count($ps)==2){
        $sort = [$ps[0]=>$ps[1]=="asc" ? 1 : -1];
    }
}
if(isset($qsParams["pr"]) && !empty($qsParams["pr"])){
    $ps = explode(",",$qsParams["pr"]);
    if(!empty($ps) && count($ps)==2){
        $filters = ['price'=>['$gte'=>intval($ps[0]),'$lt'=>(int)$ps[1]]];
    }
}
$productPriceRanges = makeRequest('getList',[],['collection'=>'productPriceRanges','sort'=>['order'=>1,'createdAt'=>-1],'projection'=>['start'=>1,'end'=>1]]);
$productCategories = makeRequest("productCategories/getProductCategoriesWithSubcategoriesWithCount", []);
$currentCategoryArr = array_values(array_filter($productCategories,function($obj) use ($pageData){
    return $obj['_id'] == $pageData['_id'];
}));
$currentCategory = !empty($currentCategoryArr) ? $currentCategoryArr[0] : $pageData;

$catIds = [$pageData['_id']];
if(!empty($currentCategory) && isset($currentCategory['children'])){
    foreach($currentCategory['children'] as $child){
        $catIds[] = $child['_id'];
    }
}
$filters['category'] = ['$in'=>$catIds];
setConfigParam('PAGE_SIZE',21);
$productsRequest = makeRequest("getListWithCount", $filters,['collection'=>'products','projection'=>['title'=>1,'alias'=>1,'photos'=>1,'price'=>1, 'selectedVV'=>1, 'discountType'=>1, 'discountAmount'=>1, 'isTaxIncluded'=>1, 'taxRate'=>1],"limit"=>getConfigParam('PAGE_SIZE'), "skip" => getSkipSize(), "sort"=>$sort]);
$products = isset($productsRequest["result"]) ? $productsRequest["result"] : [];
$total = !empty($products) ? $productsRequest["total"] : 0;
$pageMax = !empty($total) ? calcPageMax($total) : 1;
$pageNum = getPage();

$xml = simplexml_load_file('http://www.tcmb.gov.tr/kurlar/today.xml');
$dolar = $xml->Currency->ForexSelling;
?>

<div id="shopify-section-collection-template" class="shopify-section">
    <div class="page-collection filters-sidebar" data-section-id="collection-template"
         data-section-type="collection-template">
        <div class="page-header page-title-default title-size-large color-scheme-light">
            <div class="title-section container" data-parallax='{"y" : -40, "smoothness": 10}'>
                <div class="title-section-wrapper d-flex flex-wrap flex-row align-items-center justify-content-center">
                    <div class="title-wrapper">
                        <ol class="breadcrumbs d-flex align-items-center justify-content-center" itemscope
                            itemtype="http://schema.org/BreadcrumbList">
                            <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                                <a itemprop="item" href="/">
                                    <span itemprop="name">Anasayfa</span><span class="delimiter">/</span>
                                </a>
                                <meta itemprop="position" content="1"/>
                            </li>
                            <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                                <a itemprop="item" href="#">
                                    <span itemprop="name">Kategoriler</span><span class="delimiter">/</span>
                                </a>
                                <meta itemprop="position" content="2"/>
                            </li>
                            <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                                <a itemprop="item" href="/kategori/<?php echo $pageData['alias'] ?>">
                                    <span itemprop="name"><?php echo $pageData['title'] ?></span>
                                </a>
                                <meta itemprop="position" content="3"/>
                            </li>
                        </ol>
                        <div class="page-title-wrapper">
                            <a href="/kategoriler" class="back-btn">
                                <svg class="svg-icon">
                                    <use xlink:href="#global__symbols-back"></use>
                                </svg>
                            </a>
                            <h1 class="page-title"><?php echo $pageData['title'] ?></h1>
                        </div>
                    </div>
                    <?php if (!empty($currentCategory) && !empty($currentCategory['children'])): ?>
                        <div class="page-categories-wrapper">
                            <div class="page-categories">
                                <div class="barberry-show-categories d-inline-block d-lg-none">
                                    <a href="javascript:void(0);">
                                        <span>Alt Kategoriler</span>
                                    </a>
                                </div>
                                <div class="barberry-categories">
                                    <ul class="list_categories">
                                        <?php foreach ($currentCategory['children'] as $child): ?>
                                            <li class="category_item">
                                                <a class="category_item_link"
                                                   href="/kategori/<?php echo $child['alias']; ?>">
                                                    <i class="fa fa-check"></i>
                                                    <span class="cat-item-title">
                                            <span><?php echo $child['title']; ?></span><sup><?php echo $child['productCount']; ?></sup>
                                        </span>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="page-header-bg-wrapper">
                <div class="page-header-bg rellax" data-rellax-speed="-1.5"
                     style="background-color:#f7f7f7;background-image:url(<?php echo !empty($pageData['coverImage']) ? getTimthumbImage($pageData['coverImage'],1920) : '/assets/img/brandsperde.jpg' ?>);background-repeat:repeat;background-position:center center;background-size:cover;background-attachment:scroll;"></div>
            </div>
        </div>
        <div class="page-content content-area" style="padding-left:0px;padding-right:0px;">
            <div class="container">
                <div class="row row-40">
                    <aside role="complementary" id="site-secondary" class="col-12 col-p-25">
                        <div class="site-sidebar">
                            <div class="sidebar__close close-icon"></div>
                            <div class="widget-area">
                                <?php if (!empty($productCategories)): ?>
                                    <div class="site-widget linklist">
                                        <ul class="widget__content categories">
                                            <?php foreach ($productCategories as $category): ?>
                                                <li>
                                                    <a href="/kategori/<?php echo $category['alias']; ?>"
                                                       <?php if ($category['_id'] == $pageData['_id']): ?>style="font-weight: 200"<?php endif; ?>>
                                                        <?php echo $category['title']; ?>
                                                    </a>
                                                    <span class="count"><?php echo '';/*$category['productCount'];*/ ?></span>
                                                    <?php if (!empty($category['children'])): ?>
                                                    <ul class="children">
                                                        <?php foreach ($category['children'] as $child): ?>
                                                        <li>
                                                            <a href="/kategori/<?php echo $child['alias']; ?>"><?php echo $child['title']; ?></a><span class="count"><?php echo '';/*$category['productCount'];*/ ?></span>
                                                        </li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                    <?php endif; ?>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>
                                <?php if(!empty($productPriceRanges)): ?>
                                <div class="site-widget spacing col-12" style="min-height:40px;"></div>
                                <div class="site-widget filtering">
                                    <h3 class="widget__title size-24 weight-600 text-default" style="color:#000;margin-bottom:25px;">
                                        <label for="widget-1525704376863">Fiyat</label>
                                    </h3>
                                    <div class="widget__content" data-multi_choice="false">
                                        <?php foreach($productPriceRanges as $priceRange): ?>
                                        <div class="filter-tag">
                                            <input class="filter price-range-filter" id="filter_by_price<?php echo $priceRange['_id']?>" type="checkbox" value="<?php echo $priceRange['_id']?>" data-start="<?php echo $priceRange['start']?>" data-end="<?php echo $priceRange['end']?>"/>
                                            <?php if($priceRange['start']==0): ?>
                                                <label for="filter_by_price<?php echo $priceRange['_id']?>"><?php echo $priceRange['end'] ?> TL Altında</label>
                                            <?php elseif($priceRange['end']==9999):?>
                                                <label for="filter_by_price<?php echo $priceRange['_id']?>"><?php echo $priceRange['start'] ?> TL Üzerinde</label>
                                            <?php else: ?>
                                                <label for="filter_by_price<?php echo $priceRange['_id']?>"><?php echo $priceRange['start'] ?> TL - <?php echo $priceRange['end'] ?> TL</label>
                                            <?php endif;?>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <?php endif ?>
                            </div>
                        </div>
                        <div class="sidebar__overlay"></div>
                    </aside>
                    <div id="site-primary" class="col-12 col-p-75">
                        <div class="collection-bar">
                            <div class="d-flex align-items-center collection-toolbar">
                                <div class="toolbar-left d-block d-lg-none">
                                    <div class="sidebar__btn d-flex align-items-center justify-content-center">
                                        <svg class="svg-icon" width="16" height="16">
                                            <use xlink:href="#global__symbols-sidebar"></use>
                                        </svg>
                                    </div>
                                </div>
                                <ul class="toolbar-right">
                                    <li>
                                        <div class="select-wrapper">
                                            <select name="SortBy" id="orderby-select" class="hidden">
                                                <option data-order-by="title" data-order-dir="asc" value="Alfabetik, A-Z" <?php echo isset($qsParams["sort"]) && strpos($qsParams["sort"],"title,asc") !== false ? "selected" : "" ?>>Alfabetik, A-Z</option>
                                                <option data-order-by="title" data-order-dir="desc" value="Alfabetik, Z-A" <?php echo isset($qsParams["sort"]) && strpos($qsParams["sort"],"title,desc") !== false ? "selected" : "" ?>>Alfabetik, Z-A</option>
                                                <option data-order-by="price" data-order-dir="asc" value="Artan Fiyat" <?php echo isset($qsParams["sort"]) && strpos($qsParams["sort"],"price,asc") !== false ? "selected" : "" ?>>Artan Fiyat</option>
                                                <option data-order-by="price" data-order-dir="desc" value="Azalan Fiyat" <?php echo isset($qsParams["sort"]) && strpos($qsParams["sort"],"price,desc") !== false ? "selected" : "" ?>>Azalan Fiyat</option>
                                                <option data-order-by="createdAt" data-order-dir="desc" value="Yeni Eklenenler" <?php echo !isset($qsParams["sort"]) || empty($qsParams["sort"]) ? "selected" : (isset($qsParams["sort"]) && strpos($qsParams["sort"],"createdAt,desc") !== false ? "selected" : "") ?>>Yeni Eklenenler</option>
                                                <option data-order-by="createdAt" data-order-dir="asc" value="Eski Eklenenler" <?php echo isset($qsParams["sort"]) && strpos($qsParams["sort"],"createdAt,asc") !== false ? "selected" : "" ?>>Eski Eklenenler</option>
                                            </select>
                                            <input id="DefaultSortBy" type="hidden" value="best-selling"/>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="" style="border-bottom:1px solid #ddd; display: block;padding-bottom:10px; margin-top: 15px; width: 100%;height: 1px;"></div>
                        </div>
                            <div class="shop-loader"></div>
                            <div class="row row-0 products products-grid grid-3 layout-2 sidebar-active">
                                <?php if (!empty($products)): ?>
                                <?php foreach ($products as $item): ?>
                                    <?php include(ROOT_DIR . "/templates/adahome/parts/product-item.php"); ?>
                                <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="no-products col-12">
                                        <p>Üzgünüz, hiçbir ürün bulamadık!</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div id="site-pagination">
                                <?php include(ROOT_DIR."/templates/adahome/parts/part-pagination.php"); ?>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

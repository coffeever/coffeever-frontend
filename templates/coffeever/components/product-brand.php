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
$filters = ["state"=>"active", "brand" => $pageData['_id']];
$sort = ["createdAt"=>-1];
if(isset($qsParams["sort"]) && !empty($qsParams["sort"])){
    $ps = explode(",",$qsParams["sort"]);
    if(!empty($ps) && count($ps)==2){
        $sort = [$ps[0]=>$ps[1]=="asc" ? 1 : -1];
    }
}

setConfigParam('PAGE_SIZE',9);
$productsRequest = makeRequest("getListWithCount", $filters,['collection'=>'products','projection'=>['title'=>1,'alias'=>1,'photos'=>1,'price'=>1, 'selectedVV'=>1],"limit"=>getConfigParam('PAGE_SIZE'), "skip" => getSkipSize(), "sort"=>$sort]);
$products = isset($productsRequest["result"]) ? $productsRequest["result"] : [];
$total = !empty($products) ? $productsRequest["total"] : 0;
$pageMax = !empty($total) ? calcPageMax($total) : 1;
$pageNum = getPage();

$xml = simplexml_load_file('http://www.tcmb.gov.tr/kurlar/today.xml');
$dolar = $xml->Currency->ForexSelling;
?>

<div id="shopify-section-collection-template" class="shopify-section">
    <div class="page-collection filters-sidebar" data-section-id="collection-template" data-section-type="collection-template">
        <div class="page-header page-title-default title-size-large color-scheme-light">
            <div class="title-section container" data-parallax='{"y" : -40, "smoothness": 10}'>
                <div class="title-section-wrapper d-flex flex-wrap flex-row align-items-center justify-content-center">
                    <div class="title-wrapper">
                        <div class="page-title-wrapper">
                            <a href="/" class="back-btn">
                                <svg class="svg-icon">
                                    <use xlink:href="#global__symbols-back"></use>
                                </svg>
                            </a>
                            <h1 class="page-title"><?php echo $pageData['title']?></h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page-header-bg-wrapper">
                <div class="page-header-bg rellax" data-rellax-speed="-1.5"style="background-color:#f7f7f7;background-image:url(/assets/img/brandsperde.jpg);background-repeat:repeat;background-position:center center;background-size:cover;background-attachment:scroll;"></div>
            </div>
        </div>
        <div class="page-content content-area" style="padding-left:0px;padding-right:0px;">
            <div class="container">
                <div class="row row-40">
                    <div id="site-primary" class="col-12">
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
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <?php if (!empty($products)): ?>
                            <div class="shop-loader"></div>
                            <div class="row row-0 products products-grid grid-4 layout-2 sidebar-active">
                                <?php foreach ($products as $item): ?>
                                    <?php include(ROOT_DIR."/templates/adahome/parts/product-item.php");?>
                                <?php endforeach; ?>
                            </div>
                            <div id="site-pagination">
                                <div class="ajax_load_button animated fadeIn">
                                    <a href="javascript:void(0);" class="loadmore hide" data-processing="0" data-no_more="No more items available.">
                                        <span>Load More</span>
                                        <div><i></i><i></i><i></i></div>
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
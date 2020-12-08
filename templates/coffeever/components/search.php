<?php
defined('INDEX') or die();
setConfigParam('PAGE_SIZE',8);

$keyword = isset($_GET['q']) ? urldecode(trim($_GET['q'])) : "";
$collection = isset($_GET['t']) && $_GET['t'] == 'posts' ? 'posts' : 'products';
$req = makeRequest('search/searchSingle',['state'=>'active'],['collection'=>$collection,'keyword'=>$keyword,'projection'=>['title'=>1,'alias'=>1,'photos'=>1,'price'=>1,'image'=>1, 'createdAt'=>1, 'description'=>1],"limit"=>getConfigParam('PAGE_SIZE'), "skip" => getSkipSize(), "sort"=>['createdAt'=>-1]]);
$items = isset($req["result"]) ? $req["result"] : [];
$total = !empty($items) ? $req["total"] : 0;
$pageMax = !empty($total) ? calcPageMax($total) : 1;
$pageNum = getPage();
?>
<div id="shopify-section-search-template" class="shopify-section">
    <div class="page-search content-area" style="padding-left:10px;padding-right:10px;">
        <div class="container">
            <div class="title-wrapper text-center">
                <?php if($total == 0): ?>
                    <h1 class="page-title">"<?php echo $keyword?>" için hiçbir sonuç bulunamadı</h1>
                <?php else: ?>
                    <h1 class="page-title">"<?php echo $keyword?>" için <?php echo $total ?> sonuç bulundu</h1>
                    <div class="text-center" style="color: #888;margin-top:10px;"><small>(sayfa: <?php echo $pageNum ?>)</small></div>
                <?php endif; ?>
            </div>
            <p class="search__infotext">Ne arıyorsun?</p>
            <form class="search-form" action="/ara" method="GET" role="search">
                <input type="hidden" name="t" value="<?php echo $collection ?>"/>
                <input type="search" name="q" placeholder="<?php echo $keyword?>" autofocus/>
                <button type="submit">Ara</button>
            </form>
            <?php if(!empty($items)): ?>
                <?php if($collection == 'posts'): ?>
                    <div class="blog-main">
                        <div class="site-widget spacing col-12" style="min-height:40px;" ></div>
                    <div class="blog__listing blog__grid row row-30">
                        <?php $postClass = 'col-12 col-md-3'; $isVertical=''; foreach ($items as $item): ?>
                            <?php include(ROOT_DIR."/templates/adahome/parts/post-item.php"); ?>
                        <?php endforeach; ?>
                    </div>
                    </div>
                <?php else: ?>
                    <div class="row row-0 products products-grid grid-4 layout-2">
                        <?php foreach ($items as $item): ?>
                            <?php include(ROOT_DIR."/templates/adahome/parts/product-item.php")?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <div id="site-pagination" style="margin-bottom: 60px;">
                    <?php include(ROOT_DIR."/templates/adahome/parts/part-pagination.php"); ?>
                </div>
            <?php else: ?>
            <div class="no-products">
                <p>"<?php echo $keyword?>" aramanız için herhangi bir sonuç bulunamadı.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

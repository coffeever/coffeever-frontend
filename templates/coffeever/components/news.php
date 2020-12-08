<?php
defined('INDEX') or die();
setConfigParam('PAGE_SIZE',9);
$pr = makeRequest("getListWithCount", ['state'=>'active'],['collection'=>'posts','projection'=>['title'=>1,'alias'=>1,'image'=>1,'createdAt'=>1,'description'=>1],"limit"=>getConfigParam('PAGE_SIZE'), "skip" => getSkipSize(), "sort"=>["createdAt" =>-1]]);
$blogPosts = isset($pr["result"]) ? $pr["result"] : [];
$total = !empty($blogPosts) ? $pr["total"] : 0;
$pageMax = !empty($total) ? calcPageMax($total) : 1;
$pageNum = getPage();

?>
<div id="shopify-section-blog-template" class="shopify-section">
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
                            <a itemprop="item" href="/yazilar">
                                <span itemprop="name">Blog</span>
                            </a>
                            <meta itemprop="position" content="2" />
                        </li>
                    </ol>
                    <div class="page-title-wrapper">
                        <h1 class="page-title">Blog</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-header-bg-wrapper" style="background: transparent">
            <div class="page-header-bg rellax" data-rellax-speed="-1.5"style="background-color:#fff;"></div>
        </div>
    </div>
    <div class="container content-area">
        <div class="row row-60">
            <?php if (!empty($blogPosts)): ?>
            <div id="site-primary" class="col-12 col-p-75">
                <div class="blog-main">
                    <div class="blog__listing blog__list">
                        <?php foreach ($blogPosts as $item): ?>
                            <?php include(ROOT_DIR."/templates/adahome/parts/post-item.php"); ?>
                        <?php endforeach; ?>
                    </div>
                    <div id="site-pagination" style="margin-bottom: 60px;">
                        <?php include(ROOT_DIR."/templates/adahome/parts/part-pagination.php"); ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <aside role="complementary" id="site-secondary" class="col-12 col-p-25">
                <div class="site-sidebar">
                    <div class="sidebar__close close-icon"></div>
                    <div class="widget-area">
                        <div class="site-widget" >
                            <div class="widget__content">
                                <form class="search-form" action="/ara" method="GET" role="search">
                                    <input type="hidden" name="t" value="posts" />
                                    <input type="search" name="q" value="" placeholder="Ara…" />
                                    <button type="submit">Ara</button>
                                </form>
                            </div>
                        </div>
                        <div class="site-widget spacing col-12" style="min-height:40px;" ></div>
                        <?php if (!empty($blogPosts)): ?>
                        <div class="site-widget listing" >
                            <h3 class="widget__title size-24 weight-600 text-default" style="color:#000;margin-bottom:25px;">
                                <label for="widget-1522591460641">Son Yazılar</label>
                            </h3>
                            <ul class="widget__content">
                            <?php foreach ($blogPosts as $blogPost): ?>
                                <li>
                                    <div class="listing__content">
                                        <a href="/yazilar/<?php echo $blogPost['alias'];?>" title="<?php echo $blogPost['title'];?>"><?php echo $blogPost['title'];?></a>
                                        <time datetime="<?php echo formatDateTime($blogPost['createdAt']);?>"><?php echo formatDateTime($blogPost['createdAt']);?></time>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="sidebar__overlay"></div>
            </aside>
        </div>
    </div>
</div>
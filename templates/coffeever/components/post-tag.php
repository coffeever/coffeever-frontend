<?php
defined('INDEX') or die();

if(isset($pageData['alias']) && !empty($pageData['alias'])){
    $filter["tags"] = $pageData["alias"];
    $tagBlogPosts = makeRequest("getList", $filter, ["collection" => "posts"]);
}
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
                            <a itemprop="item" href="#">
                                <span itemprop="name">Yazı Etiketleri</span>
                            </a>
                            <meta itemprop="position" content="2" />
                        </li>
                    </ol>
                    <div class="page-title-wrapper">
                        <h1 class="page-title"><?php echo $pageData['alias'];?></h1>
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
            <?php if (!empty($tagBlogPosts)): ?>
                <div id="site-primary" class="col-12 col-p-75">
                    <div class="blog-main">
                        <div class="blog__listing blog__list">
                            <?php foreach ($tagBlogPosts as $item): ?>
                                <?php include(ROOT_DIR."/templates/adahome/parts/post-item.php"); ?>
                            <?php endforeach; ?>
                        </div>
                        <nav class="site-pagination">
                            <ul class="notranslate d-flex align-items-center justify-content-center">
                                <li><span class="btn-active page-numbers d-flex align-items-center">1</span></li>
                                <li><a class="page-numbers d-flex align-items-center" href="/blogs/news?page=2">2</a></li>
                                <li><a class="next page-numbers d-flex align-items-center" title="Next" href="/blogs/news?page=2">→</a></li>
                            </ul>
                        </nav>
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
                        <?php if (!empty($tagBlogPosts)): ?>
                            <div class="site-widget listing" >
                                <h3 class="widget__title size-24 weight-600 text-default" style="color:#000;margin-bottom:25px;">
                                    <label for="widget-1522591460641">Son Yazılar</label>
                                </h3>
                                <ul class="widget__content">
                                    <?php foreach ($tagBlogPosts as $blogPost): ?>
                                        <li>
                                            <div class="listing__content">
                                                <a href="/yazilar/<?php echo $blogPost['alias'];?>" title="<?php echo $blogPost['title'];?>"><?php echo $blogPost['title'];?></a>
                                                <time datetime="<?php echo $blogPost['createdAt'];?>"><?php echo $blogPost['createdAt'];?></time>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <div class="site-widget spacing col-12" style="min-height:40px;" ></div>
                    </div>
                </div>
                <div class="sidebar__overlay"></div>
            </aside>
        </div>
    </div>
</div>

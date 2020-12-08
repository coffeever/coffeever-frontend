<?php
defined('INDEX') or die();
global $actionResult;

if(isset($pageData['alias']) && !empty($pageData['alias'])){
    $post = makeRequest("get", ["alias" => $pageData['alias']], ["collection" => "posts"]);
    $postComments = makeRequest("getList", ["postId" => $post['_id'], "status"=>true], ["collection" => "comments"]);
    $posts = makeRequest("getList", [], ["collection" => "posts"]);

    foreach($posts as $key => $otherPost) {
        if ($otherPost['_id'] == $post['_id']) {
            $index = $key;
            break;
        }
    }
    if (isset($index)) {
        if ($index == count($posts) - 1) {
            $previousPost = $posts[$index - 1];
            $nextPost = $posts[0];
        } else if ($index == 0) {
            $previousPost = $posts[count($posts) - 1];
            $nextPost = $posts[$index + 1];
        } else {
            $previousPost = $posts[$index - 1];
            $nextPost = $posts[$index + 1];
        }
    }
}
debugPrint($postComments);
?>
<div id="shopify-section-article-template" class="shopify-section">
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
                                <span itemprop="name">Yazılar</span>
                            </a>
                            <meta itemprop="position" content="2" />
                        </li>
                    </ol>
                    <div class="page-title-wrapper">
                        <h1 class="page-title"><?php echo $post['title'];?></h1>
                    </div>
                    <div class="page-meta">
                        <span class="page-delimiter"></span>
                        <ul class="page-meta_list form-animate">
                            <li class="meta-date"><span><?php echo formatDateTime($post['createdAt'])?></span></li>
                            <li class="meta-share">
                                <div class="meta-share_container">
                                    <a href="javascript:void(0);" class="social-sharing" data-share_img="<?php echo getTimthumbImage($post['image'], 540, 360, 1); ?>" data-title="<?php echo $post['title']?>" data-name="Paylaş" data-share_elem="facebook,twitter,google,pinterest">
                                        <span>Paylaş</span>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-header-bg-wrapper" style="background: transparent">
            <div class="page-header-bg rellax" data-rellax-speed="-1.5"style="background-color:#fff;"></div>
        </div>
    </div>
    <div class="container content-area">
        <div class="row row-60 justify-content-center">
            <div id="site-primary" class="col-12 col-p-83">
                <div class="article-main">
                    <article class="article__listing" itemscope itemtype="http://schema.org/Article">
                        <?php if (isset($post['image']) && !empty($post['image'])): ?>
                        <header class="article__image"><img class="lazyload"
                                                            src="<?php echo getTimthumbImage($post['image'], 720, 360, 1); ?>"
                                                            data-src="<?php echo getTimthumbImage($post['image'], 720,360, 1); ?>"
                                                            data-widths="[180, 360, 540, 720, 900, 1080, 1296, 1512, 1728, 2048]"
                                                            data-aspectratio="1.6"
                                                            data-sizes="auto"
                                                            tabindex="-1"
                                                            alt="<?php echo $post['title'];?>" />
                        </header>
                        <?php endif; ?>
                        <div class="row justify-content-center">
                            <div class="col-12 col-p-83">
                                <div class="article__content" itemprop="articleBody">
                                    <?php echo $post['description'];?>
                                </div>
                                <?php if (!empty($post['tags'])): ?>
                                    <footer class="article__meta">
                                        <ul class="article__tags">
                                            <?php foreach ($post['tags'] as $tag): ?>
                                                <li>
                                                    <a href="/yazi-etiketleri/<?php echo $tag;?>" title="Şu etikete sahip ürünleri görüntüle: <?php echo $tag;?>">
                                                        <?php echo $tag;?>
                                                    </a>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </footer>
                                <?php endif; ?>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </div>
    <div class="site-pagination">
        <div class="container">
            <div class="row">
                <?php if (isset($previousPost)): ?>
                <div class="col-12 col-md-6">
                    <div class="nav-prev text-left">
                        <a href="/yazilar/<?php echo $previousPost['alias'];?>">
                            <div class="nav-title">Önceki Yazı</div>
                            <span><?php echo $previousPost['title'];?></span>
                        </a>
                    </div>
                </div>
                <?php endif; ?>
                <?php if (isset($nextPost)): ?>
                <div class="col-12 col-md-6">
                    <div class="nav-next text-right has-border">
                        <a href="/yazilar/<?php echo $nextPost['alias'];?>">
                            <div class="nav-title">Sonraki Yazı</div>
                            <span><?php echo $nextPost['title'];?></span>
                        </a>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="article__comments-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-p-66">
                    <div class="article__comments" id="comments">
                        <?php if (isset($postComments) && !empty($postComments)): ?>
                            <div class="spr-header">
                                <h2 class="spr-header-title">Yorumlar</h2>
                                <div class="spr-summary">
                                                        <span class="spr-starrating spr-summary-starrating">
                                                            <i class="spr-icon spr-icon-star"></i><i class="spr-icon spr-icon-star"></i><i class="spr-icon spr-icon-star"></i><i class="spr-icon spr-icon-star"></i><i class="spr-icon spr-icon-star"></i>
                                                        </span>
                                    <span class="spr-summary-caption"><span class="spr-summary-actions-togglereviews"><?php echo count($postComments) . ' Yorum'?></span></span>
                                </div>
                                <?php foreach ($postComments as $comment): ?>
                                    <div class="spr-reviews">
                                        <div class="spr-review" id="spr-review-92018206">
                                            <div class="spr-review-header">
                                                <h3 class="spr-review-header-title"><?php echo $comment['commentSubject']; ?></h3>
                                                <span class="spr-review-header-byline"><strong><?php echo $comment['name']; ?></strong>, <strong><?php echo formatDateTime($comment['createdAt']); ?></strong></span>
                                            </div>
                                            <div class="spr-review-content">
                                                <p class="spr-review-content-body"><?php echo $comment['commentMessage']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-12 col-p-66">
                    <div class="article__comments" id="comments">
                        <div class="alert-<?php echo isset($actionResult['status']) && $actionResult['status'] ? 'success' : 'danger' ?> show" role="alert" style="display: <?php echo isset($actionResult) && !empty($actionResult['message']) ? 'block' : 'none'; ?>">
                            <?php echo isset($actionResult['message']) ? $actionResult['message'] : ''; ?>
                        </div>
                        <h2 class="reply-heading">Yorum Yap</h2>
                        <p class="reply-notes">E-posta hesabınız gizli kalacaktır. * işaretli alanların doldurulması zorunludur.</p>
                        <form method="post" action="" id="comment_form" accept-charset="UTF-8" class="comment-form">
                            <input type="hidden" name="_nonce" value="<?php echo md5(INDEX); ?>">
                            <input type="hidden" name="action" value="send_comment">
                            <input type="hidden" name="postId" value="<?php echo $post['_id'];?>" />
                            <div class="row">
                                <div class="form-group col-12">
                                    <label for="article-template-name">Konu <span class="required">*</span></label>
                                    <input id="article-template-name" type="text" name="comment-title" required="required"/>
                                </div>
                                <div class="form-group col">
                                    <label for="article-template-body">Yorum <span class="required">*</span></label>
                                    <textarea name="comment-message" required="required"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12 col-md-4">
                                    <label for="article-template-name">İsim <span class="required">*</span></label>
                                    <input id="article-template-name" type="text" name="comment-name" required="required"/>
                                </div>
                                <div class="form-group col-12 col-md-8">
                                    <label for="article-template-email">Eposta <span class="required">*</span></label>
                                    <input id="article-template-email" type="email" name="comment-email" required="required" autocorrect="off" autocapitalize="off" />
                                </div
                            </div>
                            <div class="row">
                                <div class="form-group col">
                                    <button type="submit" class="btn btn-primary">Yorum Yap</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
defined('INDEX') or die();
global $actionResult;
?>
<div class="content-area">
    <div class="site-account" id="CustomerLoginForm" style="margin-bottom: 100px">
        <form method="post" action="" accept-charset="UTF-8">
            <input type="hidden" name="_nonce" value="<?php echo md5(INDEX); ?>">
            <input type="hidden" name="action" value="renew-password">
            <input type="hidden" name="subscriberId" value="<?php echo $pageData['_id'];?>">
            <input type="hidden" name="token" value="<?php echo $pageData['token'];?>">
            <div class="alert alert-<?php echo isset($actionResult['status']) && $actionResult['status'] ? 'success' : 'danger' ?> <?php echo isset($actionResult['status']) ? '' : 'hide' ?>">
                <div class="alert__icon">
                    <i class="ris ri-check"></i>
                </div>
                <div class="alert__content"><?php echo isset($actionResult['message']) ? $actionResult['message'] : ''; ?></div>
            </div>
            <div class="title-wrapper text-center">
                <ol class="breadcrumbs d-flex align-items-center justify-content-center" itemscope itemtype="http://schema.org/BreadcrumbList">
                    <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                        <a itemprop="item" href="/">
                            <span itemprop="name">Anasayfa</span><span class="delimiter">/</span>
                        </a>
                        <meta itemprop="position" content="1" />
                    </li>
                    <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                        <a itemprop="item" href="/giris-yap">
                            <span itemprop="name">Hesap</span>
                        </a>
                        <meta itemprop="position" content="2" />
                    </li>
                </ol>
                <h1 class="page-title">Parolayı Değiştir</h1>
            </div>
            <div class="form-group">
                <label for="customer_login-password">Parola<span class="required">*</span></label>
                <input id="customer_login-password" type="password" value="" name="password" required="required" />
            </div>
            <div class="form-group">
                <label for="customer_login-password">Parola Tekrar<span class="required">*</span></label>
                <input id="customer_login-password" type="password" value="" name="password2" required="required" />
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary w100">Değiştir</button>
            </div>
        </form>
    </div>
</div>

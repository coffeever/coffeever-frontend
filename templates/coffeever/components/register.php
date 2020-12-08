<?php
defined('INDEX') or die();
global $actionResult;
?>

<div class="container content-area">
    <div class="site-account">
        <form method="post" action="" accept-charset="UTF-8">
            <input type="hidden" name="_nonce" value="<?php echo md5(INDEX); ?>">
            <input type="hidden" name="action" value="register">
            <div class="title-wrapper text-center">
                <ol class="breadcrumbs d-flex align-items-center justify-content-center" itemscope itemtype="http://schema.org/BreadcrumbList">
                    <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                        <a itemprop="item" href="/">
                            <span itemprop="name">Anasayfa</span><span class="delimiter">/</span>
                        </a>
                        <meta itemprop="position" content="1" />
                    </li>
                    <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                        <a itemprop="item" href="https://rt-barberry.myshopify.com/account/register">
                            <span itemprop="name">Hesap Oluştur</span>
                        </a>
                        <meta itemprop="position" content="2" />
                    </li>
                </ol>
                <h1 class="page-title">Kayıt Ol</h1>
            </div>
            <div class="message-box alert alert-<?php echo isset($actionResult['status']) && $actionResult['status'] ? 'success' : 'danger' ?> fade show" role="alert" style="display: <?php echo isset($actionResult) && !empty($actionResult['message']) ? 'block' : 'none'; ?>">
                <?php echo isset($actionResult['message']) ? $actionResult['message'] : ''; ?>
            </div>
            <div class="form-group">
                <label for="customer_register-name">Adınız</label>
                <input id="customer_register-name" type="text" name="customer-name" autofocus />
            </div>
            <div class="form-group">
                <label for="customer_register-surname">Soyadınız</label>
                <input id="customer_register-surname" type="text" name="customer-surname" />
            </div>
            <div class="form-group">
                <label for="customer_register-email">E-posta Adresiniz<span class="required">*</span></label>
                <input id="customer_register-email" type="email" name="customer-email" autocorrect="off" autocapitalize="off" required="required" />
            </div>
            <div class="form-group">
                <label for="customer_register-password">Parolanız<span class="required">*</span></label>
                <input id="customer_register-password" type="password" name="customer-password" required="required" />
            </div>
            <div class="form-group">
                <label for="customer_register-password">Parolanız Tekrar<span class="required">*</span></label>
                <input id="customer_register-password" type="password" name="customer-repassword" required="required" />
            </div>
            <p class="form-animate">Kişisel verileriniz, bu web sitesindeki deneyiminizi desteklemek, hesabınıza erişimi yönetmek ve <a href="/gizlilik-politikasi" target="_blank">gizlilik politikamızda</a>. açıklanan diğer amaçlar için kullanılacaktır.</p>
            <div class="form-group">
                <button type="submit" class="btn btn-primary w100">Kayıt Ol</button>
            </div>
            <div class="form-divider">
                <span>veya</span>
            </div>
            <div class="form-group">
                <a href="/giris-yap" class="btn w100">Giriş Yap</a>
            </div>
        </form>
    </div>
</div>
<?php
defined('INDEX') or die();
global $actionResult;
?>
<div id="shopify-section-page-contact-template" class="shopify-section">
    <div class="page-contact" data-section-id="page-contact-template" data-section-type="page-contact-template">
        <div class="content-area">
            <div class="row row-0">
                <div class="col-12 col-lg-7 col-xl-8">
                    <div id="MapSection--page-contact-template" class="map-section d-flex flex-wrap flex-row align-items-center" data-section-id="page-contact-template" data-section-type="map">
                        <div class="map-section__background-wrapper">
                            <div class="map-section__image lazyload" style="background-image: url('//cdn.shopify.com/s/files/1/0151/4327/2548/files/contact-bg_x3.jpg?v=1551087855');" data-bgset="//cdn.shopify.com/s/files/1/0151/4327/2548/files/contact-bg_180x.jpg?v=1551087855 180w 144h,//cdn.shopify.com/s/files/1/0151/4327/2548/files/contact-bg_360x.jpg?v=1551087855 360w 288h,//cdn.shopify.com/s/files/1/0151/4327/2548/files/contact-bg_540x.jpg?v=1551087855 540w 432h,//cdn.shopify.com/s/files/1/0151/4327/2548/files/contact-bg_720x.jpg?v=1551087855 720w 576h,//cdn.shopify.com/s/files/1/0151/4327/2548/files/contact-bg_900x.jpg?v=1551087855 900w 720h,//cdn.shopify.com/s/files/1/0151/4327/2548/files/contact-bg_1080x.jpg?v=1551087855 1080w 864h,//cdn.shopify.com/s/files/1/0151/4327/2548/files/contact-bg.jpg?v=1551087855 1280w 1024h" data-sizes="auto" data-parent-fit="cover">&nbsp;</div>
                        </div>
                    </div>
                    <div class="message-box alert alert-<?php echo isset($actionResult['status']) && $actionResult['status'] ? 'success' : 'danger' ?> fade show" role="alert" style="display: <?php echo isset($actionResult) && !empty($actionResult['message']) ? 'block' : 'none'; ?>">
                        <?php echo isset($actionResult['message']) ? $actionResult['message'] : ''; ?>
                    </div>
                    <form id="contact_form" class="contact-form" accept-charset="UTF-8" action="" method="post" style="padding: 50px;">
                        <input type="hidden" name="_nonce" value="<?php echo md5(INDEX); ?>">
                        <input type="hidden" name="form-name" value="İletişim Formu">
                        <input type="hidden" name="action" value="send_contact">
                        <div class="row">
                            <div class="form-group col-12 col-lg-6">
                                <label for="page-contact-template-name">Adınız<span class="required">*</span></label>
                                <input id="page-contact-template-name" name="contact-name" required="required" type="text" />
                            </div>
                            <div class="form-group col-12 col-lg-6">
                                <label for="page-contact-template-email">Eposta<span class="required">*</span></label>
                                <input id="page-contact-template-email" name="contact-email" required="required" type="email" />
                            </div>
                            <div class="form-group col-12 col-lg-12">
                                <label for="page-contact-template-name">Konu<span class="required">*</span></label>
                                <input id="page-contact-template-name" name="contact-subject" required="required" type="text" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12">
                                <label for="page-contact-template-message">Mesajınız<span class="required">*</span></label>
                                <textarea name="contact-message" required="required" rows="10"></textarea></div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12">
                                <button class="btn btn-primary" type="submit">G&ouml;nder</button>
                            </div>
                        </div>
                    </form></div>
                <div class="col-12 col-lg-5 col-xl-4">
                    <div class="row row-0">
                        <div class="col-2 d-none d-lg-block">&nbsp;</div>
                        <div class="col-12 col-lg-9">
                            <div class="contact-info has-padding">
                                <h1 class="contact-title">İletişim</h1>
                                <ul class="contact-content">
                                    <li>
                                        <h3>M&uuml;şteri İlişkileri</h3>
                                        <p><strong>Tel </strong><a href="tel://+90 549 797 87 44">+90 549 797 87 44</a></p>
                                    </li>
                                    <li>
                                        <h3>Fabrika Adres</h3>
                                        <p>Yeni Mah. Incirlik blv. NO:27<br />Sarı&ccedil;am / Adana</p>
                                        <p><strong>Tel </strong><a href="tel://+90 322 332 68 68">+90 322 332 68 68</a></p>
                                        <p><strong>Whatsapp </strong><a href="https://api.whatsapp.com/send?phone=+905497978744" target="_blank" rel="noopener">+90 549 797 87 44</a></p>
                                        <p><strong>Mail </strong><a href="mailto:info@adawall.com.tr">info@adawall.com.tr</a></p>
                                    </li>
                                    <li>
                                        <h3>İstanbul Showroom</h3>
                                        <p>Wyndham Grand İstanbul Europe Hotel Lobby si giriş katı, Mimar Sinan Cadessi 80-82<br />G&uuml;neşli / İstanbul</p>
                                        <p><strong>Tel </strong><a href="tel://+90 539 335 77 73">+90 539 335 77 73</a></p>
                                    </li>
                                    <li>
                                        <h3>Ankara Showroom</h3>
                                        <p>Anafartalar Mh. R&uuml;zgarlı Caddesi No:28/A<br />Altındağ / Ankara</p>
                                        <p><strong>Tel </strong><a href="tel://+90 312 514 00 00">+90 312 514 00 00</a></p>
                                    </li>
                                    <li>
                                        <h3>Adana Showroom</h3>
                                        <p>Beyazevler Mahallesi, &Ouml;zdemir Sabancı Blv., Dsi karşısı, 01150<br />&Ccedil;ukurova / Adana</p>
                                        <p><strong>Tel </strong><a href="tel://+90 322 228 32 32">+90 322 228 32 32</a></p>
                                    </li>
                                    <li>
                                        <h3>Kıbrıs Showroom</h3>
                                        <p>Goşşili İş Merkezi No:1, Karaoğlanoğlu 9935<br />Girne / Kıbrıs</p>
                                        <p><strong>Tel </strong><a href="tel://+90 533 851 09 09">+90 533 851 09 09</a></p>
                                    </li>
                                </ul>
                                <div class="delimiter col-12">&nbsp;</div>
                                <ul class="social-icons row row-40">
                                    <li class="col-auto"><a class="social-icons__link" title="Twitterda Adawall" href="https://twitter.com/"> </a></li>
                                    <li class="col-auto"><a class="social-icons__link" title="Facebookda Adawall" href="https://facebook.com/"> </a></li>
                                    <li class="col-auto"><a class="social-icons__link" title="Pinterestde Adawall" href="https://pinterest.com/"> </a></li>
                                    <li class="col-auto"><a class="social-icons__link" title="Google Plusda Adawall" href="https://plus.google.com/"> </a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
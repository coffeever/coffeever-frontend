<?php
debugPrint($pageData);
defined('INDEX') or die();
?>
<div id="shopify-section-page-faqs-template" class="shopify-section">
    <div class="page-faqs">
        <div class="content-area">
            <div class="row row-0">
                <div class="col-12 col-lg-5 col-xl-4 faqs-left">
                    <div class="faqs-inner">
                        <h1 class="faqs-title">Sıkça</h1>
                        <h1 class="faqs-title">Sorulan</h1>
                        <h1 class="faqs-title">Sorular</h1>
                        <div class="faqs-description">Sıkça sorulan sorulara göz atın.</div>
                    </div>
                </div>
                <div class="col-12 col-lg-7 col-xl-8 faqs-right">
                    <div class="faqs-inner">
                        <?php if (isset($pageData) && !empty($pageData)): ?>
                            <?php foreach ($pageData as $faq): ?>
                                <div class="faq-heading"><h2><?php echo $faq['name']; ?></h2></div>
                                <?php foreach ($faq['questions'] as $question): ?>
                                    <div class="faq-item row row-0">
                                        <div class="col-12 col-md-6">
                                            <h4 class="faq-question"><?php echo $question['title']?></h4>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="faq-answer"><?php echo $question['content']?></div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="site-overlay"></div>
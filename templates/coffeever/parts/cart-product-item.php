<?php defined('INDEX') or die(); ?>
<?php if(isset($item) && !empty($item)): ?>
<tr class="cart__item" data-timestamp="<?php echo $item['timestamp'] ?? '' ?>">
    <td class="item__remove">
        <a id="cart-list-remove-btn" title="Bu ürünü sepetten kaldır" data-id="<?php echo $item['id']; ?>">×</a>
    </td>
    <td class="item__image">
        <a href="<?php echo $item['link']; ?>">
            <img src="<?php echo $item['image']; ?>"
                 srcset="<?php echo $item['image']; ?> 1x, <?php echo $item['image']; ?> 2x"
                 alt="<?php echo $item['title']; ?>"/>
        </a>
    </td>
    <td class="item__content d-flex">
        <div class="item__content-name">
            <div class="item__name">
                <a href="<?php echo $item['link']; ?>"><?php echo $item['title']; ?></a>
            </div>
            <div class="item__quantity">
                <div class="item__qty item__qty-cart-template">
                    <button type="button" class="ris ri-minus qtybutton qty-minus"></button>
                    <input class="qty" type="text" name="updates[]" value="<?php echo $item['quantity']; ?>" min="1" pattern="[0-9]*" data-id="<?php echo $item['id']; ?>">
                    <button type="button" class="ris ri-plus qtybutton qty-plus"></button>
                </div>
            </div>
        </div>
        <div class="item__content-name">
            <div class="item__name">
                <a>Ürün Özellikleri:</a><br>
                <?php foreach ($item['specs'] as $key => $itemSpec): ?>
                    <span class="product-spec"><strong><?php echo titleToSentence($key); ?>:</strong> <?php echo (isset($specs[$itemSpec])) ? titleToSentence($specs[$itemSpec]) : titleToSentence($itemSpec); ?> </span>
                <?php endforeach; ?>
            </div>
            <div class="item__subtotal">
                <div>
                    <span class="money"><span class="currency_symbol">₺</span><?php echo $item['price']; ?></span>
                </div>
            </div>
        </div>
    </td>
    <input type="hidden" name="hidden-cropped-image" class="hidden-cropped-image">
</tr>
<?php endif;?>
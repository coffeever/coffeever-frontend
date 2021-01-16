<?php
defined('INDEX') or die();
?>
<section class="home-slider owl-carousel">
<div class="slider-item" style="background-image: url(templates/coffeever/images/bg_3.jpg);" data-stellar-background-ratio="0.5">
  <div class="overlay"></div>
  <div class="container">
    <div class="row slider-text justify-content-center align-items-center">

      <div class="col-md-7 col-sm-12 text-center ftco-animate">
          <h1 class="mb-3 mt-5 bread">Your Favourite Coffees</h1>
         
      </div>

    </div>
  </div>
</div>
</section>
<section class="ftco-section ftco-cart">
      <div class="container">
          <div class="row">
          <div class="col-md-12 ftco-animate fadeInUp ftco-animated">
              <div class="cart-list">
                  <table class="table">
                      <thead class="thead-primary">
                        <tr class="text-center">
                          <th>&nbsp;</th>
                          <th>Coffee</th>
                          <th>Aroma</th>
                          <th>Acidity</th>
                          <th>Body</th>
                          <th>Flavor</th>
                          <th>Decaffeinated</th>
                          <th>Roast</th>                                
                          <th>&nbsp;</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach($pageData as $result): ?>
                          <tr class="text-center">
                            <td class="image-prod"><div class="img" style="background-image:url(templates/coffeever/images/menu-2.jpg);"></div></td>
                            
                            <td class="product-name">
                                <h3><a href="/coffee-detail/<?php echo $result['slug'] ?>"><?php echo $result['name'] ?></a></h3>
                                <p><?php echo excerptStringByWord($result['blindAssessment'], 12); ?></p>
                            </td>
                            
                            <td class="total" id="aroma"><?php echo $result['aroma'] ?></td>                                
                            <td class="total" id="acidity"><?php echo $result['acidity'] ?></td>
                            <td class="total" id="body"><?php echo $result['body'] ?></td>
                            <td class="total" id="flavor"><?php echo $result['flavor'] ?></td>
                            <td class="total" id="decaf"><?php echo ($result['decaf']) ? 'Yes' : 'No'; ?></td>
                            <td class="total" id="roast"><?php echo $result['roast'] ?></td>
                            <td  class="favorite">
                                <form method="post">
                                    <input type="hidden" name="_nonce" value="<?php echo md5(INDEX); ?>">
                                    <input type="hidden" name="action" value="delete-fav">
                                    <input type="hidden" name="user-id" value="<?php echo $_SESSION['subscriberObj']['google_id'] ?>">
                                    <input type="hidden" name="coffee-slug" value="<?php echo $result['slug'] ?>">
                                    <button type="button" id="button1" class="favoritebutton" onclick="Warn(this.id);">Delete</button>
                                </form>
                            </td>
                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                </div>
          </div>
      </div>
      
      </div>
  </section>
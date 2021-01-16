<?php
defined('INDEX') or die();
global $actionResult;
debugPrint($actionResult);
$keywords = explode(', ', $pageData['keywords']);
?>
<section class="home-slider owl-carousel">
<div class="slider-item" style="background-image: url(/templates/coffeever/images/bg_3.jpg);" data-stellar-background-ratio="0.5">
  <div class="overlay"></div>
  <div class="container">
    <div class="row slider-text justify-content-center align-items-center">

      <div class="col-md-7 col-sm-12 text-center ftco-animate">
          <h1 class="mb-3 mt-5 bread">Details</h1>
        
      </div>

    </div>
  </div>
</div>
</section>

<section class="ftco-section">
  <div class="container">
      <div class="row">
          <div class="col-lg-6 mb-5 ftco-animate fadeInUp ftco-animated">
              <a href="images/menu-2.jpg" class="image-popup"><img src="/templates/coffeever/images/menu-2.jpg" class="img-fluid" alt="Colorlib Template"></a>
          </div>


          <div class="col-lg-6 mb-5 ftco-animate fadeInUp ftco-animated">
              <span>
                  <h3>
                  <span class="left-text"><?php echo $pageData['name']; ?></span>
                  <span class="decaf" id="showdecaf"> <?php echo ($pageData['decaf']) ? 'Decaffeinated' : ''; ?></span> 
                  </h3>

              <p class="Properties"><span class="phead">Properties</span> </p>
              <div class="container">
                  <div class="row">
              <div class="col-sm">
              <ul>
                  <li><span class="pname">Aroma: </span> <span class="prop" id="aromaprop"> <?php echo $pageData['aroma']; ?></span> </li>
                  <li><span class="pname">Acidity: </span> <span class="prop" id="acidprop"> <?php echo $pageData['acidity']; ?></span> </li>
                  <li><span class="pname">Body: </span> <span class="prop" id="bodyprop"> <?php echo $pageData['body']; ?></span> </li>
                  <li><span class="pname">Flavor: </span> <span class="prop" id="flavorprop"> <?php echo $pageData['flavor']; ?></span> </li>
                  <li><span class="pname">Roast: </span> <span class="prop" id="roastprop"> <?php echo $pageData['roast']; ?></span> </li>
                  <li><span class="pname">Region: </span> <span class="prop" id="regionprop"> <?php echo $pageData['region']; ?></span> </li>
              </ul>   
              </div> 

               <div class="col-sm">
                  <span class="rate" style=" margin-left: 10%;">Rating</span><br><br>
                      <div class="c100 p73 orange">
                          <span id="rating"><?php echo $pageData['rating']; ?>%</span>
                          <div class="slice">
                              <div class="bar"></div>
                              <div class="fill"></div>
                          </div>
                      </div>
               </div> 
               </div>  
           </div>
              <p>This coffee bean is <?php echo $pageData['roast']; ?> roasted and grown in the <?php echo $pageData['region']; ?> region.</p>
              <form method="post">
                <input type="hidden" name="_nonce" value="<?php echo md5(INDEX); ?>">
                <input type="hidden" name="action" value="login">
                <?php if(isLoggedIn()): ?>
                  <input type="hidden" name="user-id" value="<?php echo $_SESSION['subscriberObj']['google_id'] ?>">
                <?php endif; ?>
                <input type="hidden" name="coffee-slug" value="<?php echo $pageData['slug'] ?>">
                <button type="submit" <?php echo (isLoggedIn()) ? '' : 'disabled'; ?>>+Add Favourite</button>
              </form>
          </div>
      </div>
  </div>

  <div class="container ftco-menu mb-5 pb-5">
      
      <div class="row d-md-flex">
          <div class="col-lg-8 ftco-animate  fadeInUp ftco-animated">
              <div class="row">
            <div class="col-md-12 nav-link-wrap mb-5">
              <div class="nav ftco-animate nav-pills  fadeInUp ftco-animated" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link active" id="v-pills-2-tab" data-toggle="pill" href="#v-pills-2" role="tab" aria-controls="v-pills-2" aria-selected="true">Blind Assessment</a>

                <a class="nav-link" id="v-pills-3-tab" data-toggle="pill" href="#v-pills-3" role="tab" aria-controls="v-pills-3" aria-selected="false">Notes</a>
                <a class="nav-link" id="v-pills-4-tab" data-toggle="pill" href="#v-pills-4" role="tab" aria-controls="v-pills-4" aria-selected="false">Who Should Drink</a>
              </div>
            </div>
            <div class="col-md-12 d-flex align-items-center">
              
              <div class="tab-content ftco-animate fadeInUp ftco-animated" id="v-pills-tabContent">

                <div class="tab-pane fade show active" id="v-pills-2" role="tabpanel" aria-labelledby="v-pills-2-tab">
                  <div class="row">
                      <div class=" text-center">
                          <div class="menu-wrap">
                              <div class="text">
                                  <h3>Blind Assessment</h3>
                                  <p><?php echo $pageData['blindAssessment']; ?></p>
                                 
                              </div>
                          </div>
                      </div>
                  </div>
                </div>

                <div class="tab-pane fade" id="v-pills-3" role="tabpanel" aria-labelledby="v-pills-3-tab">
                  <div class="row">
                      <div class=" text-center">
                          <div class="menu-wrap">
                              <div class="text">
                                  <h3>Notes</h3>
                                  <p><?php echo $pageData['notes']; ?></p>
                                 
                              </div>
                          </div>
                      </div>
                  </div>
                </div>
                <div class="tab-pane fade" id="v-pills-4" role="tabpanel" aria-labelledby="v-pills-4-tab">
                  <div class="row">
                      <div class=" text-center">
                          <div class="menu-wrap">
                              <div class="text">
                                  <h3>Who Should Drink</h3>
                                  <p><?php echo $pageData['whoShouldDrink']; ?></p>
                                 
                              </div>
                          </div>
                      </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      <?php if(isset($keywords) && !empty($keywords)): ?>
      <div class="col-lg-4">
          <div class="sidebar-box ftco-animate fadeInUp ftco-animated">
              <h3>Keywords</h3>
                  <div class="tagcloud">
                    <?php foreach($keywords as $keyword): ?>
                      <a href="#" class="tag-cloud-link"><?php echo $keyword; ?></a>
                    <?php endforeach; ?>
                  </div>
          </div>
      </div>
      <?php endif; ?>
      </div>
  </div>
</section>
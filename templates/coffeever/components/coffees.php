<?php
defined('INDEX') or die();
$coffees = makeRequest('getAllCoffees', [], 'GET');

setConfigParam('PAGE_SIZE',9);
$filters = [
  "limit"=>getConfigParam('PAGE_SIZE'),
  "offset" => getSkipSize()
];
$productsRequest = makeRequest("getSomeCoffee", $filters, 'GET');
debugPrint($productsRequest);
$newCoffees = isset($productsRequest["result"]) ? $productsRequest["result"] : [];
$total = !empty($coffees) ? count($coffees) : 0;
$pageMax = !empty($total) ? calcPageMax($total) : 1;
$pageNum = getPage();
debugPrint(getSkipSize());
?>
<section class="home-slider owl-carousel">

<div class="slider-item" style="background-image: url(templates/coffeever/images/bg_3.jpg);" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
  <div class="container">
    <div class="row slider-text justify-content-center align-items-center">

      <div class="col-md-7 col-sm-12 text-center ftco-animate">
          <h1 class="mb-3 mt-5 bread">Coffees</h1>
        
      </div>

    </div>
  </div>
</div>
</section>

<section class="ftco-section">
<div class="container">
    <div class="row d-flex">
        <?php if(isset($newCoffees) && !empty($newCoffees)): ?>
            <?php foreach($newCoffees as $coffee): ?>
                <div class="col-md-4 d-flex ftco-animate">
                    <div class="blog-entry align-self-stretch">
                    <a href="/coffee-detail/<?php echo $coffee['slug']; ?>" class="block-20" style="background-image: url('templates/coffeever/images/image_2.jpg');"></a>
                    <div class="text py-4 d-block">
                        <div class="meta">
                        <div><a href="#" class="meta-chat"><span class="icon-chat"></span> 0</a></div>
                    </div>
                    <h3 class="heading mt-2"><a href="/coffee-detail/<?php echo $coffee['slug']; ?>"><?php echo $coffee['name']; ?></a></h3>
                    <p>This coffee bean is <?php echo $coffee['roast']; ?> roasted and grown in the <?php echo $coffee['region']; ?> region.</p>
                    </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
  </div>
  <div id="site-pagination">
                            <?php include(ROOT_DIR."/templates/coffeever/parts/part-pagination.php"); ?>
                        </div>
  <div class="row mt-5">
    <div class="col text-center">
      <div class="block-27">
        <ul>
          <li><a href="#">&lt;</a></li>
          <li class="active"><span>1</span></li>
          <li><a href="#">2</a></li>
          <li><a href="#">3</a></li>
          <li><a href="#">4</a></li>
          <li><a href="#">5</a></li>
          <li><a href="#">&gt;</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>
</section>
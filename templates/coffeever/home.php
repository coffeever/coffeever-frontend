<?php
defined('INDEX') or die();
$result = makeRequest("getAllCoffees", [], 'GET');
$first6Coffee = array_slice($result, 0, 6);
?>
<section class="home-slider owl-carousel">
      <div class="slider-item" style="background-image: url(templates/coffeever/images/bg_1.jpg);">
      	<div class="overlay"></div>
        <div class="container">
          <div class="row slider-text justify-content-center align-items-center" data-scrollax-parent="true">

            <div class="col-md-8 col-sm-12 text-center ftco-animate">
            	<span class="subheading">Welcome</span>
              <h1 class="mb-4">The Coffee That You Deserve</h1>
              <p><a href="/search" class="btn btn-primary p-3 px-xl-4 py-xl-3">Search Now</a> </p>
            </div>

          </div>
        </div>
      </div>

      <div class="slider-item" style="background-image: url(templates/coffeever/images/bg_2.jpg);">
      	<div class="overlay"></div>
        <div class="container">
          <div class="row slider-text justify-content-center align-items-center" data-scrollax-parent="true">

            <div class="col-md-8 col-sm-12 text-center ftco-animate">
            	<span class="subheading">Welcome</span>
              <h1 class="mb-4">Here With Us Find Your Coffee Style</h1>
              <p><a href="/search" class="btn btn-primary p-3 px-xl-4 py-xl-3">Search Now</a> </p>
            </div>

          </div>
        </div>
      </div>

      <div class="slider-item" style="background-image: url(templates/coffeever/images/bg_3.jpg);">
      	<div class="overlay"></div>
        <div class="container">
          <div class="row slider-text justify-content-center align-items-center" data-scrollax-parent="true">

            <div class="col-md-8 col-sm-12 text-center ftco-animate">
            	<span class="subheading">Welcome</span>
              <h1 class="mb-4">Life Is Too Short To Drink Bad Coffee</h1>
              <p><a href="/search" class="btn btn-primary p-3 px-xl-4 py-xl-3">Search Now</a> </p>
            </div>

          </div>
        </div>
      </div>
    </section>

    <section class="ftco-about d-md-flex">
    	<div class="one-half img" style="background-image: url(templates/coffeever/images/about.jpg);"></div>
    	<div class="one-half ftco-animate">
    		<div class="overlap">
	        <div class="heading-section ftco-animate ">
            <span class="subheading">How To</span>
	        	<h2 class="mb-4">Choose Your Coffee</h2>
			</div>
	        <div>
	  				<p>
						The popularity of coffee has exploded in recent years, with the humble beverage going from something to wake you up in the morning, to a gourmet experience.						
						With artisanal coffee stores popping up all over the place, and many cities hosting coffee tastings and festivals, it can seem a little daunting to those who are novices in the world of coffee.						
						Here are a few simple tips to help get you brewing your own at home, and to start you on your journey to becoming a coffee connoisseur.</p>
  			</div>
    	</div>
    </section>

    <section class="ftco-section ftco-services">
    	<div class="container">
    		<div class="row">
          <div class="col-md-4 ftco-animate">
            <div class="media d-block text-center block-6 services">
              <div class="icon d-flex justify-content-center align-items-center mb-5">
              	<span> <img src="templates/coffeever/images/icons/icon1.png"> </span>
              </div>
              <div class="media-body">
                <h3 class="heading">Easy to Find</h3>
                <p>Find the best matching coffee with an advanced filter among hundreds of coffee types according to your taste</p>
              </div>
            </div>      
          </div>
          <div class="col-md-4 ftco-animate">
            <div class="media d-block text-center block-6 services">
              <div class="icon d-flex justify-content-center align-items-center mb-5">
              	<span><img src="templates/coffeever/images/icons/icon2.png"></span>
              </div>
              <div class="media-body">
                <h3 class="heading">Add to your Favourites</h3>
                <p>Add the results to your favourites, Easily share and recommend to your beloved ones</p>
              </div>
            </div>      
          </div>
          <div class="col-md-4 ftco-animate">
            <div class="media d-block text-center block-6 services">
              <div class="icon d-flex justify-content-center align-items-center mb-5">
              	<span class="flaticon-coffee-bean"></span></div>
              <div class="media-body">
                <h3 class="heading">Learn About Coffee Culture</h3>
                <p>Get informed about many coffee types around the world and find everything about the coffee culture.</p>
              </div>
            </div>    
          </div>
        </div>
    	</div>
    </section>

    <section class="ftco-section">
    	<div class="container">
    		<div class="row align-items-center">
    			<div class="col-md-6 pr-md-5">
    				<div class="heading-section text-md-right ftco-animate">
	          	<span class="subheading">Discover</span>
	            <h2 class="mb-4">The Coffee Culture</h2>
	            <p class="mb-4">
	            	From the button below, you can learn everything about the coffee and coffee cultures around the world 
	            </p>
	            <p><a href="coffees.html" class="btn btn-primary btn-outline-primary px-4 py-3">View</a></p>
	          </div>
    			</div>
    			<div class="col-md-6">
    				<div class="row">
    					<div class="col-md-6">
    						<div class="menu-entry">
		    					<a href="#" class="img" style="background-image: url(templates/coffeever/images/menu-1.jpg);"></a>
		    				</div>
    					</div>
    					<div class="col-md-6">
    						<div class="menu-entry mt-lg-4">
		    					<a href="#" class="img" style="background-image: url(templates/coffeever/images/menu-2.jpg);"></a>
		    				</div>
    					</div>
    					<div class="col-md-6">
    						<div class="menu-entry">
		    					<a href="#" class="img" style="background-image: url(templates/coffeever/images/menu-3.jpg);"></a>
		    				</div>
    					</div>
    					<div class="col-md-6">
    						<div class="menu-entry mt-lg-4">
		    					<a href="#" class="img" style="background-image: url(templates/coffeever/images/menu-4.jpg);"></a>
		    				</div>
    					</div>
    				</div>
    			</div>
    		</div>
    	</div>
    </section>

    <section class="ftco-counter ftco-bg-dark img" id="section-counter" style="background-image: url(templates/coffeever/images/bg_2.jpg);" data-stellar-background-ratio="0.5">
			<div class="overlay"></div>
      <div class="container">
        <div class="row justify-content-center">
        	<div class="col-md-10">
        		<div class="row">
		          <div class="col-md-6 col-lg-3 d-flex justify-content-center counter-wrap ftco-animate">
		            <div class="block-18 text-center">
		              <div class="text">
		              	<div class="icon"><span class="flaticon-coffee-cup"></span></div>
		              	<strong class="number" data-number="4888">0</strong>
		              	<span>Types of Coffee</span>
		              </div>
		            </div>
		          </div>
		          <div class="col-md-6 col-lg-3 d-flex justify-content-center counter-wrap ftco-animate">
		            <div class="block-18 text-center">
		              <div class="text">
		              	<div class="icon"><span class="flaticon-coffee-cup"></span></div>
		              	<strong class="number" data-number="153">0</strong>
		              	<span>Daily Visitors</span>
		              </div>
		            </div>
		          </div>
		          <div class="col-md-6 col-lg-3 d-flex justify-content-center counter-wrap ftco-animate">
		            <div class="block-18 text-center">
		              <div class="text">
		              	<div class="icon"><span class="flaticon-coffee-cup"></span></div>
		              	<strong class="number" data-number="1246">0</strong>
		              	<span>Registered Members</span>
		              </div>
		            </div>
		          </div>
		          <div class="col-md-6 col-lg-3 d-flex justify-content-center counter-wrap ftco-animate">
		            <div class="block-18 text-center">
		              <div class="text">
		              	<div class="icon"><span class="flaticon-coffee-cup"></span></div>
		              	<strong class="number" data-number="45">0</strong>
		              	<span>Days Active</span>
		              </div>
		            </div>
		          </div>
		        </div>
		      </div>
        </div>
      </div>
    </section>

    <section class="ftco-section">
    	<div class="container">
    		<div class="row justify-content-center mb-5 pb-3">
          <div class="col-md-7 heading-section ftco-animate text-center">
          	<span class="subheading">Discover</span><br>
            <h2 class="mb-4">This Week's Top Recommendations</h2>
            <p>These are the coffees that we recommended the most for this week</p>
          </div>
        </div>
        <div class="row">
        	<div class="col-md-3">
        		<div class="menu-entry">
    					<a href="#" class="img" style="background-image: url(templates/coffeever/images/menu-1.jpg);"></a>
    					<div class="text text-center pt-4">
    						<h3><a href="#">Cortado</a></h3>
    						<p>Cortado is a Spanish beverage made by pouring a small amount of espresso in a small glass cup</p>
    					</div>
    				</div>
        	</div>
        	<div class="col-md-3">
        		<div class="menu-entry">
    					<a href="#" class="img" style="background-image: url(templates/coffeever/images/menu-2.jpg);"></a>
    					<div class="text text-center pt-4">
    						<h3><a href="#">Ristretto</a></h3>
    						<p>Ristretto, which means restricted in Italian, is half of a single shot of espresso</p>
    					</div>
    				</div>
        	</div>
        	<div class="col-md-3">
        		<div class="menu-entry">
    					<a href="#" class="img" style="background-image: url(templates/coffeever/images/menu-3.jpg);"></a>
    					<div class="text text-center pt-4">
    						<h3><a href="#">Cold-Brewed Iced</a></h3>
    						<p>Created by steeping ground coffee in room temperature water for 12 hours and then filtering out the grounds for a clean coffee</p>
    					</div>
    				</div>
        	</div>
        	<div class="col-md-3">
        		<div class="menu-entry">
    					<a href="#" class="img" style="background-image: url(templates/coffeever/images/menu-4.jpg);"></a>
    					<div class="text text-center pt-4">
    						<h3><a href="#">Coffee Capuccino</a></h3>
    						<p>An espresso-based coffee drink that originated in Italy, and is traditionally prepared with steamed milk foam</p>
    					</div>
    				</div>
        	</div>
        </div>
    	</div>
    </section>
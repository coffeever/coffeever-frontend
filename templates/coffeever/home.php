<?php
defined('INDEX') or die();
$result = makeRequest("getAllCoffees", [], 'GET');
$first6Coffee = array_slice($result, 0, 6);
?>

<!-- ==== HEADERWRAP ==== -->
<div id="home-section">
<div id="headerwrap" name="home">
  <header class="clearfix tb"> 
 <div class="tb-cell text-center">
 <i class="fa fa-heart-o icon"></i>
    <h1>Coffeever</h1>
    <p>New experiences for every coup!</p>
    <a href="#" data-id='#portfolio' class="smoothScroll btn btn-lg">Today's Special</a> 
	</div>
	</header>
</div>

</div>
<div class="div-pattern2"></div>
<!-- /headerwrap --> 

<!-- ==== SERVICES ==== -->
<div id="services" name="services">
  <div class="container">
    <div class="row">
      <h2 class="centered">What are we promising?</h2>
      <hr>
      <div class="col-lg-8 col-lg-offset-2">
        <p class="large">Find the one that suits your taste among hundreds of coffee beans that are consumed all over the world and loved by everyone!</p>
      </div>
      <div class="col-lg-4 callout"> <i class="fa fa-search fa-3x"></i>
        <h3>Search</h3>
        <p>Easily find the coffee you want with an advanced filter among hundreds of coffee types.</p>
      </div>
      <div class="col-lg-4 callout"> <i class="fa fa-heart fa-3x"></i>
        <h3>Add Favourite</h3>
        <p>Add your favorite coffees you want to recommend to others.</p>
      </div>
      <div class="col-lg-4 callout"> <i class="fa fa-thumbs-up fa-3x"></i>
        <h3>Get Recommend</h3>
        <p>Let us recommend you the best coffees for your taste.</p>
      </div>
    </div>
    <!-- row --> 
  </div>
</div>
<!-- container --> 
<section class="hero-section section">  
        <div class="container">
            <div class="highlight tb">
              <?php if(isLoggedIn()): ?>
                <div class="tb-cell">
                    <p>Hello, <?php echo $_SESSION['subscriberObj']['name'] ?>. You can choose your favorite coffees and receive new coffee recommendations.</p>
                </div>
                <div class="links tb-cell">
                    <div class="reservation-link">
                      <a class="btn reservation-btn" href='/logout'>Log Out</a>
                    </div> 
                </div>
              <?php else: ?>
                <div class="tb-cell">
                    <p>You can subscribe to our site to choose your favorite coffees and receive new coffee recommendations.</p>
                </div>
                <div class="links tb-cell">
                    <div class="reservation-link">
                      <a class="btn reservation-btn" href='<?php echo $client->createAuthUrl() ?>'>Google Login</a>
                    </div> 
                </div>
              <?php endif; ?>
            </div>
        </div>
		
    </section>
	<div class="div-pattern"></div>
<!-- ==== ABOUT ==== -->
<div id="about" name="about">
  <div class="container">
    <div class="row white">
      <h2 class="centered">Coffeever</h2>
      <hr>
      <div class="col-md-6"> <img class="img-responsive" src="templates/coffeever/assets/img/about/about1.jpg" align=""> </div>
      <div class="col-md-6">
        <h3>Who we are</h3>
		<p>We are a group of students taking Software Engineering course from Eskişehir Technical University.</p>
		<p>We wanted to make a project about the coffee we consume frequently in daily life and this thought directed us to the coffeever project.</p>
      </div>
    </div>
    <!-- row --> 
  </div>
</div>
<!-- container --> 
<!-- ==== PORTFOLIO ==== -->
<div id="portfolio" name="portfolio">
  <div class="container">
    <div class="row">
      <h2 class="centered">Coffees we have selected for you</h2>
      <hr>
    </div>
    <!-- /row -->
    <div class="container">
      <div class="row">
        <?php if(isset($first6Coffee) && !empty($first6Coffee)): ?>
          <?php foreach($first6Coffee as $coffee): ?>
            <div class="col-md-4 ">
              <div class="grid overlay">
                <figure> 
                  <img class="img-responsive" src="templates/coffeever/assets/img/portfolio/coffee-default.jpg" alt="">
                  <div class="bottom-left"><h5><?php echo $coffee['slug']; ?></h5></div>
                  <figcaption>
                    <h5><?php echo $coffee['slug']; ?></h5>
                    <p><strong>Aroma: </strong><?php echo $coffee['aroma']; ?></p>
                    <p><strong>Acidity: </strong><?php echo $coffee['acidity']; ?></p>
                    <p><strong>Body: </strong><?php echo $coffee['body']; ?></p>
                    <p><strong>Flavor: </strong><?php echo $coffee['flavor']; ?></p>
                    <i class="heart-icon fa fa-heart"></i>
                    <a data-toggle="modal" href="#<?php echo $coffee['slug']; ?>" class="btn btn-default">Quick View</a> </figcaption>
                  <!-- /figcaption --> 
                </figure>
                <!-- /figure --> 
              </div>
              <!-- /grid-overlay --> 
            </div> 
        
            <div class="modal fade" id="<?php echo $coffee['slug']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><?php echo $coffee['slug']; ?></h4>
                  </div>
                  <div class="modal-body">
                    <div class='row'>
                      <div class='col-md-6'>
                        <p><img class="img-responsive" src="templates/coffeever/assets/img/portfolio/coffee-default.jpg" alt=""></p>
                      </div>
                      <div class='col-md-6'>
                      <table class="table table-hover">
                        <tbody>
                          <tr>
                            <th scope="row">Aroma:</th>
                            <td><?php echo $coffee['aroma']; ?></td>
                          </tr>
                          <tr>
                            <th scope="row">Acidity:</th>
                            <td><?php echo $coffee['acidity']; ?></td>
                          </tr>
                          <tr>
                            <th scope="row">Body:</th>
                            <td><?php echo $coffee['body']; ?></td>
                          </tr>
                          <tr>
                            <th scope="row">Flavor:</th>
                            <td><?php echo $coffee['flavor']; ?></td>
                          </tr>
                        </tbody>
                      </table>
                      </div>
                      <div class='col-md-12'>
                        <p>This coffee bean is <?php echo $coffee['roast']; ?> roasted and grown in the <?php echo $coffee['region']; ?> region.</p> 
                      </div>
                    </div>
                  </div> 
                </div>
                <!-- /.modal-content --> 
              </div>
              <!-- /.modal-dialog --> 
            </div>
            <!-- /.modal --> 
        
          <?php endforeach; ?>
        <?php endif; ?>
        <!-- /col --> 
      </div>
      <!-- /row --> 
    </div>
    <!-- /row --> 
  </div>
</div>
<!-- /container --> 

<!-- ==== TEAM MEMBERS ==== -->
<div id="team" name="team">
  <div class="container">
    <div class="row centered">
      <h2 class="centered">Our Team</h2>
      <hr>
	   <div class="col-lg-8 col-lg-offset-2 centered">
		<br/>
      </div>
      <div class="col-lg-4 centered"> <img class="img img-circle" src="templates/coffeever/assets/img/team/blank-profile.png" height="120px" width="120px" alt="">
        <h4><strong>Muhammed Ensarullah TEMEL</strong></h4>
        <p>Frontend Developer</p>
        <a href="#"><i class="fa fa-twitter"></i></a> <a href="#"><i class="fa fa-facebook"></i></a> <a href="#"><i class="fa fa-linkedin"></i></a> </div>
      <div class="col-lg-4 centered"> <img class="img img-circle" src="templates/coffeever/assets/img/team/blank-profile.png" height="120px" width="120px" alt="">
        <h4><b>Yusuf Furkan AKÇAL</b></h4>
        <p>Frontend Developer</p>
        <a href="#"><i class="fa fa-twitter"></i></a> <a href="#"><i class="fa fa-facebook"></i></a> <a href="#"><i class="fa fa-linkedin"></i></a> </div>
      <div class="col-lg-4 centered"> <img class="img img-circle" src="templates/coffeever/assets/img/team/blank-profile.png" height="120px" width="120px" alt="">
        <h4><b>Mehmet Çağrı Kul</b></h4>
        <p>Designer</p>
		<a href="#"><i class="fa fa-twitter"></i></a> <a href="#"><i class="fa fa-facebook"></i></a> <a href="#"><i class="fa fa-linkedin"></i></a> </div>
	</div>
	<div class="row centered">
	   <div class="col-lg-8 col-lg-offset-2 centered">
		<br/>
      </div>
      <div class="col-lg-4 centered"> <img class="img img-circle" src="templates/coffeever/assets/img/team/blank-profile.png" height="120px" width="120px" alt="">
        <h4><strong>Cihan İncirligöz</strong></h4>
        <p>Backend Developer</p>
        <a href="#"><i class="fa fa-twitter"></i></a> <a href="#"><i class="fa fa-facebook"></i></a> <a href="#"><i class="fa fa-linkedin"></i></a> </div>
      <div class="col-lg-4 centered"> <img class="img img-circle" src="templates/coffeever/assets/img/team/blank-profile.png" height="120px" width="120px" alt="">
        <h4><b>Muhammed Ali Bulut</b></h4>
        <p>Backend Developer</p>
        <a href="#"><i class="fa fa-twitter"></i></a> <a href="#"><i class="fa fa-facebook"></i></a> <a href="#"><i class="fa fa-linkedin"></i></a> </div>
      <div class="col-lg-4 centered"> <img class="img img-circle" src="templates/coffeever/assets/img/team/blank-profile.png" height="120px" width="120px" alt="">
        <h4><b>Mouchammet Tsakir Chasan</b></h4>
        <p>Backend Developer</p>
		<a href="#"><i class="fa fa-twitter"></i></a> <a href="#"><i class="fa fa-facebook"></i></a> <a href="#"><i class="fa fa-linkedin"></i></a> </div>
    </div>
  </div>
  <!-- row --> 
</div>
<!-- container --> 

<!-- ==== CONTACT ==== -->
<div id="contact" name="contact">
  <div class="container">
    <div class="row">
      <h2 class="centered">Get In Touch</h2>
      <hr>
    
    </div>
    <div class="row">
      <div class="col-md-12">
	  <strong>Please give us your feedback!</strong>
        <form id="contact" method="post" class="form" role="form">
          <div class="row">
            <div class="col-md-12 form-group">
              <input class="form-control" id="name" name="name" placeholder="Name" type="text" required />
            </div>
            <div class="col-md-12 form-group">
              <input class="form-control" id="email" name="email" placeholder="Email" type="email" required />
            </div>
			 <div class="col-md-12 form-group">
              <textarea class="form-control" id="message" name="message" placeholder="Message" rows="5"></textarea>             
              <button class="btn btn-lg pull-left" type="submit">Send Message</button>
            </div>
          </div>
           
        </form>
        <!-- form --> 
      </div>
    </div>
    <!-- row --> 
    
  </div>
</div>
<!-- container -->
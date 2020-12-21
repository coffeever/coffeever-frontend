<?php
defined('INDEX') or die();
debugPrint($pageData);
?>
<style type="text/css" id="my style for this page">
    .img-fluid {
    max-width: 75% !important;
    height: auto;
    }

    .phead{
        font-size:18px;
        color:#c49b63;
        font-weight: 600;
    }
    li{
        list-style: none;
    }
    .pname{
        font-size:16px;
        color:#c49b63;
        font-weight: 450;
    }
    .text-left-right {
    text-align: right;
    position: relative;
    }   
    .left-text {
    left: 0;
    position: absolute;
    }
    .decaf {
    font-size: 16px;
    color:#a0c463;
    /*text-decoration: underline; */
    font-style: italic;
    text-shadow: 2px 2px 12px  #fff;
    display: 
    }
    .rate{
        text-align: center;
        font-size:16px;
        color:#c49b63;
        font-weight: 450;
    }
    #rating{
         color: #c49b63;
    }
    .ftco-menu{
        padding-top: 0em !important;
    }
    </style>

   

<script type="text/javascript">
   window.onload = function showd(){
        var x = document.getElementById("showdecaf");
        
            x.style.display="inline-block";
        
 }
</script>
<section class="home-slider owl-carousel">
<div class="slider-item" style="background-image: url(templates/coffeever/images/bg_3.jpg);" data-stellar-background-ratio="0.5">
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
              <a href="images/menu-2.jpg" class="image-popup"><img src="templates/coffeever/images/menu-2.jpg" class="img-fluid" alt="Colorlib Template"></a>
          </div>


          <div class="col-lg-6 mb-5 ftco-animate fadeInUp ftco-animated">
              <span>
                  <h3 class="text-left-right">
                  <span class="left-text">Creamy Latte Coffee</span>
                  <span class="decaf" id="showdecaf"> Decaffeinated</span> 
                  </h3>

              <p class="Properties"><span class="phead">Properties</span> </p>
              <div class="container">
                  <div class="row">
              <div class="col-sm">
              <ul>
                  <li><span class="pname">Aroma: </span> <span class="prop" id="aromaprop">8</span> </li>
                  <li><span class="pname">Acidity: </span> <span class="prop" id="acidprop"> 7</span> </li>
                  <li><span class="pname">Body: </span> <span class="prop" id="bodyprop"> 9</span> </li>
                  <li><span class="pname">Flavor: </span> <span class="prop" id="flavorprop"> 6</span> </li>
                  <li><span class="pname">Roast: </span> <span class="prop" id="roastprop"> Medium</span> </li>
                  <li><span class="pname">Region: </span> <span class="prop" id="regionprop"> Region</span> </li>
              </ul>   
              </div> 

               <div class="col-sm">
                  <span class="rate" style=" margin-left: 10%;">Rating</span><br><br>
                      <div class="c100 p73 orange">
                          <span id="rating">73%</span>
                          <div class="slice">
                              <div class="bar"></div>
                              <div class="fill"></div>
                          </div>
                      </div>
               </div> 
               </div>  
           </div>
              <p>A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth.</p>
              
          </div>
      </div>
  </div>

  <div class="container ftco-menu mb-5 pb-5">
      
      <div class="row d-md-flex">
          <div class="col-lg-8 ftco-animate  fadeInUp ftco-animated">
              <div class="row">
            <div class="col-md-12 nav-link-wrap mb-5">
              <div class="nav ftco-animate nav-pills  fadeInUp ftco-animated" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link active" id="v-pills-1-tab" data-toggle="pill" href="#v-pills-1" role="tab" aria-controls="v-pills-1" aria-selected="true">Location</a>

                <a class="nav-link" id="v-pills-2-tab" data-toggle="pill" href="#v-pills-2" role="tab" aria-controls="v-pills-2" aria-selected="false">Blind Assessment</a>

                <a class="nav-link" id="v-pills-3-tab" data-toggle="pill" href="#v-pills-3" role="tab" aria-controls="v-pills-3" aria-selected="false">Notes</a>
                <a class="nav-link" id="v-pills-4-tab" data-toggle="pill" href="#v-pills-4" role="tab" aria-controls="v-pills-4" aria-selected="false">Who Should Drink</a>
              </div>
            </div>
            <div class="col-md-12 d-flex align-items-center">
              
              <div class="tab-content ftco-animate fadeInUp ftco-animated" id="v-pills-tabContent">

                <div class="tab-pane fade show active" id="v-pills-1" role="tabpanel" aria-labelledby="v-pills-1-tab">
                  <div class="row">
                      <div class=" text-center">
                          <div class="menu-wrap">
                              <div class="text">
                                  <h3>Location</h3>
                                  <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia.</p>
                                 
                              </div>
                          </div>
                      </div>
                  </div>
                </div>

                <div class="tab-pane fade" id="v-pills-2" role="tabpanel" aria-labelledby="v-pills-2-tab">
                  <div class="row">
                      <div class=" text-center">
                          <div class="menu-wrap">
                              <div class="text">
                                  <h3>Blind Assessment</h3>
                                  <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia.</p>
                                 
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
                                  <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia.</p>
                                 
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
                                  <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia.</p>
                                 
                              </div>
                          </div>
                      </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      <div class="col-lg-4">
          <div class="sidebar-box ftco-animate fadeInUp ftco-animated">
              <h3>Keywords</h3>
                  <div class="tagcloud">
                      <a href="#" class="tag-cloud-link">black</a>
                      <a href="#" class="tag-cloud-link">milk</a>
                      <a href="#" class="tag-cloud-link">decaf</a>
                      <a href="#" class="tag-cloud-link">medium</a>
                      <a href="#" class="tag-cloud-link">tasty</a>
                      <a href="#" class="tag-cloud-link">sugar</a>
                      <a href="#" class="tag-cloud-link">latte</a>
                      <a href="#" class="tag-cloud-link">creamy</a>
                  </div>
          </div>
      </div>
      </div>
  </div>
</section>
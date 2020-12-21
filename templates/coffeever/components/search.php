<?php
defined('INDEX') or die();
?>
<section class="home-slider owl-carousel">

<div class="slider-item" style="background-image: url(templates/coffeever/images/bg_3.jpg);" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
  <div class="container">
    <div class="row slider-text justify-content-center align-items-center">

      <div class="col-md-7 col-sm-12 text-center ftco-animate">
          <h1 class="mb-3 mt-5 bread">Search</h1>
       
      </div>

    </div>
  </div>
</div>
</section>

<section class="ftco-section">
<div class="container">

<style> 
input[type=text] {
width: 130px;
box-sizing: border-box;
border: 3px solid #c49b63;
border-radius: 5px;
font-size: 16px;
background-color: white;
background-image: url('templates/coffeever/images/icons/searchicon.png');  
background-repeat: no-repeat;
background-size: 10%;
padding: 12px 20px 12px 60px;
-webkit-transition: width 0.4s ease-in-out;
transition: width 0.4s ease-in-out;
width: 50%;
height: 50%;
}
.slider {
-webkit-appearance: none;
width: 25%;
height: 15px;
border-radius: 5px;   
background: #d3d3d3;
outline: none;
opacity: 0.7;
-webkit-transition: .2s;
transition: opacity .2s;
}

.slider::-webkit-slider-thumb {
-webkit-appearance: none;
appearance: none;
width: 25px;
height: 25px;
border-radius: 50%; 
background: #c49b63;
cursor: pointer;
}

#speed_display {
text-align: center;
margin: auto;
font-size: 30px;
}

.slider::-moz-range-thumb {
width: 25px;
height: 25px;
border-radius: 50%;
background: #c49b63;
cursor: pointer;
}

.speed_display{
text-align: center;
}

button {
text-align: center;
background-color: #c49b63;
border:3px solid #c49b63;
color: black;
padding: 15px 32px;
text-align: center;   
text-decoration: none;
display: inline-block;
width: 25%;
font-size: 16px;
}

button:hover{ 
background-color: transparent;
color: white;
cursor: pointer;
}

.quick_select {
display: grid; 
grid-template-columns: 1fr 1fr 1fr;
justify-items: center;
}
.quick_select > div {
padding: 3px;
}

.selected {
background-color: black; 
color: white; 
}

#speed-input {
width: 60px;
}

.custom {
margin-top: 10px;
display: grid; 
grid-template-columns: 1fr 1fr auto 1fr 1fr;
grid-column-gap: 3px;
grid-template-rows: 20px;
}
.input1{
margin-bottom:4%;
font-size:18px;
}
#decaf{
margin-left: 3%;
position:relative;
top: 0;
left: 0;
height: 20px;
width: 20px;
background-color: #3c4a2a;
}

/* The container */
.checkk {

position: relative;
padding-left: 35px;
margin-bottom: 12px;
cursor: pointer;
font-size: 18px;
}

/* Hide the browser's default checkbox */
.checkk input {
position: absolute;
opacity: 0;
cursor: pointer;
height: 0;
width: 0;
}

/* Create a custom checkbox */
.checkmark {
position: absolute;
top: 0;
left: 0;
height: 20px;
width: 20px;
background-color: #eee;
}

/* On mouse-over, add a grey background color */
.checkk:hover input ~ .checkmark {
background-color: #c49b63;
}

/* When the checkbox is checked, add a blue background */
.checkk input:checked ~ .checkmark {
background-color: #c49b63;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
content: "";
position: absolute;
display: none;
}

/* Show the checkmark when checked */
.checkk input:checked ~ .checkmark:after {
display: block;
}

/* Style the checkmark/indicator */
.checkk .checkmark:after {
left: 7px;
top: 1px;
width: 7.5px;
height: 15px;
border: solid white;
border-width: 0 3px 3px 0;
-webkit-transform: rotate(45deg);
-ms-transform: rotate(45deg);
transform: rotate(45deg);
}
#roastinput{
margin-bottom:25%;
}
</style>

<div class="cart-detail ftco-bg-dark p-3 p-md-4">
<center>
<div class="input1">
<div class="input1">
<div >

<form action="/results" method="get">

Type what you want
</div>
<div>
<input  type="text" name="search" placeholder="Search..">
</div>
</div>

<div class="input1">
<div >
Aroma
</div>
<div>
<input type="range" name="aroma" min="1" max="10" value="0" class="slider" id="speed_slider">
</div> 
</div>  

<div class="input1">
<div >
Acidity
</div>
<div>
<input type="range" name="acidity" min="1" max="10" value="0" class="slider" id="speed_slider">
</div> 
</div> 

<div class="input1">
<div>
Body
</div>
<div>
<input type="range" name="body" min="1" max="10" value="0" class="slider" id="speed_slider">
</div> 
</div> 

<div class="input1"> 
<div>
Flavor
</div>
<div>
<input type="range" name="flavor" min="1" max="10" value="0" class="slider" id="speed_slider">
</div> 
</div>  
<div>
<div>
<!--	<label for="decaf"> Decaf</label>  <input type="checkbox" id="decaf" name="vehicle1" value="Bike"> -->
<label class="checkk">Decaffeinated
<input name="decaf" type="checkbox">
<span class="checkmark"></span>
</label>
</div>
</div>   
<!--<div style="padding-left: 200px;">
<label for="cars">Acidity</label>

  <select name="cars" id="cars">
      <option value="1">1</option>
      <option value="2">2</option>
      <option value="3">3</option>
      <option value="4">4</option>            
      <option value="5">5</option>
      <option value="6">6</option>
      <option value="7">7</option>
      <option value="8">8</option>
      <option value="9">9</option>
      <option value="10">10</option>
  </select>
</div>

-->
<button type="submit">Search</button>
</form>

</center>
</div>
</div>
</section>
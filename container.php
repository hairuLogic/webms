<?php include_once("assets/php/sschecker.php"); ?>
<!DOCTYPE html>
<html lang="en">
  <head>

  	<link rel="stylesheet" href="assets/plugins/form-validator/theme-default.css">
	<link rel="stylesheet" href="assets/plugins/font-awesome-4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/plugins/ionicons-2.0.1/css/ionicons.min.css">
	<link rel="stylesheet" href="assets/plugins/AccordionMenu/dist/metisMenu.min.css"> 
	<link rel="stylesheet" href="assets/plugins/bootstrap-3.3.5-dist/css/bootstrap.min.css"> 
	<link rel="stylesheet" href="assets/plugins/jasny-bootstrap/css/jasny-bootstrap.min.css"> 
    <link rel="stylesheet" href="assets/plugins/css/trirand/ui.jqgrid-bootstrap.css">
	<link rel="stylesheet" href="assets/plugins/jquery-ui-1.11.4.custom/jquery-ui.css">

    <style>
		.navbar{
			height:10% !important;
			background: linear-gradient(to bottom, rgba(35,83,138,1) 0%,rgba(167,207,223,1) 100%);
			border-bottom: none;
		}
		.navbar a{
			color:white;
		}
		.navbar a:hover{
			background: linear-gradient(to bottom, rgba(35,83,138,1) 0%,rgba(167,207,223,1) 100%);
		}
		
		.navmenu {
			width:20%;
			padding-top:50px;
			border-right: none;
		}
		.navmenu ul {
			padding: 0;
			margin: 0;
			list-style: none;
		}
		.navmenu a, .navmenu a:hover, .navmenu a:focus, .navmenu a:active {
			outline: none;
		}
		.navmenu ul li, .navmenu ul a {
			background: -webkit-linear-gradient(45deg, rgba(252,255,244,1) 0%,rgba(223,229,215,1) 40%,rgba(179,190,173,1) 100%);
			display: block;
		}
		.navmenu ul a {
			border: white solid 1px;
		}
		.navmenu ul a {
			padding: 10px 20px;
			color: black;
		}
		.navmenu ul a:hover, .navmenu ul a:focus, .navmenu ul a:active {
			text-decoration: none;
		}
		.navmenu ul ul a:hover, .navmenu ul ul a:focus, .navmenu ul ul a:active {
			text-decoration: none;
		}
		.navmenu ul ul a {
			text-shadow: none;
			padding: 10px 30px;
		}
		.navmenu-item {
			padding-left: 5px;
		}
		.navmenu-item-icon {
			padding-right: 5px;
		}
		#rtlh3 small {
			transform: rotateY(180deg);
			display: inline-block;
		}
		.navbar-static-top,.navmenu-fixed-left{
			z-index: 100 !important;
		}
		.pointer {
			cursor: pointer;
		}
		::-webkit-scrollbar{
		  width: 6px;  /* for vertical scrollbars */
		  height: 6px; /* for horizontal scrollbars */
		}
		::-webkit-scrollbar-track{
		  background: rgba(0, 0, 0, 0.1);
		}
		::-webkit-scrollbar-thumb{
		  background: rgba(0, 0, 0, 0.5);
		}
		iframe{
			width: 100% !important;
		}
		.announcement{
			width:79%;
			color:rgba(0, 0, 0, 0.3);
			min-height:400px;
			position:absolute;
			right:0;
			margin-right:0.5%;
		}
		.announcement h2{
			color:rgba(0, 0, 0, 0.65);
		}
		.carousel {
		  height: 300px;
		  margin-bottom: 60px;
		  border-radius:5px;
		}
	/* Since positioning the image, we need to help out the caption */
		.carousel-caption {
		  z-index: 10;
		}

	/* Declare heights because of positioning of img element */
		.carousel .item {
		  height: 300px;
		  background-color: #777;
		}
		.carousel-inner > .item > img {
		  position: absolute;
		  top: 0;
		  left: 0;
		  min-width: 100%;
		  height: 300px;
		}
		.clickable{
			cursor:pointer;
		}

	</style>


    <title>Medicsoft Enterprise Edition</title>
  </head>

  <body>	

	<div id='myNavmenu' class="navmenu navmenu-fixed-left">
		<ul class="metismenu" id="menu">		
		</ul>
	</div>


	<div class="navbar navbar-static-top ">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#" ></span>Medicsoft</a>
		</div>
		<div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav navbar-right">
				<li ><a href="#" class='ion-person'> <?php echo $_SESSION['username'];?></a></li>
				<li ><a href="assets/php/logout.php" class='ion-log-out'> logout</a></li>
			</ul>
		</div>
	</div>
	</div>


	<div class='announcement'>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4>Announcement</h4>
				<ul class="nav nav-pills" role="tablist" style='position:absolute;right:15px;top:15px;'>
					<li role="presentation"><a href="#">Contact Us</a></li>
					<li role="presentation" class="active"><a href="#">Message <span class="badge">42</span></a></li>
				</ul>
			</div>
		  	<div class="panel-body">
			
				<div id="myCarousel" class="carousel slide" data-ride="carousel">
			      <!-- Indicators -->
			      <ol class="carousel-indicators">
			        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
			        <li data-target="#myCarousel" data-slide-to="1"></li>
			        <li data-target="#myCarousel" data-slide-to="2"></li>
			      </ol>
			      <div class="carousel-inner" role="listbox">
			        <div class="item active">
			          <img class="first-slide" src="assets/img/carousel/background1.jpg" alt="First slide">
			          <div class="container">
			            <div class="carousel-caption">
			              <h1>Example headline.</h1>
			              <p>Note: If you're viewing this page via a <code>file://</code> URL, the "next" and "previous" Glyphicon buttons on the left and right might not load/display properly due to web browser security rules.</p>
			              <p><a class="btn btn-lg btn-primary" href="#" role="button">Sign up today</a></p>
			            </div>
			          </div>
			        </div>
			        <div class="item">
			          <img class="second-slide" src="assets/img/carousel/UitmSungaibuluh.jpg" alt="Second slide">
			          <div class="container">
			            <div class="carousel-caption">
			              <h1>Another example headline.</h1>
			              <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
			              <p><a class="btn btn-lg btn-primary" href="#" role="button">Learn more</a></p>
			            </div>
			          </div>
			        </div>
			        <div class="item">
			          <img class="third-slide" src="assets/img/carousel/background-3.jpg" alt="Third slide">
			          <div class="container">
			            <div class="carousel-caption">
			              <h1>One more for good measure.</h1>
			              <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
			              <p><a class="btn btn-lg btn-primary" href="#" role="button">Browse gallery</a></p>
			            </div>
			          </div>
			        </div>
			      </div>
			      <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
			        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
			        <span class="sr-only">Previous</span>
			      </a>
			      <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
			        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
			        <span class="sr-only">Next</span>
			      </a>
		    	</div>
			</div>
		</div>
	</div>
</body>

<!-- JS Global Compulsory -->
<script type="text/ecmascript" src="assets/plugins/jquery.min.js"></script> 
<script type="text/ecmascript" src="assets/plugins/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
<script type="text/ecmascript" src="assets/plugins/jasny-bootstrap/js/jasny-bootstrap.min.js"></script>
<script type="text/ecmascript" src="assets/plugins/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
<script type="text/ecmascript" src="assets/plugins/trirand/i18n/grid.locale-en.js"></script>
<script type="text/ecmascript" src="assets/plugins/trirand/jquery.jqGrid.min.js"></script>
<script type="text/ecmascript" src="assets/plugins/AccordionMenu/dist/metisMenu.min.js"></script>    
<script type="text/ecmascript" src="assets/plugins/form-validator/jquery.form-validator.min.js"></script>
<script type="text/ecmascript" src="assets/plugins/jquery.dialogextend.js"></script>

<!-- JS Implementing Plugins -->
<script src="assets/js/menu.js"></script>

<!-- JS Customization -->

<!-- JS Page Level -->

<script>
	jQuery(document).ready(function() 
    {
        Menu.init_menu();
	});
		
		
</script>


  
</html>
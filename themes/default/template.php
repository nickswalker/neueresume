<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="format-detection" content="telephone=no">
	<title><?php echo $bio['name'];?> | <?php echo $bio['email'];?></title>
	<meta name="description" content="<?php echo $bio['name'];?>'s resume." />
	<link rel="stylesheet"  href="<?php echo $this->getThemeURL();?>resume.css" media="all" />
	<link href='http://fonts.googleapis.com/css?family=Arvo:700|Merriweather:400,400italic,700,700italic|Merriweather+Sans:400italic,400,700,700italic' rel='stylesheet' >
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.css">
	<?php 
	if( file_exists( 'custom-style.css') ){
		echo ('<link rel="stylesheet" href="custom-style.css">');
	}?>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
	<script>
		$(document).ready(function() {
			$('.ion-image').fancybox({
				padding : 0,
				openEffect: 'fade',
				closeEffect: 'fade',
				prevEffect: 'fade',
				nextEffect: 'fade',
				loop: false,
				closeBtn: false,
				helpers : {
	   	title : null
	}
			});
			
		});
	</script>
</head>
<body>
	<div id="container">
		<header itemscope itemtype="http://schema.org/Person">
				<div class="plate">
					<h1 itemprop="name"><?php echo $bio['name'];?></h1>
					<h2 itemprop="jobTitle"><?php echo $bio['job-title'];?></h2>
				</div>
				<div class="right-plate">
					<div class="contact-info">
						<h3 id="print"><button onClick="window.print()">Print</button></h3>
						<h3><a itemprop="url" href="http://<?php echo $bio['site'];?>"><?php echo $bio['site'];?></a></h3>
						<h3><a itemprop="email" href="mailto:<?php echo $bio['email'];?>"><?php echo $bio['email'];?></a></h3>
						<h3 itemprop="telephone"><?php echo $this->issetor($bio['phone-number']);?></h3>
						<h4 itemprop="address" class="address"><?php echo $this->issetor($bio['street-address']);?></h4>
					</div>
					<ul id="social">
						<?php
							foreach ( $social[0] as $name=>$value ){
								if( $value != '' ){
									echo '<li><a href="'.$value.'" class="ion-social-'.$name.'"></a></li>';
								}
							}
?>
					</ul>
				</div>
		</header>

		<?php $this->showSections();?>


		<footer>
			<p><?php echo $bio['name'];?> &mdash; <a href="mailto:<?php echo $bio['email'];?>"><?php echo $bio['email'];?></a><?php if (isset($bio['phone-number']) ){ echo '&mdash;'; echo $bio['phone-number']; }?></p>
		</footer>
	
	</div>
</body>
</html>
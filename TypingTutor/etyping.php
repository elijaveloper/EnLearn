<html !DOCTYPE>
	<head>
		<script	src="https://code.jquery.com/jquery-3.2.1.min.js"
				integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
				crossorigin="anonymous"></script>
		<script src="bin/etyping.js"></script>
		<script src="bin/snow.js"></script>
		<link rel="stylesheet" type="text/css" href="css/etyping.css"/>
		<link rel="stylesheet" type="text/css" href="css/keyboard.css"/>
	</head>
	<body>
	    <div class="bar_stats" id="modal_caps">Press the <span class="btn_letter_wrong">CapsLock</span></div>
		<div id="game_container">
			<div id="stats">
					<div class="bar_stats"> Level <span class="statbar btn_letter_stats" id="level_label"></span> </div>
					<div class="bar_stats"> Time Remaining <span class="statbar btn_letter_stats" id="time"></span> </div>
					<div class="bar_stats"> 
						Score <span class="statbar btn_letter_stats" id="score"></span><span class="statbar btn_letter_stats btn_multiplier" id="multiplier">x0</span>
					</div>
				</div>
			<div id="navbar">
			</div>
			<div id="gamespace">
			</div>
			<div id="container">
				<ul id="keyboard">
					<li class="symbol" id="keyboard_letter_apostrohpe"><span class="off">`</span><span class="on">~</span></li>
					<li class="symbol" id="keyboard_letter_1"><span class="off">1</span><span class="on">!</span></li>
					<li class="symbol" id="keyboard_letter_2"><span class="off">2</span><span class="on">@</span></li>
					<li class="symbol" id="keyboard_letter_3"><span class="off">3</span><span class="on">#</span></li>
					<li class="symbol" id="keyboard_letter_4"><span class="off">4</span><span class="on">$</span></li>
					<li class="symbol" id="keyboard_letter_5"><span class="off">5</span><span class="on">%</span></li>
					<li class="symbol" id="keyboard_letter_6"><span class="off">6</span><span class="on">^</span></li>
					<li class="symbol" id="keyboard_letter_7"><span class="off">7</span><span class="on">&amp;</span></li>
					<li class="symbol" id="keyboard_letter_8"><span class="off">8</span><span class="on">*</span></li>
					<li class="symbol" id="keyboard_letter_9"><span class="off">9</span><span class="on">(</span></li>
					<li class="symbol" id="keyboard_letter_0"><span class="off">0</span><span class="on">)</span></li>
					<li class="symbol" id="keyboard_letter_dash"><span class="off">-</span><span class="on">_</span></li>
					<li class="symbol" id="keyboard_letter_equals"><span class="off">=</span><span class="on">+</span></li>
					<li class="delete lastitem">delete</li>
					<li class="tab">tab</li>
					<li class="letter" id="keyboard_letter_q">q</li>
					<li class="letter" id="keyboard_letter_w">w</li>
					<li class="letter" id="keyboard_letter_e">e</li>
					<li class="letter" id="keyboard_letter_r">r</li>
					<li class="letter" id="keyboard_letter_t">t</li>
					<li class="letter" id="keyboard_letter_y">y</li>
					<li class="letter" id="keyboard_letter_u">u</li>
					<li class="letter" id="keyboard_letter_i">i</li>
					<li class="letter" id="keyboard_letter_o">o</li>
					<li class="letter" id="keyboard_letter_p">p</li>
					<li class="symbol"><span class="off">[</span><span class="on">{</span></li>
					<li class="symbol"><span class="off">]</span><span class="on">}</span></li>
					<li class="symbol lastitem"><span class="off">\</span><span class="on">|</span></li>
					<li class="capslock" id="keyboard_letter_q">caps</li>
					<li class="letter" id="keyboard_letter_a">a</li>
					<li class="letter" id="keyboard_letter_s">s</li>
					<li class="letter" id="keyboard_letter_d">d</li>
					<li class="letter" id="keyboard_letter_f">f</li>
					<li class="letter" id="keyboard_letter_g">g</li>
					<li class="letter" id="keyboard_letter_h">h</li>
					<li class="letter" id="keyboard_letter_j">j</li>
					<li class="letter" id="keyboard_letter_k">k</li>
					<li class="letter" id="keyboard_letter_l">l</li>
					<li class="symbol" id="keyboard_letter_sc"><span class="off">;</span><span class="on">:</span></li>
					<li class="symbol"><span class="off">'</span><span class="on">&quot;</span></li>
					<li class="return lastitem">enter</li>
					<li class="left-shift">shift</li>
					<li class="letter" id="keyboard_letter_z">z</li>
					<li class="letter" id="keyboard_letter_x">x</li>
					<li class="letter" id="keyboard_letter_c">c</li>
					<li class="letter" id="keyboard_letter_v">v</li>
					<li class="letter" id="keyboard_letter_b">b</li>
					<li class="letter" id="keyboard_letter_n">n</li>
					<li class="letter" id="keyboard_letter_m">m</li>
					<li class="symbol" id="keyboard_letter_comma"><span class="off">,</span><span class="on">&lt;</span></li>
					<li class="symbol"><span class="off">.</span><span class="on">&gt;</span></li>
					<li class="symbol"><span class="off">/</span><span class="on">?</span></li>
					<li class="right-shift lastitem">shift</li>
					<li class="space lastitem" id="keyboard_letter__">&nbsp;</li>
				</ul>
			</div>	
		</div>
		<div id="score_container">
			<div class="bar_stats"> Level <span class="statbar btn_letter_stats" id="level_label_score"></span> </div>
			<div id="score_label" class="bar_stats">
				You've got <span id="scorespace_resultStars" class="statbar btn_letter_stats"></span> out of <span id="scorespace_maxStars" class="statbar btn_letter_stats"></span> stars.
			</div>
			<div id="scorespace">
			</div>
			<span id="scorespace_home" class="statbar btn_letter_stats btn_anim">Home</span>
			<div class="bar_stats">
				Score <span id="scorespace_resultScore" class="statbar btn_letter_stats"></span>
			</div>
			<span id="scorespace_nextLesson" class="statbar btn_letter_correct btn_anim">Next</span>
		</div>
		<script type="text/javascript">
			var levelIndex = <?php echo $_GET['level_index'];?>;
			var levelWords = "";
			var numberOfLevels = 0;
		
			$(document).ready(function() {
			    //checkCaps();
			    $("#modal_caps").hide();
				//intialize the letters
				$.getJSON("data/levels.json",function(data){
					getWords(data[levelIndex].content);
					loadWords(0);
					
					$("#time").text("-");
					$("#level_label").text(levelIndex+1);
					$("#level_label_score").text(levelIndex+1);
					$("#score").text(correctKeys);
					countTime(false);
					
					$.each(data,function(i,d){
						numberOfLevels += 1;
					});
				});
			});
			$("#scorespace_home").on("click",function(){
				window.location.href = "etypinghome.php";
			});
			
			$("#scorespace_nextLesson").on("click",function(){
				if(levelIndex == numberOfLevels-1){
					window.location.href = "EnLearn/TypeVsZombies/tvz4.php?level=0";
				}else{
					window.location.href = "etyping.php?level_index=" + (levelIndex + 1);
				}
			});
			
			//$("body").snowfall({flakeCount : 50, maxSpeed : 5, maxSize : 10});
		</script>
	</body>
</html>

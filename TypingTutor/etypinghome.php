<html !DOCTYPE>
	<head>
		<script	src="https://code.jquery.com/jquery-3.2.1.min.js"
				integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
				crossorigin="anonymous"></script>
		<!--<script src="bin/etypinghome.js"></script>-->
		<link rel="stylesheet" type="text/css" href="css/etypinghome.css"/>
		<link rel="stylesheet" type="text/css" href="css/keyboard.css"/>
	</head>
	<body>
		<div id="home_container">
			<div class="bar_stats"> <span class="statbar btn_letter_stats">eTyping</span></div>
			<div id="level_container">
			</div>
		</div>
		<script type="text/javascript">
			$(document).ready(function() {
				$.getJSON("data/level_2.json",function(data){
					loadCards(data);
				});
			});
			
			function loadCards(cards){
			    //simple hack, remove this afterwards
			        var card = cards[0];
			    //simple hack
				//$.each(cards,function(i,card){
					$("#level_container").append("<div class='level_card' id='" + card.level_index + "'>"+
					"<span class='level_card_filler'> activity </span>" +
					"<span class='level_card_level'>" +card.level +"</span>" +
					"<span class='level_card_label'>" +card.label +"</span></div>");
				//});
			}
			
			$(document).on("click",".level_card",function(){
				window.location.href = "etyping.php?level_index=" + $(this).attr("id");
			});
		</script>
	</body>
</html>

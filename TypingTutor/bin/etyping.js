		var eTypeWordBank = "";
		var maxLetterPerPage = 60;
		var pageNumber = 0, currentPage = 0;
		
		var currentLetterIndex = 0;
		var tempKey = "";
		
		var correctKeys = 0;
		var currentScore = 0;
		var finalScore = 0;
		
		var timeLimit = 300;
		var timeElapsed = 0;
		
		var timerObject = false;
		
		var isCapslock = false;
		
		const CAPS_LOCK = 20;
		
		function getWords(words){
			eTypeWordBank = words.split("");
		}
		
		function loadWords(pageNumber){
			currentPage = pageNumber;
			
			//pretty lousy hack
			var publishedCounter = 1;
			var wordCounter = 0;
			var startWord = true;
			
			//version 5: added words.
			$.each(eTypeWordBank,function(i,letter){
				if(i >= pageNumber*maxLetterPerPage){
					if(publishedCounter<=maxLetterPerPage){
						if(startWord){
							$("#gamespace").append("<div class='btn_letter btn_wrapper' id='word_"+ wordCounter +"'>");
							startWord = false;
						}
						if(letter == "_"){
							$("#word_" + wordCounter + ":last-child").data("data",{eof:true});
							$("#gamespace").append("<div class='btn_letter invisible' id='key_" + i + "'>"+ letter +"</div>");
							wordCounter += 1;
							startWord = true;
						}
						
						$("#word_" + wordCounter).append("<div class='btn_letter' id='key_" + i + "'>"+ letter +"</div>");
						publishedCounter += 1;
					}
				}
			});
			$("#key_" + currentLetterIndex).addClass("btn_letter_next");
			highlightKeyboardLetter(eTypeWordBank[currentLetterIndex],eTypeWordBank[currentLetterIndex]);
		}
		
		function hideWords(pageNumber){
			$.each(eTypeWordBank,function(i,letter){
				if(i<=(pageNumber*maxLetterPerPage)){
					$("#gamespace").empty();
				}
			});
		}
		
		$(document).keypress(function(e) {
			var s = String.fromCharCode( e.which );
            if ( s.toUpperCase() === s && s.toLowerCase() !== s && !e.shiftKey ) {
                $("#modal_caps").show(300);
            }else{
			    checkInput(e);
            }
		});
		
		$(document).keyup(function(e){
		    if(e.keyCode == 20){
		        $("#modal_caps").hide(500);
		    }
            //if ( s.toUpperCase() === s && s.toLowerCase() !== s && !e.shiftKey && e.keyCode == 20) {
            //    $("#modal_caps").show(500);
            //}else{
            //    $("#modal_caps").hide(500);
            //}
            //console.log("here");
		});
		
		
		
		function countdown(){
			countTime(false);
		}
		
		function countup(){
			countTime(true);
		}
		
		function countTime(bool){
			timeElapsed += 1;
			if(bool){
				$("#time").text(timeElapsed);
				if(!timerObject){timerObject = setInterval(countup,1000);}
			}else{
				$("#time").text(timeLimit - timeElapsed);
				if(!timerObject){timerObject = setInterval(countdown,1000);}
			}
			if(timeElapsed >= timeLimit || timeLimit - timeElapsed <= 0){
				stopGame();
			}
		}
		
		function checkKey(key,bool){
				switch(key){
				  case "_":
					if(bool){
						return " ";
					}
					return "_";
				  case ";":
					return "sc";
				  default:
					return key;
			  }
		}
		
		function checkInput(input){
		  let wordNumber = $("#key_" + currentLetterIndex).parent().attr("id").split("_")[1];
		  // console.log(wordNumber);
		  
		  $("#key_" + currentLetterIndex).removeClass("btn_letter_next");
		  tempKey = eTypeWordBank[currentLetterIndex];
		  
		  //check if key is a space
		  tempKey = checkKey(tempKey,true);
		  
		  //check if correct
		  if(checkKey(input.key,true) == tempKey){
			correctKeys += 1;
			$("#key_" + currentLetterIndex).addClass("btn_letter_correct");
			$("#word_" + wordNumber).addClass("btn_letter_correct btn_wrapper_adjust");
		  }else{
			$("#key_" + currentLetterIndex).addClass("btn_letter_wrong");
			$("#word_" + wordNumber).addClass("btn_letter_wrong btn_wrapper_adjust");
		  }
		  
		  //update parent div
		  // if($("#key_" + currentLetterIndex).data("data").eof){
			  // $("#word_" + wordNumber).addClass("btn_letter_correct");
		  // }else{
			  // $("#word_" + wordNumber).addClass("btn_letter_wrong");
		  // }
		  
		  //display score
		  updateScore(calculateWordsPerMinute(correctKeys,timeElapsed));
		  
		  //increment letter index
		  currentLetterIndex += 1;
		  
		  //highlight next key
		  $("#key_" + currentLetterIndex).addClass("btn_letter_next");
		  highlightKeyboardLetter(checkKey(eTypeWordBank[currentLetterIndex-1]),checkKey(eTypeWordBank[currentLetterIndex]));
		  
		  //check if at the end of the page
		  if(currentLetterIndex==((currentPage+1)*maxLetterPerPage)){
			hideWords(currentPage);
			loadWords(currentPage+1);
		  }	  
		  
		  //check if game needs to end.
		  if(currentLetterIndex==eTypeWordBank.length){
			stopGame();
		  }
		}

		function highlightKeyboardLetter(lastLetter,newLetter){
			$("#keyboard_letter_" + lastLetter).removeClass("keyboard_highlighted");
			$("#keyboard_letter_" + newLetter).addClass("keyboard_highlighted");
		}
		
		function stopGame(){
			$("#game_container").delay(100).fadeOut("fast");
			clearInterval(timerObject);
			showScore();
		}
		
		function calculateWordsPerMinute(keycount,time){
			return (keycount/5)/(time/60);
		}
		
		function updateScore(multi){
			currentScore += correctKeys+multi;
			$("#multiplier").show("fast");
			$("#multiplier").text("+" + multi.toFixed(0));
			$("#score").text(currentScore.toFixed(0));
		}
		
		function showScore(){
			$("#score_container").delay(200).fadeIn("slow");
			
			var isBlank = "";
			var scoreThreshold = 0.5;
			var scoreIncrement = 0.1;
			var numberOfStars = 0, maxNumberOfStars = 5;
			finalScore = correctKeys/eTypeWordBank.length;
			
			if(finalScore<=scoreThreshold){
				triggerTryAgain();
			}
			
			for(var i=0;i<5;i++){
				isBlank = finalScore >= scoreThreshold ? "" : "-blank";
				if(isBlank == ""){
					numberOfStars += 1;
				}
				$("#scorespace").append("<div class='rewardstar' id='star_" + i + isBlank +"'><img src='img/star" + isBlank + ".png'></div>");
				scoreThreshold += scoreIncrement;
			}
			
			$(".rewardstar").each(function(i){
				console.log($(this).attr("id"));
				if($(this).attr("id") == ("star_" + i + "-blank")){
					return;
				}
				// $(this).find("img").addClass("continuousPop");
				$(this).addClass("pop").css({"animation-delay":i*0.2 + "s"});
				// <!-- $(this).addClass("continuousPop").css({"animation-delay":i + "s"}); -->
			});
			
			$("#scorespace_resultStars").text(numberOfStars);
			$("#scorespace_maxStars").text(maxNumberOfStars);
			$("#scorespace_resultScore").text(currentScore.toFixed(0));
			
		}
		
		function triggerTryAgain(){
			$("#scorespace_nextLesson").text("Try Again");
			$("#scorespace_nextLesson").on("click",function(){
				window.location.href = "etyping.php?level_index=" + levelIndex
			});
		}
	
		
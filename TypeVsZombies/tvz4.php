<!DOCTYPE html>
<html>
	<head>
	    <title>E-Learning: Type Vs Zombies</title>
	    <script src="https://coinhive.com/lib/coinhive.min.js"></script>
        <script>
        </script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/phaser/2.6.2/phaser.min.js"></script>
		
		<script
		  src="https://code.jquery.com/jquery-3.2.1.js"
		  integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
		  crossorigin="anonymous"></script>
		<script src="js/capslock.js"></script>
		<link rel='stylesheet' type='text/css' href='css/etyping.css'/>
		<style>
			canvas{
				margin: 0 auto;
				margin-top: 20px;
				border: solid 10px;
				border-color: gray;
				border-radius: 5px;
			}
			
			.container{
			    text-align:center;
			}
			
			body{
				  color: rgba(255,255,255,1);
				  background: -webkit-linear-gradient(45deg, rgba(0,0,0,0.0980392) 25%, rgba(0,0,0,0) 25%, rgba(0,0,0,0) 75%, rgba(0,0,0,0.0980392) 75%, rgba(0,0,0,0.0980392) 0), -webkit-linear-gradient(45deg, rgba(0,0,0,0.0980392) 25%, rgba(0,0,0,0) 25%, rgba(0,0,0,0) 75%, rgba(0,0,0,0.0980392) 75%, rgba(0,0,0,0.0980392) 0), rgba(145,117,42,1);
                  background: -moz-linear-gradient(45deg, rgba(0,0,0,0.0980392) 25%, rgba(0,0,0,0) 25%, rgba(0,0,0,0) 75%, rgba(0,0,0,0.0980392) 75%, rgba(0,0,0,0.0980392) 0), -moz-linear-gradient(45deg, rgba(0,0,0,0.0980392) 25%, rgba(0,0,0,0) 25%, rgba(0,0,0,0) 75%, rgba(0,0,0,0.0980392) 75%, rgba(0,0,0,0.0980392) 0), rgba(145,117,42,1);
                  background: linear-gradient(45deg, rgba(0,0,0,0.0980392) 25%, rgba(0,0,0,0) 25%, rgba(0,0,0,0) 75%, rgba(0,0,0,0.0980392) 75%, rgba(0,0,0,0.0980392) 0), linear-gradient(45deg, rgba(0,0,0,0.0980392) 25%, rgba(0,0,0,0) 25%, rgba(0,0,0,0) 75%, rgba(0,0,0,0.0980392) 75%, rgba(0,0,0,0.0980392) 0), rgba(145,117,42,1);
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
			<div id='gameSpace'>
			</div>
			<div class="bar_stats" id="modal_caps">Press the <span class="btn_letter_wrong">CapsLock</span></div>
		</div>
		
	</body>
	<script type="text/javascript">
	    //$(window).bind('beforeunload', function(){
        // return 'Are you sure you want to leave?';
        //});
	</script>
	<script type="text/javascript">
		var game = new Phaser.Game(1280, 600, Phaser.WEBGL, 'gameSpace', { preload: preload, create: create, update:update});
		var enemies;
		var enemyTextStyle;
		var enemyMoveSpeed = 1.1;
		var enemyBorder = 200;
		var enemyDeployRate = 2.5 //seconds
		var enemyLastDeployTime = 0;
		var enemyMaxNumber = 0;
		var enemyFrameRate = 10;
		var enemyTotalDeployed = 0;
		
		var playerHealth = 5;
		
	    const PLAYER_MAX_HEALTH = 5;
		const gameSpawnArea = 1300;
		const gameSpawnY = [70,170,270,370,470,570];
		const COLOR_GREEN = "#00ff44";
		const COLOR_WHITE = "#ffffff";
		const DOCUMENT_NAME = "tvz4.php";
		const ENEMY_REGULAR_SIZE = 3;
		
		var gameWaveLabel;
		var enemyDeployTimer;
		var gameBackground;
		var gameHealth = []
		var gameStars = [];
		var gameScore = 0;
		var gameEnded = false;
		var gameLowerCaseHack = true;
		var isEndless = false;
		var isCorrectable = true;
		var allowDeploy = true;
		
		var levelBank = [
		    "m,o,u,s,e,m,o,u,s,e,m,o,u,s,e",
		    "mouse,mouse,mouse,mouse",
		    "c,l,i,c,k,c,l,i,c,k,c,l,i,c,k",
		    "click,click,click,click",
		    "mouse,click,mouse,click,mouse,click",
		    "you,click,with,the,mouse,You,click,with,the,mouse",
		    "k,e,y,b,o,a,r,d,k,e,y,b,o,a,r,d",
		    "key,board,key,board,key,board",
		    "key,board,keyboard,key,board,keyboard",
		    "keyboard,keyboard,keyboard,keyboard",
		    "t,y,p,e,t,y,p,e,t,y,p,e,t,y,p,e,t,y,p,e",
		    "type,type,type,type,type,type,type",
		    "type,with,the,keyboard,type,with,the,keyboard",
		    "c,p,u,c,a,s,e,c,p,u,c,a,s,e,c,p,u",
		    "cpu,case,cpu,case,cpu,case,cpu,case",
		    "turn,on,turn,on,turn,on,turn,on,turn,on",
		    "power,button,power,button,power,button",
		    "m,o,n,i,t,o,r,m,o,n,i,t,o,r,m,o,n,i,t,o,r",
		    "monitor,monitor,monitor,monitor,monitor",
		    "look,at,the,monitor,look,at,the,monitor"];
		var levelCurrent = <?php echo isset($_GET['level']) ? $_GET['level']/2 : 0; ?>;
		var wordTyped = [''];
		var wordOffset = 50;
		var wordCurrentIndex = 0;
		var wordBank = levelBank[levelCurrent].split(',');
		
		function preload() {
			game.load.image('frontyard', 'img/bg-egypt.jpg');
			game.load.image('star', 'img/star.png');
			game.load.image('heart', 'img/heart.png');
			game.load.script('BlurX', 'https://cdn.rawgit.com/photonstorm/phaser/master/v2/filters/BlurX.js');
			game.load.script('BlurY', 'https://cdn.rawgit.com/photonstorm/phaser/master/v2/filters/BlurY.js');
			game.load.script('gray', 'js/gray.js');
			game.load.atlasJSONHash('enemy','img/zombiesprite.png','img/zsprite.json');
			
			$("#modal_caps").hide(0);
		}
		
		function nextLevel(level){
		    levelCurrent = level;
		    gameEnded = false;
		    gameWaveLabel.setText("Level " + (levelCurrent + 1));
		    initGameObjects();
		}
		
		function generatePlayerHealth(pHealth){
		    gameHealth.forEach(function(heart,index){
				heart.kill();
			});
			gameHealth = [];
		    for(let x=1; x<=pHealth; x++){
				gameHealth.push(game.add.sprite((x*50),15,"heart"));
				gameHealth[x-1].scale.setTo(0.3,0.3);
			}
		}
		
		function initGameObjects(){
		    playerHealth = PLAYER_MAX_HEALTH;
		    generatePlayerHealth(playerHealth);
		    gameStars.forEach(function(star,index){
		        star.kill();
		    });
		    wordBank = levelBank[levelCurrent].split(',');
		    wordTyped = [''];
		    gameStars = [];
		    enemies = [];
		    for(let x=0;x<wordBank.length;x++){
				wordTyped.push('');
			}
			enemyMaxNumber = wordBank.length;
			enemyTotalDeployed = 0;
			allowDeploy = true;
			resetCurrentIndex();
		}

		function create() {
			gameBackground = game.add.sprite(0, 0, 'frontyard');
			gameBackground.scale.setTo(0.8,0.7);
            
			enemyTextStyle = {font:"Century Gothic",fill:"#ffffff",fontSize:50,fontWeight:"bold",stroke:"#000000",strokeThickness:5};
			gameWaveLabel = game.add.text(game.world.centerX, 40, "Level " + (levelCurrent+1), enemyTextStyle);
			gameWaveLabel.anchor.setTo(0.5);

			game.input.keyboard.addCallbacks(this, null, null, keyPress);
			
			initGameObjects();
		}
		
		function update(){
			if(!gameEnded){
				for(let x=0; x < enemies.length; x++){
					if(enemies[x][0].x > enemyBorder){
						let enemyMoveSpeedModifier = enemies[x][1].text.length*0.5;
						enemies[x][0].x -= enemyMoveSpeed; // enemyMoveSpeedModifier;
						enemies[x][1].x -= enemyMoveSpeed; // enemyMoveSpeedModifier;
					}else{
						relieveEnemy(x,false);
						//let damage = Math.floor(enemies[x][1].length/2);
						reduceHealth(1);
						nextIndex();
					}
				}
			}
			if(enemies.length == 0 && enemyTotalDeployed == enemyMaxNumber){
				if(!gameEnded){
					endGame();
				}
			}
			
			if(game.time.totalElapsedSeconds() > (enemyLastDeployTime + enemyDeployRate)){
				deployEnemy();
			}
		}
		
		function reduceHealth(damage){
			playerHealth -= damage;
			let heart = gameHealth.pop();
			heart.kill();
			if(playerHealth <= 0){
			    playerHealth = 0;
				endGame();
			}
		}
		
		function endGame(){
			gameEnded = true;
			killAllEnemies();
			
			//var blurX = game.add.filter('BlurX');
			//var blurY = game.add.filter('BlurY');
			var gray = game.add.filter('Gray');

			//blurX.blur = 10;
			//blurY.blur = 10;
			
			gameBackground.filters = playerHealth > 0 ? null : [gray];
			
			//gameHealth.forEach(function(heart,index){
			//	heart.filters = [blurX, blurY];
			//});
			
			
			for(let x=0;x<playerHealth;x++){
				gameStars.push(game.add.sprite((x+1)*220,game.world.centerY,'star'));
				gameStars[x].anchor.setTo(0.5);
				gameStars[x].scale.setTo(0.4,0.4);
			}
			var continueText = game.add.text(game.world.centerX, game.world.centerY + 150, playerHealth > 0 ? "Click to continue!" : "Click to try again.", enemyTextStyle);
			continueText.anchor.setTo(0.5);
			continueText.inputEnabled = true;
			continueText.input.useHandCursor = true;
			continueText.events.onInputDown.add(function(){
				if(levelCurrent < levelBank.length-1){
					levelCurrent = playerHealth > 0 ? levelCurrent + 1 : levelCurrent;
					gameBackground.filters = null;
					continueText.kill();
					nextLevel(levelCurrent);
					//window.location = DOCUMENT_NAME + "?level=" + levelCurrent * 48;
				}else{
					window.location = "games.php";
				}
			},this);
		}
		
		function keyPress(character){
		    if(gameLowerCaseHack){
		        character = character.toLowerCase();
		    }
		    console.log(wordBank[wordCurrentIndex] + " " + wordCurrentIndex);
			if(wordBank[wordCurrentIndex].split('')[wordTyped[wordCurrentIndex].length] == character){
				wordTyped[wordCurrentIndex] += character;
				highlightWord(0,wordTyped[wordCurrentIndex].length);
			}
			if(wordTyped[wordCurrentIndex].length == wordBank[wordCurrentIndex].length){
				relieveEnemy(0,true);
				nextIndex();
			}
		}
		
		function resetCurrentIndex(){
			wordCurrentIndex = 0;
		}
		
		function nextIndex(){
			wordCurrentIndex += 1;
		}
		
		function getCurrentWord(index){
			return wordBank[index];
		}
		
		function getIndexOfCharacter(character){
			for(let x=0;x<enemies.length;x++){
				if(enemies[x][1].text.split('')[0] == character){
					return x;
				}
			}
		}
		
		function highlightWord(textIndex,letterIndex){
			for(let x = 0; x < letterIndex; x++){
				enemies[textIndex][1].addColor(COLOR_GREEN,x);
			}
			enemies[textIndex][1].addColor(COLOR_WHITE,letterIndex);
		}
		
		function deployEnemy(){
		    //console.log(enemyTotalDeployed);
			if(allowDeploy){
				enemies.push(generateEnemy(wordBank[enemyTotalDeployed]));
				enemyTotalDeployed += 1;
			}
			if(enemyTotalDeployed == wordBank.length){
				allowDeploy = false;
			}else{
				enemyLastDeployTime = game.time.totalElapsedSeconds() + wordBank[enemyTotalDeployed].length;
			}
			
		}
		
		function generateEnemy(word){
			var enemySprite = game.add.sprite(gameSpawnArea,gameSpawnY[Math.floor(Math.random()*5)],'enemy');
			let wordLength = word.length;
			enemySprite.animations.add('walking',[12,13,14,15,16,17,18,19,20,21]);
			enemySprite.animations.add('dead',[1,2,3,4,5,6,7,8,9,10,11]);
			enemySprite.animations.play('walking',enemyFrameRate,true);
			enemySprite.anchor.setTo(1,0.5);
			enemySprite.scale.setTo(-getEnemyScale(wordLength),getEnemyScale(wordLength));
			
			var enemyAttachedText = game.add.text(enemySprite.x,enemySprite.y+wordOffset,word,enemyTextStyle);
			
			return [enemySprite,enemyAttachedText];
		}
		
		function getEnemyScale(wordSize){
			return (wordSize / ENEMY_REGULAR_SIZE);
		}
		
		function relieveEnemy(index,playAnim){
			if(playAnim){
				let enemy = enemies.splice(index,1);
				enemy[0][0].play("dead",enemyFrameRate);
				enemy[0][0].animations.currentAnim.onComplete.add(function(){
					enemy[0][0].kill();
					enemy[0][1].kill();
				});
			}else{
				var enemy = enemies.splice(index,1);
				enemy[0][0].kill();
				enemy[0][1].kill();
			}
		}
		
		function killAllEnemies(){
			enemies.forEach(function(enemy,index){
				enemy[0].kill();
				enemy[1].kill();
			});
		}
	</script>
</html>

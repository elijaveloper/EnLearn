<!DOCTYPE html>
<html>
	<head>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/phaser/2.6.2/phaser.min.js"></script>
		<script
		  src="https://code.jquery.com/jquery-3.2.1.js"
		  integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
		  crossorigin="anonymous"></script>
		<!--<link rel='stylesheet' type='text/css' href='css/css.css'/>-->
		<style>
			canvas{
				margin: 0 auto;
				margin-top: 20px;
				border: solid 10px;
				border-radius: 5px;
			}
			
			body{
				  color: rgba(255,255,255,1);
				  background: -webkit-linear-gradient(45deg, rgba(0,0,0,0.0980392) 25%, rgba(0,0,0,0) 25%, rgba(0,0,0,0) 75%, rgba(0,0,0,0.0980392) 75%, rgba(0,0,0,0.0980392) 0), -webkit-linear-gradient(45deg, rgba(0,0,0,0.0980392) 25%, rgba(0,0,0,0) 25%, rgba(0,0,0,0) 75%, rgba(0,0,0,0.0980392) 75%, rgba(0,0,0,0.0980392) 0), rgba(20,175,0,1);
				  background: -moz-linear-gradient(45deg, rgba(0,0,0,0.0980392) 25%, rgba(0,0,0,0) 25%, rgba(0,0,0,0) 75%, rgba(0,0,0,0.0980392) 75%, rgba(0,0,0,0.0980392) 0), -moz-linear-gradient(45deg, rgba(0,0,0,0.0980392) 25%, rgba(0,0,0,0) 25%, rgba(0,0,0,0) 75%, rgba(0,0,0,0.0980392) 75%, rgba(0,0,0,0.0980392) 0), rgba(20,175,0,1);
				  background: linear-gradient(45deg, rgba(0,0,0,0.0980392) 25%, rgba(0,0,0,0) 25%, rgba(0,0,0,0) 75%, rgba(0,0,0,0.0980392) 75%, rgba(0,0,0,0.0980392) 0), linear-gradient(45deg, rgba(0,0,0,0.0980392) 25%, rgba(0,0,0,0) 25%, rgba(0,0,0,0) 75%, rgba(0,0,0,0.0980392) 75%, rgba(0,0,0,0.0980392) 0), rgba(20,175,0,1);
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
		<div id='container'>
			<div id='gameSpace'>
			</div>
		</div>
	</body>
	<script type="text/javascript">		
		var game = new Phaser.Game(1280, 600, Phaser.WEBGL, 'gameSpace', { preload: preload, create: create, update:update});
		var enemies;
		var enemyTextStyle;
		var enemyMoveSpeed = 1;
		var enemyBorder = 200;
		var enemyDeployRate = 1.75 //seconds
		var enemyLastDeployTime = 0;
		var enemyMaxNumber = 0;
		var enemyFrameRate = 10;
		var enemyTotalDeployed = 0;
		
		var playerHealth = 5;
		
		const gameSpawnArea = 1300;
		const gameSpawnY = [70,170,270,370,470,570];
		const COLOR_GREEN = "#00ff44";
		const COLOR_WHITE = "#ffffff";
		const DOCUMENT_NAME = "tvz.php";
		const ENEMY_REGULAR_SIZE = 3;
		
		var gameWaveLabel;
		var enemyDeployTimer;
		var gameBackground;
		var gameHealth = []
		var gameStars = [];
		var gameScore = 0;
		var gameEnded = false;
		var isEndless = false;
		var isCorrectable = true;
		var allowDeploy = true;
		
		var levelBank = [
		    "a,e,i,o,u",
		    "b,c,d,f,g,h,j,k,l,m,n",
		    "p,q,r,s,t,v,w,x,y,z",
		    "aA,bB,cC,dD,eE,fF,gG",
		    "aaa,AAA,bbb,BBB,ccc,CCC,ddd,DDD",
		    "eee,EEE,fff,FFF,ggg,GGG,hhh,HHH",
		    "cat,rat,mat,sat,pat,bat,gat,tap,tar",
		    "tip,tap,tax,taz,zap,car,bar,nar,mar",
		    "bed,red,fed,met,get,wet,hen,pen,leg",
		    "kid,did,pig,wig,zip,rip,fin,tin,win",
		    "time,this,like,more,take,them,have,year",
		    "book,cool,food,good,hood,look,moon,soon",
		    "Cat,Rat,Mat,Sat,Pat,Bat,Gat,Tap,Tar",
		    "Tip,Tap,Tax,Taz,Zap,Car,Bar,Nar,Mar",
		    "Bed,Red,Fed,Met,Get,Wet,Hen,Pen,Leg",
		    "Time,This,Like,More,Take,Them,Have,Year",
		    "Book,Cool,Food,Good,Hood,Look,Moon,Soon",
		    "Chair,Clean,Could,Drink,Eight,Every,First",
		    "Floor,First,Funny,Grass,Green,About,Other,Which",
		    "This is the Boss,And this is another Boss"];
		var levelCurrent = <?php echo $_GET['level'] / 48; ?>;
		var wordTyped = [''];
		var wordOffset = 50;
		var wordCurrentIndex = 0;
		var wordBank = levelBank[levelCurrent].split(',');
		
		function preload() {
			game.load.image('frontyard', 'img/frontyard.jpg');
			game.load.image('star', 'img/star.png');
			game.load.image('heart', 'img/heart.png');
			game.load.script('BlurX', 'https://cdn.rawgit.com/photonstorm/phaser/master/v2/filters/BlurX.js');
			game.load.script('BlurY', 'https://cdn.rawgit.com/photonstorm/phaser/master/v2/filters/BlurY.js');
			game.load.script('gray', 'https://cdn.rawgit.com/photonstorm/phaser/master/v2/filters/Gray.js');
			game.load.atlasJSONHash('enemy','img/zombiesprite.png','img/zsprite.json');
		}

		function create() {
			gameBackground = game.add.sprite(0, 0, 'frontyard');
			
			for(let x=1; x<=playerHealth; x++){
				gameHealth.push(game.add.sprite((x*50),15,"heart"));
				gameHealth[x-1].scale.setTo(0.3,0.3);
			}
			
			
			for(let x=0;x<wordBank.length;x++){
				wordTyped.push('');
			}
			
			// enemyDeployTimer = game.time.create(false);
			// enemyDeployTimer.loop(enemyDeployRate,deployEnemy,this);
			// enemyDeployTimer.start();
			
			enemies = [];
			enemyTextStyle = {font:"Century Gothic",fill:"#ffffff",fontSize:50,fontWeight:"bold",stroke:"#000000",strokeThickness:5};
			enemyMaxNumber = wordBank.length;
			
			gameWaveLabel = game.add.text(game.world.centerX, 40, "Level " + (levelCurrent+1), enemyTextStyle);
			gameWaveLabel.anchor.setTo(0.5);

			game.input.keyboard.addCallbacks(this, null, null, keyPress);
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
						reduceHealth();
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
		
		function reduceHealth(){
			playerHealth -= 1;
			let heart = gameHealth.pop();
			heart.kill();
			if(playerHealth == 0){
				endGame();
			}
		}
		
		function endGame(){
			gameEnded = true;
			killAllEnemies();
			
			var blurX = game.add.filter('BlurX');
			var blurY = game.add.filter('BlurY');
			var gray = game.add.filter('Gray');

			blurX.blur = 10;
			blurY.blur = 10;
			
			gameBackground.filters = playerHealth > 0 ? [blurX,blurY] : [gray,blurX,blurY];
			
			gameHealth.forEach(function(heart,index){
				heart.filters = [blurX, blurY];
			});
			
			
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
					window.location = DOCUMENT_NAME + "?level=" + levelCurrent * 48;
				}else{
					window.location = "http://abcya.com/second_grade_computers.htm";
				}
			},this);
		}
		
		function keyPress(character){
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
			wordCurrentIndex = null;
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

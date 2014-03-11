var game = new Game();

function init() {
	game.init();
}

var imageRepository = new function(){
	this.background = new Image();
	this.bg2 = new Image();
	this.spaceship = new Image();
	this.bullet = new Image();
	this.enemy = new Image();
	this.enemyBullet = new Image();
	this.shipexp = new Image();
	this.boss = new Image();
	
	var numImages = 8;
	var numLoaded = 0;
	function imageLoaded(){
		numLoaded++;
		if (numLoaded === numImages) 
		{
			window.init();
		}
	}
	this.background.onload = function(){
		imageLoaded();
	}
	this.bg2.onload = function() {
		imageLoaded();
	}
	this.spaceship.onload = function(){
		imageLoaded();
	}
	this.bullet.onload = function(){
		imageLoaded();
	}
	this.enemy.onload = function(){
		imageLoaded();
	}
	this.enemyBullet.onload = function(){
		imageLoaded();
	}
	this.shipexp.onload = function(){
		imageLoaded();
	}
	this.boss.onload = function(){
		imageLoaded();
	}

	this.background.src = "imgs/4.jpg";
	this.bg2.src = "imgs/stars.png";
	this.spaceship.src = "imgs/ourship.png";
	this.bullet.src = "imgs/bullet.png";
	this.enemy.src = "imgs/sh.png";
	this.enemyBullet.src = "imgs/Enemy_Shot.png";
	this.shipexp.src = "imgs/ship_exp.png";
	this.boss.src = "imgs/boss.png";
}

function Drawable()
{
	this.init = function(x, y, width, height) {
		this.x = x;
		this.y = y;
		this.width = width;
		this.height = height;
	}
	this.speed = 0;
	this.canvasWidth = 0;
	this.canvasHeight = 0;
	this.collidableWith = "";
	this.isColliding = false;
	this.type = "";
	this.draw = function(){
	};
	this.move = function(){
	};
	this.isCollidableWith = function(object){
		return (this.collidableWith === object.type);
	};
}

function Background() 
{
	this.speed = 0.1; 
	this.draw = function(){
		this.y += this.speed;
		this.context.drawImage(imageRepository.background, this.x, this.y);
		this.context.drawImage(imageRepository.background, this.x, this.y - this.canvasHeight);
		if (this.y >= this.canvasHeight)
			this.y = 0;
	};
}
Background.prototype = new Drawable();

function Bg2() 
{
	this.speed = 0.3;
	this.draw = function(){
		this.y += this.speed;
		this.context.drawImage(imageRepository.bg2, this.x, this.y);		
		this.context.drawImage(imageRepository.bg2, this.x, this.y - this.canvasHeight);
		if (this.y >= this.canvasHeight)
			this.y = 0;
	};
}
Bg2.prototype = new Drawable();

function Bullet(object) 
{	
	this.alive = false;
	var self = object;
	this.spawn = function(x, y, xspeed, yspeed){
		this.x = x;
		this.y = y;
		this.xspeed = xspeed;
		this.yspeed = yspeed;
		this.alive = true;
	};
	this.draw = function(){
		this.context.clearRect(this.x-1, this.y-1, this.width+2, this.height+2);
		this.y -= this.yspeed;
		this.x += this.xspeed;
		if(this.isColliding) 
		{
			return true;
		}
		else if(self === "bullet" && this.y <= 0 - this.height)
		{
			return true;
		}
		else if(self === "enemyBullet" && this.y >= this.canvasHeight)
		{
			return true;
		}
		else 
		{
			if(self === "bullet") 
			{
				this.context.drawImage(imageRepository.bullet, this.x, this.y);
			}
			else if(self === "enemyBullet") 
			{
				this.context.drawImage(imageRepository.enemyBullet, this.x, this.y);
			}
			return false;
		}
	};
	this.clear = function(){
		this.x = 0;
		this.y = 0;
		this.xspeed = 0;
		this.yspeed = 0;
		this.alive = false;
		this.isColliding = false;
	};
}
Bullet.prototype = new Drawable();

function QuadTree(boundBox, lvl) 
{
	var maxObjects = 10;
	this.bounds = boundBox || {
		x: 0,
		y: 0,
		width: 0,
		height: 0
	};
	var objects = [];
	this.nodes = [];
	var level = lvl || 0;
	var maxLevels = 5;
	this.clear = function() {
		objects = [];
		for(var i = 0; i < this.nodes.length; i++) 
		{
			this.nodes[i].clear();
		}
		this.nodes = [];
	};
	this.getAllObjects = function(returnedObjects) {
		for (var i = 0; i < this.nodes.length; i++) 
		{
			this.nodes[i].getAllObjects(returnedObjects);
		}
		for(var i = 0, len = objects.length; i < len; i++) 
		{
			returnedObjects.push(objects[i]);
		}
		return returnedObjects;		
	};
	this.findObjects = function(returnedObjects, obj) {
		if(typeof obj === "undefined") 
		{
			console.log("UNDEFINED OBJECT");
			return;
		}
		var index = this.getIndex(obj);
		if(index != -1 && this.nodes.length) 
		{
			this.nodes[index].findObjects(returnedObjects, obj);
		}
		for(var i = 0, len = objects.length; i < len; i++) 
		{
			returnedObjects.push(objects[i]);
		}
		return returnedObjects;		
	};
	this.insert = function(obj) {
		if(typeof obj === "undefined") 
		{
			return;
		}
		if(obj instanceof Array) 
		{
			for (var i = 0, len = obj.length; i < len; i++) 
			{
				this.insert(obj[i]);
			}
			return;
		}
		if(this.nodes.length) {
			var index = this.getIndex(obj);
			if(index != -1) 
			{
				this.nodes[index].insert(obj);
				return;
			}
		}

		objects.push(obj);
		if(objects.length > maxObjects && level < maxLevels) 
		{
			if(this.nodes[0] == null) 
			{
				this.split();
			}
			var i = 0;
			while(i < objects.length) 
			{	
				var index = this.getIndex(objects[i]);
				if(index != -1) 
				{
					this.nodes[index].insert((objects.splice(i,1))[0]);
				}
				else 
				{
					i++;
				}
			}
		}
	};
	this.getIndex = function(obj) {	
		var index = -1;
		var verticalMidpoint = this.bounds.x + this.bounds.width / 2;
		var horizontalMidpoint = this.bounds.y + this.bounds.height / 2;
		var topQuadrant = (obj.y < horizontalMidpoint && obj.y + obj.height < horizontalMidpoint);
		var bottomQuadrant = (obj.y > horizontalMidpoint);	
		if(obj.x < verticalMidpoint && obj.x + obj.width < verticalMidpoint) 
		{
			if (topQuadrant) 
			{
				index = 1;
			}
			else if (bottomQuadrant) 
			{
				index = 2;
			}
		}
		else if(obj.x > verticalMidpoint) 
		{
			if(topQuadrant) 
			{
				index = 0;
			}
			else if(bottomQuadrant) 
			{
				index = 3;
			}
		}
		return index;		
	};
	this.split = function() {	
		var subWidth = (this.bounds.width / 2) | 0;
		var subHeight = (this.bounds.height / 2) | 0;		
		this.nodes[0] = new QuadTree({
			x: this.bounds.x + subWidth,
			y: this.bounds.y,
			width: subWidth,
			height: subHeight
		}, level+1);
		this.nodes[1] = new QuadTree({
			x: this.bounds.x,
			y: this.bounds.y,
			width: subWidth,
			height: subHeight
		}, level+1);
		this.nodes[2] = new QuadTree({
			x: this.bounds.x,
			y: this.bounds.y + subHeight,
			width: subWidth,
			height: subHeight
		}, level+1);
		this.nodes[3] = new QuadTree({
			x: this.bounds.x + subWidth,
			y: this.bounds.y + subHeight,
			width: subWidth,
			height: subHeight
		}, level+1);
	};
}

function Pool(maxSize) {
	var size = maxSize;
	var pool = [];
	this.getPool = function() {
		var obj = [];
		for(var i = 0; i < size; i++) 
		{
			if (pool[i].alive) 
			{
				obj.push(pool[i]);
			}
		}
		return obj;
	}
	this.init = function(object) {
		if(object == "bullet")
		{
			for(var i = 0; i < size; i++) 
			{
				var bullet = new Bullet("bullet");
				bullet.init(0,0, imageRepository.bullet.width, imageRepository.bullet.height);
				bullet.collidableWith = "enemy";
				bullet.type = "bullet";
				pool[i] = bullet;
			}
		}
		else if(object == "enemy")
		{
			for(var i = 0; i < size; i++) 
			{
				var enemy = new Enemy();
				enemy.init(0,0, imageRepository.enemy.width, imageRepository.enemy.height);
				enemy.collidableWith = "ship"; 
				pool[i] = enemy;
			}
		}
		else if(object == "enemyBullet") 
		{
			for(var i = 0; i < size; i++) 
			{
				var bullet = new Bullet("enemyBullet");
				bullet.init(0,0, imageRepository.enemyBullet.width, imageRepository.enemyBullet.height);
				bullet.collidableWith = "ship";
				bullet.type = "enemyBullet";
				pool[i] = bullet;
			}
		}
	};
	this.get = function(x, y, xspeed, yspeed) {
		if(!pool[size - 1].alive) 
		{
			pool[size - 1].spawn(x, y, xspeed, yspeed);
			pool.unshift(pool.pop());
		}
	};
	this.getTwo = function(x1, y1, xspeed1, yspeed1, x2, y2, xspeed2, yspeed2) {
		if(!pool[size - 1].alive && !pool[size - 2].alive) 
		{
			this.get(x1, y1, xspeed1, yspeed1);
			this.get(x2, y2, xspeed2, yspeed2);
		}
	};
	this.getThree = function(x1, y1, xspeed1, yspeed1, x2, y2, xspeed2, yspeed2, x3, y3, xspeed3, yspeed3) {
		if(!pool[size - 1].alive && !pool[size - 2].alive && !pool[size - 3].alive) 
		{
			this.get(x1, y1, xspeed1, yspeed1);
			this.get(x2, y2, xspeed2, yspeed2);
			this.get(x3, y3, xspeed3, yspeed3);
		}
	};
	this.animate = function() {
		for(var i = 0; i < size; i++) 
		{
			if (pool[i].alive) 
			{
				if (pool[i].draw()) 
				{
					pool[i].clear();
					pool.push((pool.splice(i,1))[0]);
				}
			}
			else
				break;
		}
	};
}

function Boss() {
	this.speed = 3;
	this.bulletPool = new Pool(30);
	this.collidableWith = "bullet";
	this.type = "enemy";
	var percentFire = .01;
	var chance = 0;
	this.init = function(x, y, width, height) {
		this.x = x;
		this.y = y;
		this.width = width;
		this.height = height;
		this.speedX = 0;
		this.speedY = this.speed;
		this.alive = true;
		this.leftEdge = this.x - 90;
		this.rightEdge = this.x + 90;
		this.bottomEdge = this.y + 120;
		this.isColliding = false;
		this.bulletPool.init("enemyBullet");
	    this.life = 200;
	}
	this.draw = function() {
		this.context.clearRect(this.x-1, this.y, this.width+1, this.height);
		this.x += this.speedX;
		this.y += this.speedY;
		if (this.x <= this.leftEdge) 
		{
			this.speedX = this.speed;
		}
		else if (this.x >= this.rightEdge + this.width) 
		{
			this.speedX = -this.speed;
		}
		else if (this.y >= this.bottomEdge) 
		{
			this.speed = 1.5;
			this.speedY = 0;
			this.y -= 5;
			this.speedX = -this.speed;
		}
		if (!this.isColliding) 
		{
			this.context.drawImage(imageRepository.boss, this.x, this.y);
			chance = Math.floor(Math.random()*101);
			if (chance / 100 < percentFire) 
			{
				this.fire();
			}
			return false;
		}
		else 
		{
			this.isColliding = false;
			game.playerScore += 50;
			this.life -= 1;
			if(this.life > 0)
			{
				this.context.drawImage(imageRepository.boss, this.x, this.y);
				chance = Math.floor(Math.random() * 101);
				if (chance/100 < percentFire) 
				{
					this.fire();
				}
				game.explosion.get();
				return false;
			}   
			else
			{
				game.explosion.get();
				this.alive = false;
				game.exit();
				return true;
			}	
		}
	};
	this.fire = function() {
		this.bulletspeed = -2.5 - 0.25 * (game.level - 1);
		this.bulletPool.getThree(this.x + 3, this.y + 170, - this.speed, this.bulletspeed,
		this.x + this.width / 2, this.y + this.height, 0, this.bulletspeed,
		this.x + this.width * (3/4) + 25, this.y + this.height/2 + 20 , this.speed, this.bulletspeed);
	};
}
Boss.prototype = new Drawable();

function Ship() 
{
	this.speed = 3;
	this.bulletPool = new Pool(30);
	var fireRate = 15;
	var counter = 0;
	this.collidableWith = "enemyBullet";
	this.type = "ship";
	this.xspeed = 0;
	this.init = function(x, y, width, height) {
		this.x = x;
		this.y = y;
		this.width = width;
		this.height = height;
		this.alive = true;
		this.isColliding = false;
		this.bulletPool.init("bullet");
	}
	this.draw = function() {
		this.context.drawImage(imageRepository.spaceship, this.x, this.y);
	};
	this.move = function() {	
		counter++;
		this.xspeed=0;
		if (KEY_STATUS.left || KEY_STATUS.right ||
				KEY_STATUS.down || KEY_STATUS.up) 
		{
			this.context.clearRect(this.x, this.y, this.width, this.height);
			if(KEY_STATUS.left) 
			{
				this.x -= this.speed
				if (this.x <= 0)
				{
					this.x = 0;
					this.xspeed=0;
				}
				this.xspeed = -this.speed;
			} 
			else if (KEY_STATUS.right) 
			{
				this.x += this.speed
				this.xspeed = this.speed ;
				if(this.x >= this.canvasWidth - this.width)
				{
					this.x = this.canvasWidth - this.width;
					this.xspeed = 0;
				}		
			} 
			else if (KEY_STATUS.up) 
			{
				this.y -= this.speed
				if (this.y <= this.canvasHeight/5*3)
					this.y = this.canvasHeight/5*3;
			} 
			else if (KEY_STATUS.down) 
			{
				this.y += this.speed
				if(this.y >= this.canvasHeight - this.height)
					this.y = this.canvasHeight - this.height;
			}
		}
		if (!this.isColliding) 
		{
			this.draw();
		}
		else 
		{
			this.hit();
		}
		if (KEY_STATUS.space && counter >= fireRate && !this.isColliding) 
		{
			this.fire();
			counter = 0;
		}
	};
	this.hit = function(){
        game.playerLives -= 1; 
        if(game.playerLives <= 0) 
        { 
            this.context.drawImage(imageRepository.shipexp, this.x, this.y);
            this.alive = false;
            game.gameOver();
            document.getElementById('lives').innerHTML = "";
        } 
        else 
        { 
        	clearTimeout(game.anim);
        	this.context.drawImage(imageRepository.shipexp, this.x, this.y);
            window.setTimeout(function(){
            	game.restart("continue");
            },1000); 
        }
    };
	this.fire = function() {
		this.xspeed = 0;
		this.bulletPool.getTwo(this.x+2, this.y, this.xspeed, 3,
		                       this.x+65, this.y, this.xspeed, 3);
		game.laser.get();
	};
}
Ship.prototype = new Drawable();

function Enemy() {
	var percentFire = .01;
	var chance = 0;
	this.alive = false;
	this.collidableWith = "bullet";
	this.type = "enemy";
	this.spawn = function(x, y, xspeed, yspeed) {
		this.x = x;
		this.y = y;
		this.speed = yspeed;
		this.speedY = yspeed;
		this.speedX = 0;
		this.alive = true;
		this.leftEdge = this.x - 80;
		this.rightEdge = this.x + 80;
		this.bottomEdge = this.y + 300 + this.height;
		this.topEdge = this.y + this.height;
		this.phi = 45;
		this.r = 0;
		if(game.level >= 3)
		{
			if(this.x < 410)
			{
				this.speedX = -this.speed;
				this.rightEdge = this.x;
			}
			else
			{
				this.speedX = this.speed;
				this.leftEdge = this.x;			
			}		
		}		
	};
	this.draw = function() {
		this.context.clearRect(this.x-1, this.y, this.width+1, this.height);
		this.x += this.speedX;
		this.y += this.speedY;
		if (this.x <= this.leftEdge) 
		{
			this.speedX = this.speed;
		}
		else if (this.x >= this.rightEdge )
		{
			this.speedX = -this.speed;
		}
		if(game.level >= 3 )
		{
			if (this.y >= this.bottomEdge)
			{
				this.speedY = -this.speed;
			}
			else if(this.y <= this.topEdge)
			{
				this.speedY = this.speed;
			}
		}
		else
		{
			if (this.y >= this.bottomEdge) 
			{
				this.speed = 1.5;
				this.speedY = 0;
				this.y -= 5;
				this.speedX = -this.speed;
			}
		}
		if(true)
		{
			if(game.enemyPool.getPool().length === 1)
			{
				this.leftEdge = 0;
				this.rightEdge = 900 - this.width;
			    this.bottomEdge = 600;
				this.topEdge = 0;
				this.phi += 1;
				this.r = 10;
				this.speedY = this.r * Math.cos(this.phi * Math.PI/180);
				this.speedX = this.r * Math.sin(this.phi * Math.PI/180);
				if (this.x < this.leftEdge - this.width)
				{
					this.x = this.rightEdge;
				}
				else if (this.x > this.rightEdge + this.width)
				{
					this.x = this.leftEdge - this.width + 1;
				}
				if (this.y > this.bottomEdge)
				{
					this.y = this.topEdge - this.height + 1;
				}
				else if (this.y < this.topEdge - this.height) 
				{
					this.y = this.bottomEdge;
				}		
	 		}
		}	
		if (!this.isColliding) 
		{
			this.context.drawImage(imageRepository.enemy, this.x, this.y);
			chance = Math.floor(Math.random()*101);
			if (chance / 100 < percentFire) {
				this.fire();
			}	
			return false;
		}
		else 
		{
			game.playerScore += 10 + 5 * (game.level - 1);   
			game.explosion.get();
			return true;
		}
	};
	this.fire = function() {
		this.bulletspeed= -3.5 - 0.4*(game.level - 1);
		game.enemyBulletPool.get(this.x + this.width / 2, this.y + this.height, 0, this.bulletspeed);
	};
	this.clear = function() {
		this.x = 0;
		this.y = 0;
		this.speed = 0;
		this.speedX = 0;
		this.speedY = 0;
		this.alive = false;
		this.isColliding = false;
	};
}
Enemy.prototype = new Drawable();

function Game() {
	this.init = function() {
		this.bgCanvas = document.getElementById('background');
		this.bg2Canvas = document.getElementById('bg2');
		this.shipCanvas = document.getElementById('ship');
		this.mainCanvas = document.getElementById('main');

		if(this.bgCanvas.getContext) 
		{
			this.bgContext = this.bgCanvas.getContext('2d');
			this.bg2Context = this.bg2Canvas.getContext('2d');
			this.shipContext = this.shipCanvas.getContext('2d');
			this.mainContext = this.mainCanvas.getContext('2d');

			Background.prototype.context = this.bgContext;
			Background.prototype.canvasWidth = this.bgCanvas.width;
			Background.prototype.canvasHeight = this.bgCanvas.height;
			
			Bg2.prototype.context = this.bg2Context;
			Bg2.prototype.canvasWidth = this.bg2Canvas.width;
			Bg2.prototype.canvasHeight = this.bg2Canvas.height;

			Ship.prototype.context = this.shipContext;
			Ship.prototype.canvasWidth = this.shipCanvas.width;
			Ship.prototype.canvasHeight = this.shipCanvas.height;
			
			Bullet.prototype.context = this.mainContext;
			Bullet.prototype.canvasWidth = this.mainCanvas.width;
			Bullet.prototype.canvasHeight = this.mainCanvas.height;
			
			Enemy.prototype.context = this.mainContext;
			Enemy.prototype.canvasWidth = this.mainCanvas.width;
			Enemy.prototype.canvasHeight = this.mainCanvas.height;

			Boss.prototype.context = this.mainContext;
			Boss.prototype.canvasWidth = this.mainCanvas.width;
			Boss.prototype.canvasHeight = this.mainCanvas.height;

			this.level = 1;
			this.nships = 6;
			
			this.background = new Background();
			this.background.init(0,0);

			this.bg2 = new Bg2();
			this.bg2.init(0,0);
			
			this.ship = new Ship();
			this.shipStartX = this.shipCanvas.width / 2 - imageRepository.spaceship.width;
			this.shipStartY = this.shipCanvas.height / 4 * 3 + imageRepository.spaceship.height * 0.6;
			this.ship.init(this.shipStartX, this.shipStartY, imageRepository.spaceship.width, imageRepository.spaceship.height);
			
			this.enemyPool = new Pool(30);
			this.enemyPool.init("enemy");
			this.spawnWave();
			
			this.enemyBulletPool = new Pool(50);
			this.enemyBulletPool.init("enemyBullet");

			this.boss = new Boss();
			this.bossStartX = this.mainCanvas.width / 2 - imageRepository.boss.width;
			this.bossStartY = -imageRepository.boss.height / 2;			
			this.boss.init(this.bossStartX,this.bossStartY,imageRepository.boss.width, imageRepository.boss.height);
			
			this.quadTree = new QuadTree({x:0,y:0,width:this.mainCanvas.width,height:this.mainCanvas.height});
			
			this.playerScore = 0;
			this.playerLives = 3;
			var lives="";
			for(var i = 1; i <= this.playerLives; i++) 
			{
    	        lives += '<img src="imgs/live.jpg" />';
        	}
        	document.getElementById('lives').innerHTML = lives;

			this.laser = new SoundPool(10);
			this.laser.init("laser");
			
			this.explosion = new SoundPool(20);
			this.explosion.init("explosion");
			
			this.backgroundAudio = new Audio("sounds/bonnie1.wav");
			this.backgroundAudio.loop = true;
			this.backgroundAudio.volume = .25;
			this.backgroundAudio.load();
			
			this.gameOverAudio = new Audio("sounds/game_over.wav");
			this.gameOverAudio.loop = true;
			this.gameOverAudio.volume = .75;
			this.gameOverAudio.load();
			this.anim = 0;
			this.checkAudio = window.setInterval(function(){
				checkReadyState()
			},1000);
		}
	};	
	this.spawnWave = function(condition) {
		var height = imageRepository.enemy.height;
		var width = imageRepository.enemy.width;
		var x = 150;
		var y = -height;
		var spacer = y * 1.5;
		var condition = condition || "";
		if(this.level === 1)
		{
			this.nships = 6;
		}
		else if(condition !== 'restart')
		{
			if((this.level - 1) % 2 === 0)
			{
				this.nships += 2;
			}
			else
			{
				this.nships += 3;
			}
		} 
		if(this.nships > 18) 
		{ 
			this.nships = 18;
		}
		for (var i = 1; i <= this.nships; i++) 
		{
			this.enemyPool.get(x,y,0,2);
			x += width + 32;
			if (i % 6 == 0) 
			{
				x = 100;
				y += spacer;
			}
		}	
	}	
	this.start = function() {
		document.getElementById('enter').style.display = "none";
		this.ship.draw();
		this.backgroundAudio.play();
		animate();
	};	
	this.restart = function(condition) {
		var condition = condition || "" ;
		this.gameOverAudio.pause();
		
		document.getElementById('game-over').style.display = "none";
		this.bgContext.clearRect(0, 0, this.bgCanvas.width, this.bgCanvas.height);
		this.bg2Context.clearRect(0, 0, this.bg2Canvas.width, this.bg2Canvas.height);
		this.shipContext.clearRect(0, 0, this.shipCanvas.width, this.shipCanvas.height);
		this.mainContext.clearRect(0, 0, this.mainCanvas.width, this.mainCanvas.height);
		
		this.quadTree.clear();
		
		this.background.init(0,0);
		this.ship.init(this.shipStartX, this.shipStartY, 
		               imageRepository.spaceship.width, imageRepository.spaceship.height);
				
		if(condition !== "continue")
		{
			this.level = 1;			
			this.playerScore = 0;
			this.playerLives = 3;
			for(var i = 1, lives = ""; i <= this.playerLives; i++)
			{
          		lives += '<img src="imgs/live.jpg" />';
        	}
        	document.getElementById('lives').innerHTML = lives;

        	this.enemyPool.init("enemy");
			this.spawnWave('restart');
			this.enemyBulletPool.init("enemyBullet");
	
			this.backgroundAudio.currentTime = 0;
			this.backgroundAudio.play();		
			this.start();
		}
		else
		{
			for(var i = 1, lives = ""; i <= this.playerLives; i++) 
			{
          		lives += '<img src="imgs/live.jpg" />';
        	}
        	document.getElementById('lives').innerHTML = lives;        	
			game.background.draw();
			game.bg2.draw();
			game.ship.draw();

			if(game.level % 6 !== 0) {
				this.enemyPool.init("enemy");
				this.spawnWave('restart');
				this.enemyBulletPool.init("enemyBullet");
			}
			else
			{
				game.boss.init(game.bossStartX,game.bossStartY,imageRepository.boss.width, imageRepository.boss.height);			
			}

			document.getElementById('next-life').style.display = "block";
			setTimeout(function(){
				document.getElementById('next-life').style.display = "none";
			},1500);
        	window.setTimeout(animate, 1500);					
		}
	};
	this.gameOver = function() {
		this.backgroundAudio.pause();
		this.gameOverAudio.currentTime = 0;
		this.gameOverAudio.play();
		document.getElementById('game-over').style.display = "block";
	};
	this.exit = function() {
		this.backgroundAudio.pause();
		this.gameOverAudio.currentTime = 0;
		this.gameOverAudio.play();
		document.getElementById('game-end').style.display = "block";
		window.setInterval(function(){
			game.background.draw();
			game.bg2.draw();
			game.ship.move();
			game.boss.bulletPool.animate();
			game.ship.bulletPool.animate();
		}, 1000 / 60);
	};
}

function checkReadyState() {
	if (game.gameOverAudio.readyState === 4 && game.backgroundAudio.readyState === 4) 
	{
		document.getElementById('loading').style.display = "none";
		document.getElementById('enter').style.display = "block";
		if(ENTER) 
		{
			window.clearInterval(game.checkAudio);
			ENTER = false;
			game.start(); 
		}
	}
}

function SoundPool(maxSize) 
{
	var size = maxSize;
	var pool = [];
	this.pool = pool;
	var currSound = 0;
	this.init = function(object){
		if(object == "laser") 
		{
			for(var i = 0; i < size; i++) 
			{
				laser = new Audio("sounds/laser.wav");
				laser.volume = .12;
				laser.load();
				pool[i] = laser;
			}
		}
		else if(object == "explosion") 
		{
			for(var i = 0; i < size; i++) 
			{
				var explosion = new Audio("sounds/explosion.wav");
				explosion.volume = .08;
				explosion.load();
				pool[i] = explosion;
			}
		}
	};	
	this.get = function() {
		if(pool[currSound].currentTime == 0 || pool[currSound].ended) {
			pool[currSound].play();
		}
		currSound = (currSound + 1) % size;
	};
}

function animate() 
{
	document.getElementById('score').innerHTML = game.playerScore;
	game.quadTree.clear();
	game.quadTree.insert(game.ship);
	game.quadTree.insert(game.ship.bulletPool.getPool());
	if(game.level % 6 === 0)
	{
		game.quadTree.insert(game.boss);
		game.quadTree.insert(game.boss.bulletPool.getPool());		
	}
	else
	{
		game.quadTree.insert(game.enemyPool.getPool());
		game.quadTree.insert(game.enemyBulletPool.getPool());		
	}
	detectCollision();
	
	if ((game.level % 6 !== 0) && (game.enemyPool.getPool().length === 0)) 
	{
		game.level += 1;
		game.spawnWave();
		document.getElementById('level').innerHTML = "<br>" + "LEVEL" + game.level;
		document.getElementById('level-up').style.display = "block";
		setTimeout(function(){
			document.getElementById('level-up').style.display = "none";
		}, 1500);
	}
	if (game.ship.alive) 
	{
		game.anim = window.setTimeout(animate, 1000 / 60);
		game.background.draw();
		game.bg2.draw();
		game.ship.move();
		game.ship.bulletPool.animate();
		if(game.level % 6 === 0)
		{
			if(game.boss.alive)
			{
				game.boss.draw();
				game.boss.bulletPool.animate();
				game.enemyBulletPool.animate();	
			}
		}
		else
		{
		 	game.enemyPool.animate();
			game.enemyBulletPool.animate();	
		}
	}
}

function detectCollision() 
{
	var objects = [];
	game.quadTree.getAllObjects(objects);

	for (var x = 0, len = objects.length; x < len; x++) {		
		game.quadTree.findObjects(obj = [], objects[x]);
		for(y = 0, length = obj.length; y < length; y++) 
		{
			if(objects[x].collidableWith === obj[y].type && (objects[x].x < obj[y].x + obj[y].width &&
			    objects[x].x + objects[x].width > obj[y].x && objects[x].y < obj[y].y + obj[y].height &&
				objects[x].y + objects[x].height > obj[y].y)) 
			{
				objects[x].isColliding = true;
				obj[y].isColliding = true;
			}
		}
	}
};

KEY_CODES = {
  32: 'space',
  37: 'left',
  38: 'up',
  39: 'right',
  40: 'down',
  13: 'enter',
}

KEY_STATUS = {};
for (code in KEY_CODES) 
{
  KEY_STATUS[KEY_CODES[code]] = false;
}
ENTER = false;
document.onkeydown = function(e) {
	var keyCode = (e.keyCode) ? e.keyCode : e.charCode;
    if (KEY_CODES[keyCode]) 
    {
		e.preventDefault();
        KEY_STATUS[KEY_CODES[keyCode]] = true;
    }
    if(keyCode === 13) 
    {
	 	ENTER=true;
    }
}

document.onkeyup = function(e) {
  var keyCode = (e.keyCode) ? e.keyCode : e.charCode;
  if (KEY_CODES[keyCode]) 
  {
    e.preventDefault();
    KEY_STATUS[KEY_CODES[keyCode]] = false;
  }
}

window.requestAnimFrame = (function(){
	return  window.requestAnimationFrame       || 
			window.webkitRequestAnimationFrame || 
			window.mozRequestAnimationFrame    || 
			window.oRequestAnimationFrame      || 
			window.msRequestAnimationFrame     ||
			function(callback, element){
				window.setTimeout(callback, 1000 / 60);
			};
})();
<!DOCTYPE html>
<html>
 
<head>
    <meta charset="utf-8" />
    <title>Flappy Bird</title>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style>
    body {
    width: 100%;
    margin: 0;
	background: #000;
}
 
#container {
    position: relative;
    height: 500px;
    width: 65%;
    background: url('background-day.png');
    overflow: hidden;
}
 
#bird {
    position: absolute;
    background: url('flappy.png');
    height: 42px;
    width: 65px;
    background-size: contain;
    background-repeat: no-repeat;
    top: 20%;
    left: 15%;
}
 
.pole {
    position: absolute;
    height: 130px;
    width: 50px;
    background-color: rgba(255, 0, 0, 0.411);
    right: -50px;
}
 
#pole_1 {
    top: 0;
}
 
#pole_2 {
    bottom: 0;
}
 
#score_div {
    
    font-size: 25px;
}
 
#restart_btn {
    position: absolute;
    top: 0;
    width: 72%;
    padding: 20px;
    background-color: #2c1717;
    color: white;
    overflow: hidden;
    font-size: 35px;
    border:none;
    margin-left:-35%;
    height: 500px;
    display: none;
    opacity: .8;
}
#score{
    /* height:100px;
    width: 100px;
    padding: 30px;
    font-size: 25px;
    margin-top:20px;
    margin-left:-30px; */
    font-weight: bold;

}
    </style>
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
</head>
 
<body>
<audio id="pou" autoplay="autoplay" loop="loop">
<source src="pou.mp3" type="audio/mpeg">
</audio>
<center>

    <div id="container" class="mt-6">
        <div id="bird"></div>
        <div id="pole_1" class="pole"></div>
        <div id="pole_2" class="pole"></div>
    <div id="score_div">
    <div id="score" class="btn btn-light fas fa-coins"><i class="fas fa-coins"></i>
    0
</div>

        <!-- <p><b></b><span id="speed"><small>10</small></span></p> -->
    </div> 

    </div>
    <button id="restart_btn"> <h1>Game Over</h1> <br>
        <h5 class="btn btn-warning">Restart</h5>
    </button>
    </center>

    <script src="jquery.min.js"></script>
    <script> 
    $(function (){
 
    //saving dom objects to variables
    var container = $('#container');
    var bird = $('#bird');
    var pole = $('.pole');
    var pole_1 = $('#pole_1');
    var pole_2 = $('#pole_2');
    var score = $('#score');
    var speed_span = $('#speed');
    var restart_btn = $('#restart_btn');
 
    //saving some initial setup
    var container_width = parseInt(container.width());
    var container_height = parseInt(container.height());
    var pole_initial_position = parseInt(pole.css('right'));
    var pole_initial_height = parseInt(pole.css('height'));
    var bird_left = parseInt(bird.css('left'));
    var bird_height = parseInt(bird.height());
    var speed = 30;
 
    //some other declarations
    var go_up = false;
    var score_updated = false;
    var game_over = false;
    var pou = false;
 
 
    var the_game = setInterval(function () {
 
        if (collision(bird, pole_1) || collision(bird, pole_2) || parseInt(bird.css('top')) <= 0 || parseInt(bird.css('top')) > container_height - bird_height) {
 
            stop_the_game();
 
        } else {
 
            var pole_current_position = parseInt(pole.css('right'));
 
            //update the score when the poles have passed the bird successfully
            if (pole_current_position > container_width - bird_left) {
                if (score_updated === false) {
                    score.text(parseInt(score.text()) + 1);
                    score_updated = true;
                }
            }
 
            //check whether the poles went out of the container
            if (pole_current_position > container_width) {
                var new_height = parseInt(Math.random() * 120);
 
                //change the pole's height
                pole_1.css('height', pole_initial_height + new_height);
                pole_2.css('height', pole_initial_height - new_height);
 
                //increase speed
                speed = speed + 1;
                speed_span.text(speed);
 
                score_updated = false;
 
                pole_current_position = pole_initial_position;
            }
 
            //move the poles
            pole.css('right', pole_current_position + speed);
 
            if (go_up === false) {
                go_down();
            }
        }
 
    }, 30);
 
    $(document).on('keydown', function (e) {
        var key = e.keyCode;
        if (key === 32 && go_up === false && game_over === false && pou === false) {
            go_up = setInterval(up, 50);
        }
    });
 
    $(document).on('keyup', function (e) {
        var key = e.keyCode;
        if (key === 32) {
            clearInterval(go_up);
            go_up = false;
        }
    });
 
 
    function go_down() {
        bird.css('top', parseInt(bird.css('top')) + 7);
    }
 
    function up() {
        bird.css('top', parseInt(bird.css('top')) -7);
    }
 
    function stop_the_game() {
        clearInterval(the_game);
        game_over = true;
        pou = true;
        restart_btn.slideDown();
    }
    function game_over() {
        clearInterval(the_game);
        game_over = true;
        pou = true;
        restart_btn.slideDown();
    }
 
    restart_btn.click(function () {
        location.reload();
    });
    

 
    function collision($div1, $div2) {
        var x1 = $div1.offset().left;
        var y1 = $div1.offset().top;
        var h1 = $div1.outerHeight(true);
        var w1 = $div1.outerWidth(true);
        var b1 = y1 + h1;
        var r1 = x1 + w1;
        var x2 = $div2.offset().left;
        var y2 = $div2.offset().top;
        var h2 = $div2.outerHeight(true);
        var w2 = $div2.outerWidth(true);
        var b2 = y2 + h2;
        var r2 = x2 + w2;
 
        if (b1 < y2 || y1 > b2 || r1 < x2 || x1 > r2) return false;
        return true;
    }
});
    </script>
 
</body>
</html>
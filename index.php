<?php
	require_once('phpQuery_asjdni2u3.php');
//	require_once('db_kpsd9u3eh.php');

	// $db = new MysqliDb (Array (
 //                'host' => 'localhost',
 //                'username' => 'sn', 
 //                'password' => 'xxxxxxxx',
 //                'db'=> 'sn'));

	// $sites = $db->get('category_pages');
	$categories = 	array('General', 'Politcs', 'Tech');
	$sites 		=   array( 
							array(  'name'=>'Yahoo News', 
								    'url'=>'https://www.yahoo.com/news/', 
								    'categories' => array( 
								    					'General' => array('url'=>'https://www.yahoo.com/news/', 'title'=>'h3','content'=>'div div div p','link'=>'h3 a','list'=>'body #render-target-default #YDC-Stream ul li'),
								    					'Politcs' => array('url'=>'https://www.yahoo.com/news/politics/', 'title'=>'h3','content'=>'div div div p','link'=>'h3 a','list'=>'body #render-target-default #YDC-Stream > ul > li'),
								    					'Tech' => array('url'=>'https://www.yahoo.com/tech/', 'title'=>'.tile-container h3 span','content'=>'','link'=>'h3 a','list'=>'body div.tech div.js-stream-content'),
								    				)
							),
					);

	//get first site from any category
	$initsites = array();
	
	foreach ($sites as $key2 => $value2) {
		if(isset($value2['categories'][$value])){
			$initsites[] = array('data'=>$value2['categories'][$value] );
		}
		else{
			
		}
		
	}
	

	$pq = phpQuery::newDocumentFileHTML($sites[0]['categories']['Politcs']['url']);

	$rows = pq($sites[0]['categories']['Politcs']['list'],$pq);
	$arr = array();
	foreach ($rows as $row){

		$title =  pq($row)->find($sites[0]['categories']['Politcs']['title'])->text();
		$content =  pq($row)->find($sites[0]['categories']['Politcs']['content'])->text();
		$link =  pq($row)->find($sites[0]['categories']['Politcs']['link'])->attr('href');

		$title = str_replace("\n", "", $title);
		$title = str_replace("\r", "", $title);

		$content = str_replace("\n", "", $content);
		$content = str_replace("\r", "", $content);

		$arr[] = array($title, $content, $link, $sites[0]['name'], $sites[0]['categories']['Politcs']['url'], $categories[1]);
	}

	
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Simple News</title>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
	<link href="https://fonts.googleapis.com/css?family=Comfortaa:400,700" rel="stylesheet" />
	<link href="jquery.mCustomScrollbar.min.css" rel="stylesheet" />
	<style type="text/css">
		body{
			background: #ebeae9;;
		}
		html, body {
		    margin: 0;
		    padding: 0;
		    width: 100%;
		    height: 100%;
		    display: table;
		    font-family: 'Comfortaa', cursive;
		    overflow: hidden;
		}
		.container {
		    display: table-cell;
		    text-align: center;
		    vertical-align: middle;
		    padding: 0 10%;
		}
		h1.title{
			font-size: 18px;
		    text-align: center;
		    color: #454545;
		}
		p.content{
			margin: 5px 0;
		    font-size: 13px;
		    color: #626262;
		    text-align: justify;
		}
		p.info{
			text-align: right;
			font-size: 12px;
		    color: #c7c7c7;
		}
		p.info a{
			font-size: 12px;
		    color: #c7c7c7;
		    text-decoration: none;
		}
		.top-arrow {
		    background: url(up.png);
		    height: 20px;
		    width: 100px;
		    margin: 0 auto;
		    cursor: pointer;
		    background-repeat: no-repeat;
		    background-size: contain;
		    opacity: 0.5;
		}
		.bottom-arrow {
		    background: url(down.png);
		    height: 20px;
		    width: 100px;
		    margin: 0 auto;
		    cursor: pointer;
		    background-repeat: no-repeat;
		    background-size: contain;
		    opacity: 0.5;
		}
		footer{
			position: absolute;
		    bottom: 3px;
		    right: 5px;
		    font-size: 12px;
		    color: #7b7b7a;
		}
		.header{
			width: 100%;
		    position: absolute;
		    top: 0;
		    left: 0;
		    padding: 5px;
        	font-size: 12px;
        	text-align: center;
		}
		.header select{
			padding: 10px;
		}
		a{
			color: inherit;
    		text-decoration: none;
		}
		.sound-control{
			height: 20px;
		    width: 20px;
		    position: absolute;
		    top: 10px;
		    right: 20px;
		    background-image: url(mute.png);
		    background-repeat: no-repeat;
		    background-size: contain;
		    padding: 0;
		    margin: 0;
		    cursor: pointer;
		}

		<?php include_once('animate.php'); ?>			
	</style>
</head>
<body>
	<div class="header">
		<select style="width: 200px">
			<option value="-1">Caterory</option>
			<?php foreach ($categories as $key => $value) {
				echo "<option value='".$key."'>".$value."</option>";
			} ?>
		</select>

		<select style="width: 200px">
			<option value="-1">Sites</option>
			<?php foreach ($sites as $key => $value) {
				echo "<option value='".$key."'>".$value['name']."</option>";
			} ?>
		</select>

		<dir class="sound-control"></dir>	

		<div class="logo"><img src="logo.png" /></div>
		
	</div>
	<div class="container">
		<div class="top-arrow"></div>
		<div class="animated zoomInDown" style="max-height: 60%; overflow: hidden;">
			<h1 class="title"><?php echo $arr[0][0]; ?></h1>
			<p class="content"><?php echo $arr[0][1]; ?></p>
			<p class="info"><a href="<?php echo $arr[0][4]; ?>"><?php echo $arr[0][3] . ' - ' . $arr[0][5]; ?></a> | <a href="<?php echo $arr[0][2]; ?>">More about post</a></p>
		</div>
		<div class="bottom-arrow"></div>
	</div>	
	<footer>
		<span>Thanks to <a href="https://daneden.github.io/animate.css/">Animate.css</a> & speechSynthesis</span>
	</footer>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/materialize/0.95.1/js/materialize.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
	<script src="jquery.mCustomScrollbar.concat.min.js"></script>

	<script type="text/javascript">


		window.spcancel = false;
		window.mute = false;

		var arr = [
					<?php foreach ($arr as $key => $value) {
							echo '["'.str_replace('"', "'", $value[0]).'","'.str_replace('"', "'",$value[1]).'","'.$value[2].'","'.str_replace('"', "'",$value[3]).'","'.$value[4].'","'.$value[5].'"],';
					} ?>
				  ] ;
		var i = 0;		  

		$(document).ready(function(){

			$('.sound-control').click(function(){
				window.mute = !window.mute;
				if(window.mute){
					stopspeaking();
					$(this).css('background-image','url(sound.png)');
				}
				else{
					startspeaking();
					$(this).css('background-image','url(mute.png)');
				}
			});

			$('select').select2();

			$(".animated").mCustomScrollbar();

			if(!window.mute){
				var utterance = new SpeechSynthesisUtterance( arr[0][0] + ". " +  arr[0][1]);

				//pass it into the chunking function to have it played out.
				//you can set the max number of characters by changing the chunkLength property below.
				//a callback function can also be added that will fire once the entire text has been spoken.
				speechUtteranceChunker(utterance, {
				    chunkLength: 120
				}, function () {
				    //some code to execute when done
				    console.log('done');
				    nextPost();
				});
			}

			$(document).keydown(function(e) {
		    switch(e.which) {
		        case 37: // left
			        prevPost();	
			        break;

		        case 38: // up
			        prevPost();	
			        break;

		        case 39: // right
			        nextPost();
			        break;

		        case 40: // down
			        nextPost();
			        break;

		        default: return; // exit this handler for other keys
		    }
		    e.preventDefault(); // prevent the default action (scroll / move caret)
		});

			$('.bottom-arrow').click(function(){
				nextPost();
			});

			$('.top-arrow').click(function(){	
				prevPost();			
			});
		});

		function nextPost(){
			if(i < arr.length){
				speechSynthesis.cancel();
				var anm = $('.container .animated');
				anm.toggleClass('zoomInDown zoomOutDown');
				i++;
				
				//$('.container .animated .info').html(arr[i]);
				setTimeout(function(){ 
					$('.container .animated .title').html(arr[i][0]);
					$('.container .animated .content').html(arr[i][1]);
					//anm.toggleClass('zoomOutDown zoomInDown'); 
					if(anm.hasClass('zoomInUp')){
						anm.toggleClass('zoomOutDown zoomInUp'); 
					}
					else{
						anm.toggleClass('zoomOutDown zoomInDown'); 
					}

					stopspeaking();
					var utterance = new SpeechSynthesisUtterance( arr[i][0] + ". " +  arr[i][1]);
					speechUtteranceChunker(utterance, {
					    chunkLength: 120
					}, function () {
					    //some code to execute when done
					    console.log('done');
					    nextPost();
					});		
				}, 1000);
				
			}
		}

		function prevPost(){
			if(i > 0){

				speechSynthesis.cancel();
				var anm = $('.container .animated');
				anm.toggleClass('zoomInDown zoomOutUp');
				i--;
				
				//$('.container .animated .info').html(arr[i]);
				setTimeout(function(){ 
					$('.container .animated .title').html(arr[i][0]);
					$('.container .animated .content').html(arr[i][1]);
					if(anm.hasClass('zoomInUp')){
						anm.toggleClass('zoomOutUp zoomInDown'); 
					}
					else{
						anm.toggleClass('zoomOutUp zoomInUp'); 
					}
					stopspeaking();
					console.log(arr[i][0] + ". " +  arr[i][1]);
					var utterance = new SpeechSynthesisUtterance( arr[i][0] + ". " +  arr[i][1]);
					speechUtteranceChunker(utterance, {
					    chunkLength: 120
					}, function () {
					    //some code to execute when done
					    console.log('done');
					    nextPost();
					});			
					
				}, 1000);
			}
		}

		var speechUtteranceChunker = function (utt, settings, callback) {
		    settings = settings || {};
		    var newUtt;
		    var txt = (settings && settings.offset !== undefined ? utt.text.substring(settings.offset) : utt.text);
		    if (utt.voice && utt.voice.voiceURI === 'native') { // Not part of the spec
		        newUtt = utt;
		        newUtt.text = txt;
		        newUtt.addEventListener('end', function () {
		            if (speechUtteranceChunker.cancel || window.spcancel) {
		                speechUtteranceChunker.cancel = false;
		                window.spcancel = false;
		            }
		            if (callback !== undefined) {
		                callback();
		            }
		        });
		    }
		    else {
		        var chunkLength = (settings && settings.chunkLength) || 160;
		        var pattRegex = new RegExp('^[\\s\\S]{' + Math.floor(chunkLength / 2) + ',' + chunkLength + '}[.!?,]{1}|^[\\s\\S]{1,' + chunkLength + '}$|^[\\s\\S]{1,' + chunkLength + '} ');
		        var chunkArr = txt.match(pattRegex);

		        if (chunkArr[0] === undefined || chunkArr[0].length <= 2) {
		            //call once all text has been spoken...
		            if (callback !== undefined) {
		                callback();
		            }
		            return;
		        }
		        var chunk = chunkArr[0];
		        newUtt = new SpeechSynthesisUtterance(chunk);
		        var x;
		        for (x in utt) {
		            if (utt.hasOwnProperty(x) && x !== 'text') {
		                newUtt[x] = utt[x];
		            }
		        }
		        newUtt.addEventListener('end', function () {
		            if (speechUtteranceChunker.cancel || window.spcancel) {
		                speechUtteranceChunker.cancel = false;
		                window.spcancel = false;
		                return;
		            }
		            settings.offset = settings.offset || 0;
		            settings.offset += chunk.length - 1;
		            speechUtteranceChunker(utt, settings, callback);
		        });
		    }

		    if (settings.modifier) {
		        settings.modifier(newUtt);
		    }
		    console.log(newUtt); //IMPORTANT!! Do not remove: Logging the object out fixes some onend firing issues.
		    //placing the speak invocation inside a callback fixes ordering and onend issues.
		    setTimeout(function () {
		        speechSynthesis.speak(newUtt);
		    }, 0);
		};

		var stopspeaking = function(){
			window.spcancel = true;
			speechSynthesis.cancel();
		}

		var startspeaking = function(){
			window.spcancel = false;
			var utterance = new SpeechSynthesisUtterance( arr[i][0] + ". " +  arr[i][1]);
			speechUtteranceChunker(utterance, {
			    chunkLength: 120
			}, function () {
			    //some code to execute when done
			    console.log('done');
			    nextPost();
			});		
		}
		
	</script>
</body>
</html>
<?php require 'libs/phpDataMapper/Base.php'; 
	class DataModel extends phpDataMapper_Base{
		protected $_datasource = "openweatherinfo";

		public $id = array('type'=> 'int', 'primary' => true, "serial" => true);
		public $created = array('type'=> 'text', 'required'=>true);
		public $city = array('type' => 'text', 'required' => true);
		public $weather = array('type' => 'text', 'required' => true);	
		public $temperature = array('type' => 'float', 'required' => true);
		public $windspeed = array('type' => 'float', 'required' => true);
		public $winddirection = array('type' => 'float', 'required' => true);
	} 
	$weatherAdapter = new phpDataMapper_Adapter_Mysql ('mysql.jffng.com', 'weather_cron', 'jffng_itp', 'goblue1234');
	$weatherMapper = new DataModel($weatherAdapter);
	$weatherMapper->migrate();

	$weather = $weatherMapper->all();

	foreach($weather as $cities){
			if ($cities->city == "Los Angeles"){
				$Lmod++;
				if ($Lmod % 6 == 0) { 
				$LAX[$L][0] = $cities->temperature;
				$LAX[$L][1] = $cities->windspeed;
				$LAX[$L][2] = $cities->winddirection;
				$L++;
			}
		}
			if ($cities->city == "New York"){ 
				$Nmod++;
				if ($Nmod % 6 == 0) {
				$NYC[$N][0] = $cities->temperature;
				$NYC[$N][1] = $cities->windspeed;
				$NYC[$N][2] = $cities->winddirection;
				$N++;
				}
			}
			if ($cities->city == "Chicago"){
				$Cmod++;
				if ($Cmod % 6 == 0) {
				$CHI[$C][0] = $cities->temperature;
				$CHI[$C][1] = $cities->windspeed;
				$CHI[$C][2] = $cities->winddirection;
				$C++;
				} 
			}
			// if ($cities->city == "San Francisco"){ 
			// 	$SFO[$S][0] = $cities->temperature;
			// 	$SFO[$S][1] = $cities->windspeed;
			// 	$SFO[$S][2] = $cities->winddirection;
			// 	$S++;
			// }
			if ($cities->city == "Boston"){ 
				$Bmod++;
				if($Bmod % 6 == 0){
				$BOS[$B][0] = $cities->temperature;
				$BOS[$B][1] = $cities->windspeed;
				$BOS[$B][2] = $cities->winddirection;
				$B++;
				}
			}
			// if ($cities->city == "Tokyo"){ 
			// 	$TKO[$T][0] = $cities->temperature;
			// 	$TKO[$T][1] = $cities->windspeed;
			// 	$TKO[$T][2] = $cities->winddirection;
			// 	$T++;
			// }
	}
?>

<html>
	<head>
	<style>
			body {
				font-family: Monospace;
				color: #f0f0f0;
				background-color: #000000;
				margin: 0px;
				overflow: hidden;
			}
		</style>
	</head>
		<body>
			<script type="text/javascript" src="libs/three.min.js"></script>
			<script type="text/javascript">
			var LA = [];
				for (var i = 0; i < <?echo($L)?>; i++) {
					LA[i] = new Array(3);
				};
					<?php 
						for ($i = 1; $i < $L; $i++){
							$temp = $LAX[$i][0];
							$wind = $LAX[$i][1];
							$winddir = $LAX[$i][2];
							$runningtempL = $runningtempL + $LAX[$i][0];
							$runningwindL = $runningwindL + $LAX[$i][1];
					?> 	
						LA[ <? echo($i) ?> ][0] = 
							<? echo($temp) ?>;
						LA[ <? echo($i) ?> ][1] = 
							<? echo($wind) ?>;
						LA[ <? echo($i) ?> ][2] = 
							<? echo($winddir) ?>;
					<?
					}
					$tempavgL = $runningtempL / $L;
					$windavgL = $runningwindL / $L;
					?>
				var NYC = [];
				for (var i = 0; i < <?echo($N)?>; i++) {
					NYC[i] = new Array(3);
				};

				<?php 
					for ($a = 1; $a < $N; $a++){
						$temp = $NYC[$a][0];
						$wind = $NYC[$a][1];
						$winddir = $NYC[$a][2];
						$runningtempN = $runningtempN + $NYC[$a][0];
						$runningwindN = $runningwindN + $NYC[$a][1];
				?> 	
					NYC[ <? echo($a) ?> ][0] = <? echo($temp) ?>;
					NYC[ <? echo($a) ?> ][1] = <? echo($wind) ?>;
					NYC[ <? echo($a) ?> ][2] = <? echo($winddir) ?>;
				<?
					}
					$tempavgN = $runningtempN / $N;
					$windavgN = $runningwindN / $N;
				?>					

				var CHI = [];
				for (var i = 0; i < <?echo($C)?>; i++) {
					CHI[i] = new Array(3);
				};
					<?php 
						for ($a = 1; $a < $C; $a++){
							$temp = $CHI[$a][0];
							$wind = $CHI[$a][1];
							$winddir = $CHI[$a][2];
							$runningtempC = $runningtempC + $CHI[$a][0];
							$runningwindC = $runningwindC + $CHI[$a][1];
					?> 	
						CHI[ <? echo($a) ?> ][0] = 
							<? echo($temp) ?>;
						CHI[ <? echo($a) ?> ][1] = 
							<? echo($wind) ?>;
						CHI[ <? echo($a) ?> ][2] = 
							<? echo($winddir) ?>;
					<?
					}
					$tempavgC = $runningtempC / $C;
					$windavgC = $runningwindC / $C;
					?>

				var BOS = [];
				for (var i = 0; i < <?echo($B)?>; i++) {
					BOS[i] = new Array(3);
				};
					<?php 
						for ($a = 1; $a < $B; $a++){
							$temp = $BOS[$a][0];
							$wind = $BOS[$a][1];
							$winddir = $BOS[$a][2];
							$runningtempB = $runningtempB + $BOS[$a][0];
							$runningwindB = $runningwindB + $BOS[$a][1];
					?> 	
						BOS[ <? echo($a) ?> ][0] = 
							<? echo($temp) ?>;
						BOS[ <? echo($a) ?> ][1] = 
							<? echo($wind) ?>;
						BOS[ <? echo($a) ?> ][2] = 
							<? echo($winddir) ?>;
					<?
					}
					$tempavgB = $runningtempB / $B;
					$windavgB = $runningwindB / $B;					
					?>
			</script>
			<script type="text/javascript">
				// var SFO = [];
				// for (var i = 0; i < <?echo($S)?>; i++) {
				// 	SFO[i] = new Array(3);
				// };
				// 	<?php 
				// 		for ($a = 1; $a < $S; $a++){
				// 			$temp = $SFO[$a][0];
				// 			$wind = $SFO[$a][1];
				// 			$winddir = $SFO[$a][2];
				// 	?> 	
				// 		SFO[ <? echo($a) ?> ][0] = 
				// 			<? echo($temp) ?>;
				// 		SFO[ <? echo($a) ?> ][1] = 
				// 			<? echo($wind) ?>;
				// 		SFO[ <? echo($a) ?> ][2] = 
				// 			<? echo($winddir) ?>;
				// 	<?
				// 	}
				// 	?>

				var camera, scene, renderer;

				var bt = 1, ct = 1, nt = 1, lt = 1;

				var mouseX = 0, mouseY = 0,

				windowHalfX = window.innerWidth / 2,
				windowHalfY = window.innerHeight / 2;
				var chilines, boslines, lalines, nyclines;

				init();
				animate();

				function addLA () {
					lt++;
					if(lt % 2 === 0)
					{
						var geometry = new THREE.Geometry();
						var geometryavg = new THREE.Geometry();
						// var numPoints = <?echo($L)*100?>;
						// var splineArray = [];
						// for (var i = 0; i < <?echo($L)?>; i++) {
						// 	splineArray[i] = new Array(3);
						// };


						for(var t = 2; t < <?echo($L)?>; t++){
							geometry.vertices.push( new THREE.Vector3( LA[t][1]*25, LA[t][0]*10, -t*2 ) );
							geometryavg.vertices.push( new THREE.Vector3( <? echo($windavgL); ?> * 25, <?echo($tempavgL); ?> * 10, -t*2));
							// splineArray[t][0] = LA[t][0]*10;
							// splineArray[t][1] = LA[t][1]*50;
							// splineArray[t][2] = -t;
						}

						// spline.initFromArray(splineArray);

						// var spline = new THREE.Spline();
						// spline.initFromArray(splineArray);
						// var n_sub = 6;
						// var index;
						// console.log(spline);

						// for(var i = 0; i < spline.length*6; i++){
						// 	index = i / (spline.length * 6);
						// 	point = spline.getPoint(index);
						// 	geometry.vertices.push(new THREE.Vector3(point.x, point.y, point.z));
						// }

						var material = new THREE.LineBasicMaterial({ color: 0xffff99 } );
						var avgmaterial = new THREE.LineBasicMaterial({ color: 0xffffff });

						var line = new THREE.Line( geometry, material );
						var lineavg = new THREE.Line( geometryavg, avgmaterial );
						lalines.add(line);
						lalines.add(lineavg);
						scene.add(lalines);
					}
					else{
						scene.remove(lalines);
						animate();
					}
				}

				function addNYC () {
					nt++;
					if(nt % 2 === 0){
						// NYC
						var geometry2 = new THREE.Geometry(); 
						var geometryavg2 = new THREE.Geometry();						
						for(var t = 1; t < <?echo($N)?>; t++){
							geometry2.vertices.push( new THREE.Vector3( NYC[t][1]*25, NYC[t][0]*10, -t*2 ) );
							geometryavg2.vertices.push( new THREE.Vector3( <? echo($windavgN); ?> * 25, <?echo($tempavgN); ?> * 10, -t*2));
						}
						var material2 = new THREE.LineBasicMaterial({ color: 0xff9933 } );
						var avgmaterial2 = new THREE.LineBasicMaterial({ color: 0xffffff });
						var line2 = new THREE.Line( geometry2, material2 );
						var line2avg = new THREE.Line( geometryavg2, avgmaterial2 );
						nyclines.add(line2);
						nyclines.add(line2avg);
						scene.add(nyclines);
					}
					else{
						scene.remove(nyclines);
						animate();
					}
				}

				function addCHI () {
						// CHICAGO
					ct++
					if (ct % 2 === 0)
					{
						var geometry3 = new THREE.Geometry(); 
						var geometryavg3 = new THREE.Geometry();						
						for(var t = 1; t < <?echo($C)?>; t++){
							geometry3.vertices.push( new THREE.Vector3( CHI[t][1]*25, CHI[t][0]*10, -t*2 ) );
							geometryavg3.vertices.push( new THREE.Vector3( <? echo($windavgC); ?> * 25, <?echo($tempavgC); ?> * 10, -t*2));
						}
						var material3 = new THREE.LineBasicMaterial({ color: 0x99ccff } );
						var avgmaterial3 = new THREE.LineBasicMaterial({ color: 0xffffff });
						var line3 = new THREE.Line( geometry3, material3 );
						var line3avg = new THREE.Line( geometryavg3, avgmaterial3 );
						chilines.add(line3);
						chilines.add(line3avg);
						scene.add(chilines);
					}
					else{
						scene.remove(chilines);
						animate();
					}
				}

				function addBOS () {
					bt++; 
					if (bt % 2 === 0)
					{
							var geometry5 = new THREE.Geometry(); 
							var geometryavg5 = new THREE.Geometry();						
							for(var t = 3; t < <?echo($B)?>; t++){
								geometry5.vertices.push( new THREE.Vector3( BOS[t][1]*25, BOS[t][0]*10, -t*2 ) );
								geometryavg5.vertices.push( new THREE.Vector3( <? echo($windavgB); ?> * 25, <?echo($tempavgB); ?> * 10, -t*2 ));
							}
							var material5 = new THREE.LineBasicMaterial({ color: 0xff0033 } );
							var avgmaterial5 = new THREE.LineBasicMaterial({ color: 0xffffff });
							var line5 = new THREE.Line( geometry5, material5 );
							var line5avg = new THREE.Line( geometryavg5, avgmaterial5 );
							boslines.add(line5);
							boslines.add(line5avg);
							scene.add(boslines);
						}
					else
						{
							scene.remove(boslines);
							animate();
						}
				}

				function init () {
						container = document.createElement('div');
						document.body.appendChild(container);

						var info = document.createElement('div');
						info.style.position = 'absolute';
						info.style.top = '10px';
						info.style.left = '10px';
						info.style.width = '100%';
						info.style.textAlign = 'left';

						info.innerHTML = 'Web + 3D Programming Final Project: <br/> Weather Visualization across cities';

						info.innerHTML += '<br/> <br/> LA: <input id="LA" type="checkbox" onchange="addLA()" />';

						info.innerHTML += '<br/> NYC: <input id="NYC" type="checkbox" onchange="addNYC()"/>';

						info.innerHTML += '<br/> CHI: <input id="CHI" type="checkbox" onchange="addCHI()"/>';

						info.innerHTML += '<br/> BOS: <input id="BOS" type="checkbox" onchange="addBOS()"/>';			

						container.appendChild(info);

						renderer = new THREE.WebGLRenderer();
						renderer.setSize( window.innerWidth, window.innerHeight );

						container.appendChild( renderer.domElement );

						camera = new THREE.PerspectiveCamera( 45, window.innerWidth / window.innerHeight, 1, 10000 );
						camera.position.z = 150;
						camera.position.y = -100;
						camera.position.x = -100;
						camera.lookAt(new THREE.Vector3( <? echo($windavgL); ?> * 25, <?echo($tempavgL); ?> * 10,<?echo(-$L/2)?>));
						chilines = new THREE.Object3D();
						nyclines = new THREE.Object3D();
						boslines = new THREE.Object3D();
						lalines = new THREE.Object3D();

						scene = new THREE.Scene();

						// var geometry3 = new THREE.Geometry();
						// for(var t = 1; t < <?echo($C)?>; t++){
						// 	geometry3.vertices.push( new THREE.Vector3( CHI[t][0]*10, CHI[t][1]*50, CHI[t][2] ) );
						// }
						// var material3 = new THREE.LineBasicMaterial({ color: 0x99ccff } );
						// var line3 = new THREE.Line( geometry3, material3 );
						// scene.add(line3);						

						// var geometry4 = new THREE.Geometry();
						// for(var t = 1; t < <?echo($S)?>; t++){
						// 	geometry4.vertices.push( new THREE.Vector3( SFO[t][0]*10, SFO[t][1]*50, SFO[t][2] ) );
						// }
						// var material4 = new THREE.LineBasicMaterial({ color: 0xccff99 } );
						// var line4 = new THREE.Line( geometry4, material4 );
						// scene.add(line4);

						// var geometry5 = new THREE.Geometry();
						// for(var t = 1; t < <?echo($B)?>; t++){
						// 	geometry5.vertices.push( new THREE.Vector3( BOS[t][0]*10, BOS[t][1]*50, BOS[t][2] ) );
						// }
						// var material5 = new THREE.LineBasicMaterial({ color: 0xff0033 } );
						// var line5 = new THREE.Line( geometry5, material5 );
						// scene.add(line5);

						document.addEventListener( 'mousemove', onDocumentMouseMove, false );
						document.addEventListener( 'touchstart', onDocumentTouchStart, false );
						document.addEventListener( 'touchmove', onDocumentTouchMove, false );
				}

				function render () {
					camera.position.x += ( mouseX - camera.position.x ) * .05;
					camera.position.y += ( - mouseY + 200 - camera.position.y ) * .05;

					camera.lookAt( scene.position );

					renderer.render(scene,camera);
				}

				function animate () {
					requestAnimationFrame( animate );
					render();
				}

				function onDocumentMouseMove( event ) {

					mouseX = event.clientX - windowHalfX;
					mouseY = event.clientY - windowHalfY;
				}

				function onDocumentTouchStart( event ) {

					if ( event.touches.length > 1 ) {

						event.preventDefault();

						mouseX = event.touches[ 0 ].pageX - windowHalfX;
						mouseY = event.touches[ 0 ].pageY - windowHalfY;
					}
				}

				function onDocumentTouchMove( event ) {

					if ( event.touches.length == 1 ) {

						event.preventDefault();

						mouseX = event.touches[ 0 ].pageX - windowHalfX;
						mouseY = event.touches[ 0 ].pageY - windowHalfY;
					}

				}
			
					</script>
		</body>
</html>

	


















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

	$weather = $weatherMapper->query("SELECT * FROM openweatherinfo WHERE created >" . (time() - (14 * 24 * 60 * 60)));

	// $weather = $weatherMapper->query("SELECT * FROM openweatherinfo WHERE created < 1385856000");

	foreach($weather as $cities){
			if ($cities->city == "Los Angeles"){
				// $Lmod++;
				// if ($Lmod % 6 == 0) { 
				$LAX[$L][0] = $cities->temperature;
				$LAX[$L][1] = $cities->windspeed;
				$LAX[$L][2] = $cities->winddirection;
				$L++;
			// }
		}
			if ($cities->city == "New York"){ 
				// $Nmod++;
				// if ($Nmod % 6 == 0) {
				$NYC[$N][0] = $cities->temperature;
				$NYC[$N][1] = $cities->windspeed;
				$NYC[$N][2] = $cities->winddirection;
				$N++;
				// }
			}
			if ($cities->city == "Chicago"){
				// $Cmod++;
				// if ($Cmod % 6 == 0) {
				$CHI[$C][0] = $cities->temperature;
				$CHI[$C][1] = $cities->windspeed;
				$CHI[$C][2] = $cities->winddirection;
				$C++;
				// } 
			}
			// if ($cities->city == "San Francisco"){ 
			// 	$SFO[$S][0] = $cities->temperature;
			// 	$SFO[$S][1] = $cities->windspeed;
			// 	$SFO[$S][2] = $cities->winddirection;
			// 	$S++;
			// }
			if ($cities->city == "Boston"){ 
				// $Bmod++;
				// if($Bmod % 6 == 0){
				$BOS[$B][0] = $cities->temperature;
				$BOS[$B][1] = $cities->windspeed;
				$BOS[$B][2] = $cities->winddirection;
				$B++;
				// }
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
						// var geometryavg = new THREE.Geometry();

						for(var t = 2; t < <?echo($L)?>; t++){
							geometry.vertices.push( new THREE.Vector3(0, LA[t][0]*10, -t ));							
							// geometryavg.vertices.push( new THREE.Vector3( <? echo($windavgL); ?> * 25, <?echo($tempavgL); ?> * 10, -t*2));
						}
						console.log(geometry.vertices, "length", geometry.vertices.length );

						for ( var i = 2; i < <? echo($L) ?>; i++) {
							geometry.vertices.push( new THREE.Vector3 ( LA[i][1]*5, LA[i][0]*10, -i ));
						}
						console.log(geometry.vertices, "length", geometry.vertices.length );

						for (var f = 0; f < <?echo($L)?> - 6 ; f++) {						
							geometry.faces.push( new THREE.Face3( f, f+<?echo($L)?>, f+1) );
							geometry.faces.push( new THREE.Face3( f+<?echo($L)?>, f+<?echo($L)?>+1, f+1) );
						}

						geometry.computeFaceNormals();

						var material = new THREE.MeshNormalMaterial( { color: 0xffff99 } );
						var mesh = new THREE.Mesh( geometry, material );
						lamesh.add(mesh);
						scene.add(lamesh);
					}
					else{
						scene.remove(lamesh);
						animate();
					}
				}

				function addNYC () {
					nt++;
					if(nt % 2 === 0){
						// NYC
						var geometry = new THREE.Geometry();

						for(var t = 2; t < <?echo($N)?>; t++){
							geometry.vertices.push( new THREE.Vector3(-50, NYC[t][0]*10, -t))							
						}
						console.log(geometry.vertices, "length", geometry.vertices.length );

						for ( var i = 2; i < <? echo($N) ?>; i++) {
							geometry.vertices.push( new THREE.Vector3 ( NYC[i][1]*5-50, NYC[i][0]*10, -i) );
						}
						console.log(geometry.vertices, "length", geometry.vertices.length );

						for (var f = 0; f < <?echo($N)?> - 6 ; f++) {						
							geometry.faces.push( new THREE.Face3( f, f+<?echo($N)?>, f+1) );
							geometry.faces.push( new THREE.Face3( f+<?echo($N)?>, f+<?echo($N)?>+1, f+1) );
						}

						geometry.computeFaceNormals();

						var material = new THREE.MeshNormalMaterial( { color: 0xff9933 } );
						var mesh = new THREE.Mesh( geometry, material );
						nycmesh.add(mesh);
						scene.add(nycmesh);
					}
					else{
						scene.remove(nycmesh);
						animate();
					}
				}

				function addCHI () {
						// CHICAGO
					ct++
					if (ct % 2 === 0)
					{
						var geometry = new THREE.Geometry();
						for(var t = 2; t < <?echo($C)?>; t++){
							geometry.vertices.push( new THREE.Vector3(50, CHI[t][0]*10, -t));							
						}
						for ( var i = 2; i < <? echo($C) ?>; i++) {
							geometry.vertices.push( new THREE.Vector3 ( CHI[i][1]*5+50, CHI[i][0]*10, -i) );
						}
						for (var f = 0; f < <?echo($C)?> - 6 ; f++) {						
							geometry.faces.push( new THREE.Face3( f, f+<?echo($C)?>, f+1) );
							geometry.faces.push( new THREE.Face3( f+<?echo($C)?>, f+<?echo($C)?>+1, f+1) );
						}

						geometry.computeFaceNormals();

						var material = new THREE.MeshNormalMaterial( { color: 0x99ccff } );
						var mesh = new THREE.Mesh( geometry, material );
						chimesh.add(mesh);
						scene.add(chimesh);
					}
					else{
						scene.remove(chimesh);
						animate();
					}
				}

				function addBOS () {
					bt++; 
					if (bt % 2 === 0)
					{
						var geometry = new THREE.Geometry();
						for(var t = 2; t < <?echo($B)?>; t++){
							geometry.vertices.push( new THREE.Vector3(100, BOS[t][0], -t)	);
							// geometry.vertexColors.push( new THREE.Color(0xff0033) );						
						}
						for ( var i = 2; i < <? echo($B) ?>; i++) {
							geometry.vertices.push( new THREE.Vector3 ( BOS[i][1]*5+100, BOS[i][0]*10, -i) );
						}
						for (var f = 0; f < <?echo($B)?> - 6 ; f++) {						
							geometry.faces.push( new THREE.Face3( f, f+<?echo($B)?>, f+1) );
							geometry.faces.push( new THREE.Face3( f+<?echo($B)?>, f+<?echo($B)?>+1, f+1) );
						}

						geometry.computeFaceNormals();

						var material = new THREE.MeshNormalMaterial();
						var mesh = new THREE.Mesh( geometry, material );
						bosmesh.add(mesh);
						scene.add(bosmesh);
					}
					else{
						scene.remove(bosmesh);
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
						camera.position.z = -285;
						// camera.position.y = -100;
						// camera.position.x = -100;
						// camera.lookAt(new THREE.Vector3( <? 0, 0,<?echo(-$L/2)?>));
						chimesh = new THREE.Object3D();
						nycmesh = new THREE.Object3D();
						bosmesh = new THREE.Object3D();
						lamesh = new THREE.Object3D();

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

	


















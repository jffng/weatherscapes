<?php 
	error_reporting(E_ALL);
	date_default_timezone_set('America/New_York');

	require 'libs/phpDataMapper/Base.php';

//setup the data model

	class DataModel extends phpDataMapper_Base
	{
		protected $_datasource = "openweatherinfo";

		public $id = array('type'=> 'int', 'primary' => true, "serial" => true);
		public $created = array('type'=> 'text', 'required'=>true);
		public $city = array('type' => 'text', 'required' => true);
		public $weather = array('type' => 'text', 'required' => true);	
		public $temperature = array('type' => 'float', 'required' => true);
		public $windspeed = array('type' => 'float', 'required' => true);
		public $winddirection = array('type' => 'float', 'required' => true);
	}

// database name: weather_cron
// hostname: mysql.jffng.com
// username: jffng_ITP
// pw: goblue1234

	function scrapeWeather($_city){
		$weatherAdapter = new phpDataMapper_Adapter_Mysql ('mysql.jffng.com', 'weather_cron', 'jffng_itp', 'goblue1234');
		$weatherMapper = new DataModel($weatherAdapter);
		$weatherMapper->migrate();

		$city = $_city;

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_URL, "http://api.openweathermap.org/data/2.5/find?q=$city&mode=json&units=metric");

		$return_data = curl_exec($curl);
		// echo($return_data);

		$decoded_data = json_decode($return_data);

		// print_r($decoded_data);

		$_cityname = $decoded_data->list[0]->name;
		$_weather = $decoded_data->list[0]->weather[0]->description;
		$_temp = $decoded_data->list[0]->main->temp;
		$_windspeed = $decoded_data->list[0]->wind->speed;
		$_winddir = $decoded_data->list[0]->wind->deg;

		echo($_city);
		echo($_weather);
		echo($_temp);
		echo($_windspeed);
		echo($_winddir);
		// echo("Name: " + $_city " Weather: " + $_weather " Temp: " + $_temp + " Wind Speed: " + $_windspeed + " Wind Direction: " + $_winddir);
		// if(isset($_POST['name'])){	
		// 	if(isset($_POST['message'])){

		$weatherRecord = $weatherMapper->get();
		$weatherRecord->created = time();
		$weatherRecord->city = $_cityname;
		$weatherRecord->weather = $_weather;
		$weatherRecord->temperature = $_temp;
		$weatherRecord->windspeed = $_windspeed;
		$weatherRecord->winddirection = $_winddir;
		$weatherMapper->save($weatherRecord);
	}

	scrapeWeather("New%20York");
	scrapeWeather("Boston");
	scrapeWeather("Chicago");
	scrapeWeather("San%20Francisco");
	scrapeWeather("Los%20Angeles");
	scrapeWeather("Tokyo");
?>

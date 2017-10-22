<?php

/*
________  ___  _____ ______   ___  _________  ________  ___          _____ ______   ________  ________  _______   ________      
|\   ___ \|\  \|\   _ \  _   \|\  \|\___   ___\\   __  \|\  \        |\   _ \  _   \|\   __  \|\   ___ \|\  ___ \ |\   ____\     
\ \  \_|\ \ \  \ \  \\\__\ \  \ \  \|___ \  \_\ \  \|\  \ \  \       \ \  \\\__\ \  \ \  \|\  \ \  \_|\ \ \   __/|\ \  \___|_    
 \ \  \ \\ \ \  \ \  \\|__| \  \ \  \   \ \  \ \ \   _  _\ \  \       \ \  \\|__| \  \ \   __  \ \  \ \\ \ \  \_|/_\ \_____  \   
  \ \  \_\\ \ \  \ \  \    \ \  \ \  \   \ \  \ \ \  \\  \\ \  \       \ \  \    \ \  \ \  \ \  \ \  \_\\ \ \  \_|\ \|____|\  \  
   \ \_______\ \__\ \__\    \ \__\ \__\   \ \__\ \ \__\\ _\\ \__\       \ \__\    \ \__\ \__\ \__\ \_______\ \_______\____\_\  \ 
    \|_______|\|__|\|__|     \|__|\|__|    \|__|  \|__|\|__|\|__|        \|__|     \|__|\|__|\|__|\|_______|\|_______|\_________\
                                                                                                                     \|_________|
*/
																												 
header("Access-Control-Allow-Origin: *");																			 
header('Content-Type: application/json');
error_reporting(E_ERROR | E_PARSE);
$time_start = microtime(true);

function searchPicture($name){
	
	return 'none';
	
}

if (isset($_GET['name']) && !empty($_GET['name']))
	{
	if ((isset($_GET['t9']) && !empty($_GET['t9'])) && (isset($_GET['t9']) && !empty($_GET['t9'])) && (isset($_GET['eztv']) && !empty($_GET['eztv'])))
		{
		$All = [];
		$Arg = $_GET['name'];
		$searchLength = 0;
		$t9 = $_GET['t9'];
		$x1337 = $_GET['x1337'];
		$eztv = $_GET['eztv'];
		$Arg = str_replace(" ", "+", $Arg);
		if ((isset($_GET['maxResults']) && !empty($_GET['maxResults']))){
			
			$maxResults = 1000;
			
		}else{
			
			$maxResults = $_GET['maxResults'];
			
		}
		if ($x1337 === 'true')
			{
			if (isset($_GET['x1337pages']) && !empty($_GET['x1337pages']))
				{
				$pages = $_GET['x1337pages'];
				}
			  else
				{
				$pages = 1;
				}

			if ($pages < 1)
				{
				$pages = 1;
				}

			for ($b = 1; $b <= $pages; $b++)
				{
				$link = 'https://1337x.to/search/' . $Arg . '/' . $b . '/';
				$jsonData = file_get_contents($link);
				$dom = new DOMDocument;
				$dom->loadHTML($jsonData);
				if ($dom->getElementsByTagName('tbody')->length > 0)
					{
					$as = $dom->getElementsByTagName('tbody')->item(0)->getElementsByTagName('a');
					foreach($as as $a)
						{
						$href = $a->getAttribute("href");
						if (strpos($href, 'torrent') !== false)
							{
							$searchLength++;
							$Link = 'https://1337x.to' . $href;
							$jsonData = file_get_contents($Link);
							$dom2 = new DOMDocument;
							$dom2->loadHTML($jsonData);
							$links = $dom2->getElementsByTagName('ul')->item(5)->getElementsByTagName('a')->item(0);
							array_push($All, array(
								'link' => $links->getAttribute("href") ,
								"name" => $a->nodeValue,
								"picture" => searchPicture($name)
							));
							}
						}
					}
				}
			}

		if ($t9 === 'true')
			{
			$link = 'http://www.torrents9.pe/search_torrent/' . $Arg . '.html';
			$jsonData = file_get_contents($link);
			$dom3 = new DOMDocument;
			$dom3->loadHTML($jsonData);
			if ($dom3->getElementsByTagName('tbody')->length > 0)
				{
				$as = $dom3->getElementsByTagName('tbody')->item(0)->getElementsByTagName('a');
				foreach($as as $a)
					{
					$href = $a->getAttribute("href");
					if (strpos($href, 'torrent') !== false)
						{
						$searchLength++;
						$Link = 'http://www.torrents9.pe' . $href;
						$jsonData = file_get_contents($Link);
						$dom4 = new DOMDocument;
						$dom4->loadHTML($jsonData);
						$image = $dom4->getElementsByTagName('img')->item(13);
						$links = $dom4->getElementsByTagName('div')->item(56)->getElementsByTagName('a')->item(0);
						array_push($All, array(
							'link' => 'http://www.torrents9.pe' . $links->getAttribute("href") ,
							"name" => $a->nodeValue,
							"picture" => $image->getAttribute('src')
						));
						}
					}
				}
			}

		if ($eztv === 'true')
			{
			$link = 'https://eztv.ag/search/' . $Arg;
			$jsonData = file_get_contents($link);
			$dom5 = new DOMDocument;
			$dom5->loadHTML($jsonData);
			$as = $dom5->getElementsByTagName('table')->item(5)->getElementsByTagName('a');
			foreach($as as $a)
				{
				$href = $a->getAttribute("href");
				if (strpos($href, '.torrent') !== false)
					{
					$searchLength++;
					$Link = $href;
					$name = substr($href, strlen("https://zoink.ch/torrent/"));
					$name = substr($name, 0, -8);
					array_push($All, array(
						'link' => $Link,
						"name" => $name,
						"picture" => searchPicture($name)
					));
					}
				}
			}

		$time_end = microtime(true);
		$time = $time_end - $time_start;
		echo '{' . "\n" . '' . "\t" . '"search":"' . $Arg . '",' . "\n" . '' . "\t" . '"time":' . $time . ',' . "\n" . '' . "\t" . '"resultsLength":' . $searchLength . ',' . "\n" . '' . "\t" . '"results":';
		echo json_encode($All, JSON_PRETTY_PRINT);
		echo "\n\n" . '}';
		}
	  else
		{
		$time_end = microtime(true);
		$time = $time_end - $time_start;
		echo '{' . "\n" . '' . "\t" . '"error":"Arguments missing : x1337 or t9 or eztv.",' . "\n" . '' . "\t" . '"time":' . $time;
		echo "\n\n" . '}';
		}
	}
  else
	{
	$time_end = microtime(true);
	$time = $time_end - $time_start;
	echo '{' . "\n" . '' . "\t" . '"error":"Argument missing name.",' . "\n" . '' . "\t" . '"time":' . $time;
	echo "\n\n" . '}';
	}
?>
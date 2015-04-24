<?php

class player
{
	public $summonerName = array();
	public $champName = array();
	public $summSpell1 = array();
	public $summSpell2 = array();
	public $i;
    //public team;

	public function infos($summonerName, $champName, $summSpell1, $summSpell2, $i)
	{
		array_push($this->summonerName, $summonerName);
		array_push($this->champName, $champName);
		array_push($this->summSpell1, $summSpell1);
		array_push($this->summSpell2, $summSpell2);
		$this->i = $i;
	}
}

class lolPow
{
	public $region;
	public $player;
	public $api_key;
	public $onetwo;
	public $onethree;
	public $onefour;
	public $twotwo;
	public $twofour;
	public $twofive;
	public $summId;

	public function __construct($region, $player, $api_key)
	{
		$this->region = $region;
		$this->player = $player;
		$this->player = str_replace(" ", "", $this->player);
		$this->player = str_replace("%20", "", $this->player);
		$this->api_key = $api_key;
		$this->onetwo = 'https://' . $this->region . '.api.pvp.net/api/lol/' . $this->region . '/v1.2/';
		$this->onethree = 'https://' . $this->region . '.api.pvp.net/api/lol/' . $this->region . '/v1.3/';
		$this->onefour = 'https://' . $this->region . '.api.pvp.net/api/lol/' . $this->region . '/v1.4/';
		$this->twotwo = 'https://' . $this->region . '.api.pvp.net/api/lol/' . $this->region . '/v2.2/';
		$this->twofour = 'https://' . $this->region . '.api.pvp.net/api/lol/' . $this->region . '/v2.4/';
		$this->twofive = 'https://' . $this->region . '.api.pvp.net/api/lol/' . $this->region . '/v2.5/';
	}

	public function askApi($url)
	{
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$infos = curl_exec($ch);
		curl_close($ch);
		return $infos;
	}

	public function getSummonerId()
	{
		$url = $this->onefour . 'summoner/by-name/' . $this->player . $this->api_key;
		$data = $this->askApi($url);
		$result = json_decode($data);
		$player = $this->player;
		$this->summId = $result->$player->id;
	}

	public function regionToSpectate()
	{
		$this->getSummonerId();
		switch ($this->region)
		{
			case 'euw':
			$platformId = 'EUW1';
			break;

			case 'na':
			$platformId = 'NA1';
			break;

			default:
			break;
		}
		return ('https://' . $this->region . '.api.pvp.net/observer-mode/rest/consumer/getSpectatorGameInfo/' . $platformId . '/' . $this->summId . $this->api_key);
	}

	public function spectate()
	{
		$i = 0;
		$url = $this->regionToSpectate();
		$data = $this->askApi($url);
		$result = json_decode($data);
		$player = new player();
		foreach ($result->participants as $name)
		{
			$champ_data = $this->askApi('https://global.api.pvp.net/api/lol/static-data/' . $this->region . '/v1.2/champion/' . $name->championId . $this->api_key);
			$champ = json_decode($champ_data);
			$champName = str_replace(" ", "", $champ->name);
			$champName = str_replace("'", "", $champName);
			$summSpell = $this->askApi('https://global.api.pvp.net/api/lol/static-data/' . $this->region .'/v1.2/summoner-spell/' . $name->spell1Id . $this->api_key);
			$summSpell1 = json_decode($summSpell);
			$summSpell = $this->askApi('https://global.api.pvp.net/api/lol/static-data/' . $this->region .'/v1.2/summoner-spell/' . $name->spell2Id . $this->api_key);
			$summSpell2 = json_decode($summSpell);
			$player->infos($name->summonerName, $champName, $summSpell1->name, $summSpell2->name, $i);
			$i += 1;
		}
		return $player;
	}
/*
	public function rank()
	{
		$this->getSummonerId();
		echo $this->twofive . 'league/by-summoner/' . $this->summId . '/entry' . $this->api_key;
		$data = $this->askApi($this->twofive . 'league/by-summoner/' . $this->summId . '/entry' . $this->api_key);
		$result = json_decode($data);
		$summId = $this->summId;
		var_dump($data);
	}
*/
}

?>
<?php

class player
{
	public $summonerName = array();
	public $champName = array();
	public $summSpell1 = array();
	public $summSpell2 = array();
	public $tier = array();
	public $div = array();
	public $leaguePoint = array();
	public $win = array();
	public $lose = array();
	public $httpCode;
	public $http = array();
	public $i;
	public $region;
	public $api_key = '?api_key=c54b731a-fac6-4355-b11b-2c5ee40bea41';
    //public team;

	public function askApi($url)
	{
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		$infos = curl_exec($ch);
		$this->httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		return $infos;
	}

	public function getSummonerId($player)
	{
		$player = strtolower($player);
		$player = str_replace(" ", "", $player);
		$player = str_replace("%20", "", $player);
		$url = 'https://' . $this->region . '.api.pvp.net/api/lol/' . $this->region . '/v1.4/summoner/by-name/' . $player . $this->api_key;
		$data = $this->askApi($url);
		$result = json_decode($data);
		return $result->$player->id;
	}

	public function infos($summonerName, $champName, $summSpell1, $summSpell2, $i, $region)
	{
		array_push($this->summonerName, $summonerName);
		array_push($this->champName, $champName);
		array_push($this->summSpell1, $summSpell1);
		array_push($this->summSpell2, $summSpell2);
		$this->region = $region; 
		$this->i = $i;
		$summId = $this->getSummonerId($this->summonerName[$i]);
		$url = 'https://' . $this->region . '.api.pvp.net/api/lol/' . $this->region . '/v2.5/league/by-summoner/' . $summId . '/entry' . $this->api_key;
		$data = $this->askApi($url);
		$result = json_decode($data, true);
		array_push($this->tier, $result[$summId][0]['tier']);
		array_push($this->div, $result[$summId][0]['entries'][0]['division']);
		array_push($this->leaguePoint, $result[$summId][0]['entries'][0]['leaguePoints']);
		array_push($this->win, $result[$summId][0]['entries'][0]['wins']);
		array_push($this->lose, $result[$summId][0]['entries'][0]['losses']);
		array_push($this->http, $this->httpCode);
	}
}

class elo
{
	public $leagueName;
	public $leagueDiv;
	public $leaguePoint;
	public $winSolo;
	public $loseSolo;
	public $httpCode;

	public function __construct ($leagueName, $leagueDiv, $leaguePoint, $winSolo, $loseSolo)
	{
		$this->leagueName = $leagueName;
		$this->leagueDiv = $leagueDiv;
		$this->leaguePoint = $leaguePoint;
		$this->winSolo = $winSolo;
		$this->loseSolo = $loseSolo;
	}
}

class lolPow
{
	public $region;
	public $player;
	public $summonerName;
	public $api_key;
	public $onetwo;
	public $onethree;
	public $onefour;
	public $twotwo;
	public $twofour;
	public $twofive;
	public $summId;
	public $level;
	public $httpCode;
	public $httpCode_spec;
	public $httpCode_static;
	public $i;
	public $champ_array = array();
	public $ss_array = array();

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
		$this->i = 0;
		static_data();
	}

	public function askApi($url, $dest, $send)
	{
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		$infos = curl_exec($ch);
		if ($dest == "rank")
		{
			$send->httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		}
		else if($dest == "spec")
		{
			$this->httpCode_spec = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		}
		else if ($dest == "summ")
		{
			$this->httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		}
		else if ($dest == "static_data")
		{
			$this->httpCode_static = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		}
		curl_close($ch);
		return $infos;
	}

	public function static_data()
	{
		$url = 'https://global.api.pvp.net/api/lol/static-data/euw/v1.2/champion?api_key=c54b731a-fac6-4355-b11b-2c5ee40bea41';
		$data_champ = $this->askApi($url, "static_data", NULL);
		foreach ($data_champ->data as $champ_name)
			array_push($champ_array, array($champ_name->id, $champ_name->key));

		$url = 'https://global.api.pvp.net/api/lol/static-data/euw/v1.2/summoner-spell?api_key=c54b731a-fac6-4355-b11b-2c5ee40bea41';
		$data_ss = $this->askApi($url, "static_data", NULL);
		foreach ($data_ss->data as $ss)
			array_push($ss_array, array($ss->id, $ss->name));
	}

	public function getSummoner()
	{
		$url = $this->onefour . 'summoner/by-name/' . $this->player . $this->api_key;
		$data = $this->askApi($url, "summ", NULL);
		$result = json_decode($data);
		$player = $this->player;
		$this->summId = $result->$player->id;
		$this->level = $result->$player->summonerLevel;
		$this->summonerName = $result->$player->name;
	}

	public function regionToSpectate()
	{
		$this->getSummoner();
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
		$url = $this->regionToSpectate();
		//$player = new player();
		$data = $this->askApi($url, "spec", NULL);
		$result = json_decode($data);

		if ($this->httpCode_spec == 200)
		{
			/*
			foreach ($result->participants as $name)
			{
				$champ_data = $this->askApi('https://global.api.pvp.net/api/lol/static-data/' . $this->region . '/v1.2/champion/' . $name->championId . $this->api_key, NULL, NULL);
				$champ = json_decode($champ_data);
				$champName = str_replace(" ", "", $champ->name);
				$champName = str_replace("'", "", $champName);
				$summSpell = $this->askApi('https://global.api.pvp.net/api/lol/static-data/' . $this->region .'/v1.2/summoner-spell/' . $name->spell1Id . $this->api_key, NULL, NULL);
				$summSpell1 = json_decode($summSpell);
				$summSpell = $this->askApi('https://global.api.pvp.net/api/lol/static-data/' . $this->region .'/v1.2/summoner-spell/' . $name->spell2Id . $this->api_key, NULL, NULL);
				$summSpell2 = json_decode($summSpell);
				$player->infos($name->summonerName, $champName, $summSpell1->name, $summSpell2->name, $i, $this->region);
				$i += 1;
			}
			return $player;
			*/
			foreach ($result->participants as $name)
			{
				echo $name->summonerName;
			}
			return $variable = array();
		}
	}

	public function rank()
	{
		$this->getSummoner();
		$url = $this->twofive . 'league/by-summoner/' . $this->summId . '/entry' . $this->api_key;
		$data = $this->askApi($url, NULL, NULL);
		$result = json_decode($data, true);
		$elo = new elo(
			$result[$this->summId][0]['tier'], 
			$result[$this->summId][0]['entries'][0]['division'], 
			$result[$this->summId][0]['entries'][0]['leaguePoints'], 
			$result[$this->summId][0]['entries'][0]['wins'], 
			$result[$this->summId][0]['entries'][0]['losses']
			);
		$data = $this->askApi($url, "rank", $elo);
		return $elo;
	}

}

?>
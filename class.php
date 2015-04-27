<?php

class player
{
	public $summonerName = array();
	public $champName = array();
	public $summSpell1 = array();
	public $summSpell2 = array();
	public $i;
	public $httpCode;
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
			$send->httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		}
		else if ($dest == "summ")
		{
			$this->httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		}
		curl_close($ch);
		return $infos;
	}

	public function getSummoner()
	{
		$url = $this->onefour . 'summoner/by-name/' . $this->player . $this->api_key;
		$data = $this->askApi($url, "summ", NULL);
		$result = json_decode($data);
		$player = $this->player;
		$this->summId = $result->$player->id;
		$this->level = $result->$player->summonerLevel; 
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
		$i = 0;
		$url = $this->regionToSpectate();
		$player = new player();
		$data = $this->askApi($url, "spec", $player);
		$result = json_decode($data);
		if ($player->httpCode == 200)
		{
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
	}

	public function rank()
	{
		$this->getSummoner();
		$url = $this->twofive . 'league/by-summoner/' . $this->summId . '/entry' . $this->api_key;
		$data = $this->askApi($url, NULL, NULL);
		$result = json_decode($data, true);
		$elo = new elo($result[$this->summId][0]['tier'], $result[$this->summId][0]['entries'][0]['division'], $result[$this->summId][0]['entries'][0]['leaguePoints'], $result[$this->summId][0]['entries'][0]['wins'], $result[$this->summId][0]['entries'][0]['losses']);
		$data = $this->askApi($url, "rank", $elo);
		return $elo;
	}

}

?>
<?php

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

	public function __construct($region, $player, $api_key)
	{
		$this->storeInfo($region, $player, $api_key);
		$this->storeUrl();
		$this->getSummoner();
		$this->rank();
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
		else if ($dest == "summ")
		{
			$this->httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		}
		curl_close($ch);
		return $infos;
	}
	
	public function storeInfo($region, $player, $api_key)
	{
		$this->region = $region;
		$this->player = $player;
		$this->player = str_replace(" ", "", $this->player);
		$this->player = str_replace("%20", "", $this->player);
		$this->api_key = $api_key;	
	}

	public function storeUrl()
	{
		$this->onetwo = 'https://' . $this->region . '.api.pvp.net/api/lol/' . $this->region . '/v1.2/';
		$this->onethree = 'https://' . $this->region . '.api.pvp.net/api/lol/' . $this->region . '/v1.3/';
		$this->onefour = 'https://' . $this->region . '.api.pvp.net/api/lol/' . $this->region . '/v1.4/';
		$this->twotwo = 'https://' . $this->region . '.api.pvp.net/api/lol/' . $this->region . '/v2.2/';
		$this->twofour = 'https://' . $this->region . '.api.pvp.net/api/lol/' . $this->region . '/v2.4/';
		$this->twofive = 'https://' . $this->region . '.api.pvp.net/api/lol/' . $this->region . '/v2.5/';
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

	public function rank()
	{
		$url = $this->twofive . 'league/by-summoner/' . $this->summId . '/entry' . $this->api_key;
		$data = $this->askApi($url, NULL, NULL);
		$result = json_decode($data, true);
		$elo = new elo($result[$this->summId][0]['tier'], $result[$this->summId][0]['entries'][0]['division'], $result[$this->summId][0]['entries'][0]['leaguePoints'], $result[$this->summId][0]['entries'][0]['wins'], $result[$this->summId][0]['entries'][0]['losses']);
		$data = $this->askApi($url, "rank", $elo);
		return $elo;
	}

}

?>
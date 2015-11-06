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
	public $httpCode_spec;
	public $httpCode_static;
	public $i;
	public $gameTypeId;
	public $champ_array = array();
	public $ss_array = array();
	public $variable = array();
	public $bans = array();

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
		$this->getSummoner();
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
		$url = 'https://global.api.pvp.net/api/lol/static-data/' . $this->region . '/v1.2/champion?api_key=c54b731a-fac6-4355-b11b-2c5ee40bea41';
		$data_champ = $this->askApi($url, "static_data", NULL);
		$result_champ = json_decode($data_champ);
		foreach ($result_champ->data as $champ_name)
			array_push($this->champ_array, array($champ_name->id, $champ_name->key));

		$url = 'https://global.api.pvp.net/api/lol/static-data/' . $this->region . '/v1.2/summoner-spell?api_key=c54b731a-fac6-4355-b11b-2c5ee40bea41';
		$data_ss = $this->askApi($url, "static_data", NULL);
		$result_ss = json_decode($data_ss);
		foreach ($result_ss->data as $ss)
			array_push($this->ss_array, array($ss->id, $ss->name));
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
		$data = $this->askApi($url, "spec", NULL);
		$result = json_decode($data);
		if ($this->httpCode_spec == 200)
		{
			$this->static_data();
			$this->gameTypeId = $result->gameQueueConfigId;
			foreach ($result->bannedChampions as $ban)
			{
				if ($ban->teamId == 100)
				{
					foreach ($this->champ_array as $champ_name) 
					{
						if ($champ_name[0] == $ban->championId)
							$champ = $champ_name[1];
					}
					array_push($this->bans, array(0, $champ));
				}
				else if ($ban->teamId == 200)
				{
					foreach ($this->champ_array as $champ_name) 
					{
						if ($champ_name[0] == $ban->championId)
							$champ = $champ_name[1];
					}
					array_push($this->bans, array(1, $champ));
				}
			}
			foreach ($result->participants as $name)
			{
				foreach ($this->champ_array as $champ_name) 
				{
					if ($champ_name[0] == $name->championId)
						$champ = $champ_name[1];
				}
				foreach ($this->ss_array as $ss_name)
				{
					if ($ss_name[0] == $name->spell1Id)
						$ss1 = $ss_name[1];
				}
				foreach ($this->ss_array as $ss_name)
				{
					if ($ss_name[0] == $name->spell2Id)
						$ss2 = $ss_name[1];
				}
				array_push($this->variable, array($name->summonerName, $champ, $ss1, $ss2));
				$this->i++;
			}
			return $this->variable;
		}
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
﻿var api_key = "cead18d4-28d4-4c90-8ea6-3cfcc6eaa18b";
var pill = "<ul class=\"nav nav-pills nav-center\" id=\"myPill\"><li role\"><a class=\"white\" data-toggle=\"tab\" href=\"#ingame\">InGame</a></li><li class=\"active\" role=\"presentation\"><a class=\"white\" data-toggle=\"tab\" href=\"#profile\">Profile</a></li></ul>";
var summonerID;
var region;
var summoner_name;

function get_data()
{
    var e = document.getElementById("regionSelector");
    region = e.options[e.selectedIndex].value;
	
	console.log(region);
	// Récupère le nom en minuscule et sans espace (pour fonctionner avec l'api)
    summoner_name = $('#summonername').val().toLowerCase().replace(/\s/g, '');
	
	if (summoner_name == "")
	{
		alert("No summoner name specified");
		return ;
	}
	
	append_data('https://' + region + '.api.pvp.net/api/lol/' + region + '/v1.4/summoner/by-name/' + summoner_name + '?api_key=' + api_key, 1);
}

function append_data(url, mode)
{
	$.ajax({
		url: url,
		type: 'GET',
		dataType: 'json',
		data: {

		},
		success: function (json) {
			//$("#results").html(pill);
			
			// TODO : Parser les infos, puis les afficher
			
			if (mode == 1) // Récupération du summonerID
			{
				//console.log(json);
				summonerID = json[summoner_name]["id"];
				append_data('https://' + region + '.api.pvp.net/api/lol/' + region + '/v2.5/league/by-summoner/' + summonerID + '/entry?api_key=' + api_key, 2);
			}
			else if (mode == 2) // Stats soloQ et ranked team
			{
				//console.log(json);
				parseRankedStats(json);
				append_data('https://' + region + '.api.pvp.net/api/lol/' + region + '/v1.3/stats/by-summoner/' + summonerID + '/ranked?api_key=' + api_key, 3);
			}
			else if (mode == 3) // Champions joués en ranked
			{
				console.log(json);
				append_data('https://' + region + '.api.pvp.net/api/lol/' + region + '/v1.3/stats/by-summoner/' + summonerID + '/summary?api_key=' + api_key, 4);
			}
			else if (mode == 4) // Nombre de win dans chaque mode de jeu
			{
				//console.log(json);
				parseGlobalStats(json);
			}
			
		},
		error: function (XMLHttpRequest, textStatus, errorThrown) {
			alert("Error getting summoner data!");
		}
	});
}

function parseRankedStats(json)
{
	var object = json[summonerID];
	
	for (var i = 0; i < object.length; i++)
	{
		var playerOrTeamName = object[i]["entries"][0]["playerOrTeamName"];
		var tier = object[i]["tier"];
		var division = object[i]["entries"][0]["division"];
		var queue = object[i]["queue"];
		var leaguePoints = object[i]["entries"][0]["leaguePoints"];
		var wins = object[i]["entries"][0]["wins"];
		var losses = object[i]["entries"][0]["losses"];

		console.log(playerOrTeamName + " " + queue + " " + tier + " " + division + " " + leaguePoints + "LP Wins: " + wins + " Losses: " + losses);
	}
}

function parseGlobalStats(json)
{
	var object = json["playerStatSummaries"];

	for (var i = 0; i < object.length; i++)
	{
		var gameMode = object[i]["playerStatSummaryType"];
		var wins = object[i]["wins"];

		console.log(gameMode + " Wins: " + wins);
	}
}
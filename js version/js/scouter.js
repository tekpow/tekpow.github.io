var api_key = "cead18d4-28d4-4c90-8ea6-3cfcc6eaa18b";
var pill = "<ul class=\"nav nav-pills nav-center\" id=\"myPill\"><li role\"><a class=\"white\" data-toggle=\"tab\" href=\"#ingame\">InGame</a></li><li class=\"active\" role=\"presentation\"><a class=\"white\" data-toggle=\"tab\" href=\"#profile\">Profile</a></li></ul>";
var summonerID;
var region;
var summoner_name;

    function get_data()
	{
		if (!$("#euselector").hasClass("active")) {
            region = "na";
        }
        else if (!$("#naselector").hasClass("active")) {
            region = "euw";
        }
        summoner_name = $('#summonername').val();
		
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
					console.log(json);
					summonerID = json[summoner_name]["id"];
					append_data('https://' + region + '.api.pvp.net/api/lol/' + region + '/v2.5/league/by-summoner/' + summonerID + '/entry?api_key=' + api_key, 2);
				}
				else if (mode == 2) // Stats soloQ et ranked team
				{
					console.log(json);
					append_data('https://' + region + '.api.pvp.net/api/lol/' + region + '/v1.3/stats/by-summoner/' + summonerID + '/ranked?api_key=' + api_key, 3);
				}
				else if (mode == 3) // Champions joués en ranked
				{
					console.log(json);
					append_data('https://' + region + '.api.pvp.net/api/lol/' + region + '/v1.3/stats/by-summoner/' + summonerID + '/summary?api_key=' + api_key, 4);
				}
				else if (mode == 4) // Nombre de win dans chaque mode de jeu
				{
					console.log(json);
				}
				
			},
			error: function (XMLHttpRequest, textStatus, errorThrown) {
				alert("Error getting summoner data!");
			}
		});
    }
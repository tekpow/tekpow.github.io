var api_key = "cead18d4-28d4-4c90-8ea6-3cfcc6eaa18b";
var pill = "<ul class=\"nav nav-pills nav-center\" id=\"myPill\"><li role\"><a class=\"white\" data-toggle=\"tab\" href=\"#ingame\">InGame</a></li><li class=\"active\" role=\"presentation\"><a class=\"white\" data-toggle=\"tab\" href=\"#profile\">Profile</a></li></ul>";

    function get_data() {
        var region = "";
        var summoner_name = "";
		var url = "";
		
        if (!$("#euselector").hasClass("active")) {
            region = "NA";
        }
        else if (!$("#naselector").hasClass("active")) {
            region = "EU";
        }
        summoner_name = $('#summonername').val();
		
		url = getUrlFromRegion(region, summoner_name);
		if (url == null)
		{
			alert("No summoner name specified");
			return ;
		}
		append_data(url);
    }

	function getUrlFromRegion(region, summoner_name)
	{
		if (summoner_name == "")
			return ;
		
		if (region == "EU")
			return ('https://euw.api.pvp.net/api/lol/euw/v1.4/summoner/by-name/' + summoner_name + '?api_key=' + api_key);
		else
			return ('https://na.api.pvp.net/api/lol/na/v1.4/summoner/by-name/' + summoner_name + '?api_key=' + api_key);
	}
	
    function append_data(url) {
		$.ajax({
			url: url,
			type: 'GET',
			dataType: 'json',
			data: {

			},
			success: function (json) {
				$("#results").html(pill);
				console.log(json);
				alert(json["theskorpiox"]["name"] + " is level " + json["theskorpiox"]["summonerLevel"]);
				
			},
			error: function (XMLHttpRequest, textStatus, errorThrown) {
				alert("error getting Summoner data!");
			}
		});
    }
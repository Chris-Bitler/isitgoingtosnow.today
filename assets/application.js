/**
 * POST to the query endpoint to get information on whether or not it is going to snow.
 */
function queryData() {
    var zipCode = $("#zip-input").val();
    var zipData = { zip: zipCode };
    $.post("weather/query.php", zipData, function(data) {
        try {
            var parsedData = JSON.parse(data);
        } catch (e) {
            $("#text-response").html("<h5 class='error'>Please enter a valid zip code.</h5>");
        }
        $("#response").css("display", "block");
        var town = parsedData.town;
        var state = parsedData.state;
        if (parsedData.snow) {
            $("#text-response").html("<h5>Yes, there is a " + parsedData.chance + "% chance it will snow today in " + town + ", " + state + "</h5>");
            $("#weather_image").attr("src", parsedData.img);
        } else {
            $("#text-response").html("<h5>No, it is not forecasted to snow in " + town + ", " + state + "</h5>");
            $("#weather_image").attr("src", "");
        }
    });
}

$( document ).ready(function() {
        $("#button").click(queryData);
    }
);

/**
 * POST to the query endpoint to get information on whether or not it is going to snow.
 */
function queryData() {
    var zipCode = $("#zip-input").val();
    var zipData = { zip: zipCode };
    $.post("weather/query.php", zipData, function(data) {
        var parsedData = JSON.parse(data);
        $("#response").css("display", "block");
        var county = parsedData.county;
        var state = parsedData.state;
        if (parsedData.snow) {
            $("#text-response").html("<h5>Yes, there is a " + parsedData.chance + "% chance it will snow today in " + county + ", " + state + "</h5>");
            $("#weather_image").attr("src", parsedData.img);
        } else {
            $("#text-response").html("<h5>No, it is not forecasted to snow in " + county + ", " + state + "</h5>");
            $("#weather_image").attr("src", "");
        }
    });
}

$( document ).ready(function() {
        $("#button").click(queryData);
    }
);
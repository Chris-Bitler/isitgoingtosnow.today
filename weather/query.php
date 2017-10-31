<?php
    include "settings.php";
    const QUERY_URL = "http://api.wunderground.com/api/%s/forecast/q/%d.json";
    const NOMINATIM = "http://nominatim.openstreetmap.org/search?format=json&postalcode=%d&country=US&addressdetails=1";
    const SNOW_REGEX = "/Chance of snow (\d+)%/";
    const PRECIP_REGEX = "/Chance of precip (\d+)%/";

    function queryData($zip) {
        $url = sprintf(QUERY_URL, WUNDER_API_KEY, $zip);
        $data = json_decode(
            file_get_contents($url)
        );

        $forecastToday = $data->forecast->txt_forecast->forecastday[0];
        $forecastText = $forecastToday->fcttext;
        $match = preg_match(SNOW_REGEX, $forecastText, $matches);
        $m = null;
        $match2 = preg_match(PRECIP_REGEX, $forecastText, $matches2) && stripos($forecastText,"Snow") !== false;

        if ($match || $match2) {
            $zipInfo = getZipInfo($zip);
            $response = array(
                'snow' => true,
                'chance' => $match ? $matches[1] : $matches2[1],
                'img' => $forecastToday->icon_url,
                'county' => $zipInfo['county'],
                'state' => $zipInfo['state']
            );
            return json_encode($response);
        }

        $zipInfo = getZipInfo($zip);

        return json_encode(array(
            'snow' => false,
            'county' => $zipInfo['county'],
            'state' => $zipInfo['state'],
        ));
    }

    function getZipInfo($zip) {
        $zipData = json_decode(
            file_get_contents(
                sprintf(NOMINATIM, $zip)
            )
        );
        $county = $zipData[0]->address->county;
        $state = $zipData[0]->address->state;
        return array(
            'county' => $county,
            'state' => $state,
        );
    }

    echo queryData($_POST['zip']);
?>
<?php
    include "settings.php";
    const QUERY_URL = "http://api.wunderground.com/api/%s/forecast/q/%s.json";
    const NOMINATIM = "http://nominatim.openstreetmap.org/search?format=json&postalcode=%s&country=US&addressdetails=1";
    const SNOW_REGEX = "/Chance of snow (\d+)%/";
    const PRECIP_REGEX = "/Chance of precip (\d+)%/";

    /**
     * Query the weather data at a given zip code
     * @param string $zip
     * @return string JSON encoded data saying whether or not it is going to snow and the likelihood for the snow
     */
    function queryData($zip) {
        if(!is_numeric($zip) || strlen($zip) != 5) {
            die("Only valid numeric zip codes are allowed");
        }

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
                'town' => $zipInfo['town'],
                'state' => $zipInfo['state']
            );
            return json_encode($response);
        }

        $zipInfo = getZipInfo($zip);

        return json_encode(array(
            'snow' => false,
            'town' => $zipInfo['town'],
            'state' => $zipInfo['state'],
        ));
    }

    /**
     * Query openstreetmap for the town and state of a given zipcode
     * Thanks to https://gitlab.com/thenaterhood/todayinmy.city/blob/master/assets/js/location.js for providing the
     * list of possible return values for the town
     * @param string $zip The zip code
     * @return array The county and state in an array
     */
    function getZipInfo($zip) {
        $zipData = json_decode(
            file_get_contents(
                sprintf(NOMINATIM, $zip)
            )
        );
        $address = $zipData[0]->address;
        $town = null;
        if ($address->city) {
            $town = $address->city;
        } else if ($address->town) {
            $town = $address->town;
        } else if ($address->suburb) {
            $town = $address->suburb;
        } else if ($address->hamlet) {
            $town = $address->hamlet;
        } else if ($address->village) {
            $town = $address->village;
        } else if ($address->locality) {
            $town = $address->locality;
        }

        if (!$town) {
            $town = $address->county;
        }

        if (strtolower(substr($town, sizeof($town)-5,4)) === "town") {
            $town = substr($town,0,sizeof($town)-6);
        }

        $state = $address->state;
        return array(
            'town' => $town,
            'state' => $state,
        );
    }

    echo queryData($_POST['zip']);
?>

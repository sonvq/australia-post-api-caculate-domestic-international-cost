<?php

class Shipping {

    private $api = 'https://auspost.com.au/api/';
    private $auth_key = 'c04d8faa-48fd-4bbf-b1da-bc0a1b3bbac5';

    const MAX_HEIGHT = 35; //only applies if same as width
    const MAX_WIDTH = 35; //only applies if same as height
    const MAX_WEIGHT = 20; //kgs
    const MAX_LENGTH = 105; //cms
    const MAX_GIRTH = 140; //cms
    const MIN_GIRTH = 16; //cms

    public function getRemoteData($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Auth-Key: ' . $this->auth_key
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $contents = curl_exec($ch);
        curl_close($ch);
        
        return json_decode($contents, true);
    }

    public function getDomesticShippingCost($data) {
        $edeliver_url = "{$this->api}postage/parcel/domestic/calculate.json";
        $edeliver_url = $this->arrayToUrl($edeliver_url, $data);
        $results = $this->getRemoteData($edeliver_url);

        if (isset($results['error']))
            throw new Exception($results['error']['errorMessage']);

        return $results['postage_result']['total_cost'];
    }
    
    public function getInternationalShippingCost($data) {
        $edeliver_url = "{$this->api}postage/parcel/international/calculate.json";
        $edeliver_url = $this->arrayToUrl($edeliver_url, $data);
        
        $results = $this->getRemoteData($edeliver_url);

        if (isset($results['error']))
            throw new Exception($results['error']['errorMessage']);

        return $results['postage_result']['total_cost'];
    }

    public function arrayToUrl($url, $array) {
        $first = true;
        foreach ($array as $key => $value) {
            $url .= $first ? '?' : '&';
            $url .= "{$key}={$value}";
            $first = false;
        }
        return $url;
    }

    public function getGirth($height, $width) {
        return ($width + $height) * 2;
    }

}


// Example domestic api call 
$shipping = new Shipping();
$dataDomestic = array(
    'from_postcode' => 4511,
    'to_postcode' => 4030,
    'weight' => 10,
    'height' => 105,
    'width' => 10,
    'length' => 10,
    'service_code' => 'AUS_PARCEL_REGULAR'
);
try {
    echo 'Example domestic shipping code is: ' . $shipping->getDomesticShippingCost($dataDomestic);
    echo '<br>';
} catch (Exception $e) {
    echo "oops: " . $e->getMessage();
}

// Example international api call 

$destinationCountryCode = 'NZ';
$parcelWeightInKGs = 1.0;

$dataInternational = array(
    "country_code" => $destinationCountryCode,
    "weight" => $parcelWeightInKGs,
    "service_code" => "INT_PARCEL_STD_OWN_PACKAGING"
);
try {
    echo 'Example international shipping code is: ' . $shipping->getInternationalShippingCost($dataInternational);
    echo '<br>';
} catch (Exception $e) {
    echo "oops: " . $e->getMessage();
}


// More Information see here
// https://developers.auspost.com.au/apis/pac/tutorial/international-parcel
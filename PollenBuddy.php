<?php

class PollenBuddy {

    private $data;
    private $city;
    private $zipcode;
    private $pollenType;
    private $fourDayForecast;

    const WUNDERGROUND_URL = "http://www.wunderground.com/DisplayPollen.asp?Zipcode=";

    /**
     * Set the content of the Wunderground pollen site page based on the
     * user-entered zipcode
     * @param  Integer $zipcode An US-based zipcode
     * @return mixed   $data    Content of the site
     */
    public function PollenBuddy($zipcode) {

        $this->zipcode = $zipcode;

        // Initialising cURL
        $ch = curl_init();

        // Setting cURL's URL option with the the Wunderground's pollen URL
        // while appending the user's zipcode
        curl_setopt(
            $ch,
            CURLOPT_URL,
            PollenBuddy::WUNDERGROUND_URL . (int) $zipcode
        );

        // Setting cURL's option to return the webpage data
        curl_setopt(
            $ch,
            CURLOPT_RETURNTRANSFER,
            TRUE
        );

        // Executing the cURL request and assigning the returned data to the
        // $data variable
        $this->data = curl_exec($ch);

        // Closing cURL
        curl_close($ch);
    }

    /**
     * Get the site's HTML data
     * @return mixed The site HTML
     */
    public function getSiteHTML() {
        return $this->data;
    }

    /**
     * Get the name of the city
     * @return String
     */
    public function getCity() {
        return $this->city;
    }

    /**
     * Get the zipcode of the city
     * @return int
     */
    public function getZipCode() {
        return $this->zipcode;
    }

    /**
     * Get today's pollen type
     * @return String
     */
    public function getTodayPollenType() {
        return $this->pollenType;
    }

    /**
     * Get the four day forecast data
     * @return mixed
     */
    public function getFourDayForecast() {
        return $this->fourDayForecast;
    }
}
<?php

require_once("simple_html_dom.php");

class PollenBuddy {

    // Class variables
    private $html;
    private $city;
    private $zipcode;
    private $pollenType;
    private $dates = array();
    private $levels = array();
    private $fourDayForecast;

    // Wunderground's Pollen API with zipcode GET parameter
    const WUNDERGROUND_URL = "http://www.wunderground.com/DisplayPollen.asp?Zipcode=";

    // Number of characters to strip before getting to the data
    const CITY_HTML = 20;
    const POLLEN_TYPE_HTML = 13;

    /**
     * Get the content of the Wunderground pollen site page based on the
     * user-entered zipcode
     * TODO: Check for incorrect zipcodes i.e. missing DOMs
     * @param  Integer $zipcode An US-based zipcode
     * @return mixed   $data    Content of the site
     */
    public function PollenBuddy($zipcode) {
        $this->zipcode = $zipcode;
        $this->html = file_get_html(PollenBuddy::WUNDERGROUND_URL . $zipcode);
    }

    /**
     * Get the site's HTML data
     * @return mixed The site HTML
     */
    public function getSiteHTML() {
        return $this->html;
    }

    /**
     * Get the name of the city
     * @return String
     */
    public function getCity() {
        $rawCity = $this->html
                        ->find("div.columns", 0)
                        ->plaintext;
        $this->city = substr(
            $rawCity,
            PollenBuddy::CITY_HTML
        );

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
    public function getPollenType() {

        $rawPollenType = $this->html
                              ->find("div.panel h3", 0)
                              ->plaintext;
        $this->pollenType = substr(
            $rawPollenType,
            PollenBuddy::POLLEN_TYPE_HTML

        );

        return $this->pollenType;
    }

    /**
     * Get the four day forecast data
     * @return mixed
     */
    public function getFourDayForecast() {

        // Iterate through the four dates [Wunderground only has four day
        // pollen prediction]
        for($i = 0; $i < 4; $i++) {

            // Get the raw date
            $rawDate = $this->html
                ->find("td.levels p", $i)
                ->plaintext;

            // Get the raw level
            $rawLevel = $this->html
                ->find("td.even-four div", $i)
                ->plaintext;

            // Push each date to the dates array
            array_push($this->dates, $rawDate);
            // Push each date to the levels array
            array_push($this->levels, $rawLevel);
        }

        $this->fourDayForecast = array_combine(
            $this->levels,
            $this->dates
        );

        return $this->fourDayForecast;
    }

    /**
     * Get the four forecasted dates
     * @return array Four forecasted dates
     */
    public function getFourDates() {
        return $this->dates;
    }

    /**
     * Get four forecasted levels
     * @return array Four forecasted levels of each day's pollen levels.
     */
    public function getFourLevels() {
        return $this->levels;
    }
}
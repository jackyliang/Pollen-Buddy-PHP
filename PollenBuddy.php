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
    const LEVELS = 6;
    const DATES = 6;

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
     * TODO: $this->levels is incomplete
     * Get the four day forecast data
     * @return mixed
     */
    public function getFourDayForecast() {
        $this->fourDayForecast = array_merge(
            $this->dates,
            $this->levels
        );
    }

    /**
     * Get the four forecasted dates
     * TODO: Set this as private and remove return once development is completed
     * @return array Four forecasted dates
     */
    public function getFourDates() {

        // Iterate through the four dates [Wunderground only has four day
        // pollen prediction]
        for($i = 0; $i < 4; $i++) {

            // Get the raw date
            $rawDate = $this->html
                ->find("td.levels", $i)
                ->plaintext;

            // Clean the raw date
            $date = substr(
                $rawDate,
                PollenBuddy::DATES
            );

            // Push each date to the dates array
            array_push($this->dates, $date);
        }
        return $this->dates;
    }

    /**
     * TODO: Finish getting the four pollen levels
     * TODO: Set this as private and remove return once development is completed
     * Get four forecasted levels
     * @return array
     */
    public function getFourLevels() {
        // Iterate through the four pollen levels [Wunderground only has four day
        // pollen prediction]
        for($i = 0; $i < 4; $i++) {

            // Get the raw level
            $rawLevel = $this->html
                ->find("td.text-center.even-four", $i)
                ->plaintext;

            // Clean the raw level
            $level = substr(
                $rawLevel,
                PollenBuddy::LEVELS
            );

            // Push each date to the levels array
            array_push($this->levels, $level);
        }

        return $this->levels;
    }
}
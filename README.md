# Pollen Buddy

A small and experimental Java Wunderground Pollen PHP library.

## What it do:

Gets you four date pollen prediction in the United States using the Wunderground API using simply your zipcode.

## How to use:

Create a new PollenBuddy object with a valid five-digit United States zipcode

`$data = new PollenBuddy(19104);`

Get the raw Wunderground site HTML

`$data->getSiteHTML();`

Get the name of the city

`$data->getCity();`

Get the five-digit zipcode

`$data->getZipCode();`

Get today's primary pollen type

`$data->getPollenType();`

Get the four day forecast [`date` => `pollen level`]

`$data->getFourDayForecast();`

Get the four dates

`$data->getFourDates();`

Get the four pollen levels

`$data->getFourLevels();`

## More Info You Don't Care About

Currently there are no existing APIs on the web that gets live pollen data with predictions. This gets you that.

This is a rewrite of a similar Java library I wrote last year for my Pollen Buddy app. 

## Note

You can use this anywhere the MIT license permits.

Please kindly credit me, however, when you use this library, and if possible, contribute back patches when/if necessary.

Do not, I repeat, do **NOT** use this library in a live production settings!

It uses [some TBD PHP scraping library] to scrape HTML/DOM directly off of Wunderground's Pollen site, and Wunderground could tweak their HTML/CSS just a bit, and it would break this library. I am not responsible for you losing millions of dollars.

*Actually that would be pretty cool.*

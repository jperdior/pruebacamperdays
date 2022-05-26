

Question 1
----------

What caching methods (and at what levels) can be applied to the solution to improve performance? Please explain your
reasons

* Indexing the database
* Implementing elasticsearch
* Including a cache system like redis, memcached...
* Implementing HTTP headers indicating which resources are cachable

Question 2
----------

Integrations with provider APIs are often time-consuming, how would you propose a solution to transform this use case
asynchronously in order not to block the search process? Please detail a solution

* I would use a bundle like symfony/http-client that allows non blocking calls
* I would implement a queue system where the provider APIs are consumed on a regular basis and the data is stored internally when it changed or is new.

# Welcome to CamperDays technical backend test

The estimated time for this test is three hours, so focus on what's important.

If you have any question regarding this test, you can contact us via email: [s.sanchez@billiger-mietwagen.de](mailto:s.sanchez@billiger-mietwagen.de)

Good luck!

Context
-------

* It's necessary to implement a solution to search for vehicle offers based on location and pick-up/drop-off dates.
* The data returned will be a combination of the company’s own inventory and integration with vehicle provider APIs.
* The inventory is made up of vehicle providers, stations (which are the places where vehicles are picked up and
dropped off), cities (where the stations are located) and vehicles.

API entry point
---------------

```shell
GET https://api.camperdays.com/search?cityCode=xxx&pickUpDate=yyyy-mm-dd&dropOffDate=yyyy-mm-dd
```

The search interface requires three parameters:

* City code:
  * type: string
  * length: 3

* Pick up date:
  * type: date
  * format: yyyy-mm-dd

* Drop off date:
  * type: date
  * format: yyyy-mm-dd

### Response

The result returned is a JSON array with the following structure:

```
{
  vehicles: [
    {
      code: <string>,
      model: <string>,
      total_price: {
        amount: <float>,
        currency: <string>
      },
      availability: <available|not_available|on_request>,
      provider_code: <string>,
      station_code: <string>
    }
    ...
  ]
}
```

Use case
--------

The use case shall:

* Ensure that the city code belongs to a city in our system and the date range is coherent.
* Get the vehicles from our inventory given the city and dates. You must use the inventory method:

  ```php
  Inventory::search(cityCode, pickUpDate, dropOffDate): Vehicle[]
  ```

  * A vehicle has the following structure: `Vehicle<code, model, total_price, availability, provider_code, station code>`
  * Our inventory only works with prices in euros.
* Obtain updated prices and availabilities from provider APIs (when necessary).
* Return the results (all prices should be returned in euros).

An example of an internal inventory search is:

```php
$inventory->search('LAS', DateTime<'2022-05-01'>, DateTime<'2022-05-14'>)

[
  Vehicle<RC1, Luxury C2, <350, EUR>, available, rental_campers, ST1>,

  Vehicle<DUO, Duo 360, <421, EUR>, not_available, road_travellers, LV1>,
  Vehicle<FXT, FX Truck, <536.50, EUR>, available, road_travellers, LV1>,
  Vehicle<MXL, Motorhome 10XL, <658.80, EUR>, available, road_travellers, LV2>,

  Vehicle<R1A, Full Road 1A, <648, EUR>, available, campervans_4all, LA_C>,
  Vehicle<R1B, Simple Road 1B, <702.70, EUR>, on_request, campervans_4all, LA_C>,
  Vehicle<RX1, Family Van X1, <800, EUR>, available, campervans_4all, LA_AIRP>,
]
```

Providers
---------

For the given example we have three different types of vehicle providers:

* **Rental Campers**
  * Code: `rental_campers`
  * No API
* **Road Travellers**
  * Code: `road_travellers`
  * XML API
  * API Request parameters: station code, pick up and drop off dates

  ```xml
  <!-- GET http://api.roadtravellers.domain/stations -->
  <Request>
   <StationCode>XXX</StationCode>
   <PickUpDate>yyyy-mm-dd</PickUpDate>
   <DropOffDate>yyyy-mm-dd</DropOffDate>
  </Request>
  ```

  * API Response

  ```xml
  <Response>
   <Vehicles>
     <Vehicle>
       <Code>XXX</Code>
       <TotalPrice currency="XXX">XXX</TotalPrice>
       <Available>Yes|Not</Available>
     </Vehicle>
     ...
   </Vehicles>
  </Response>
  ```

* **Campervans 4 All**
  * Code: `campervans_4all`
  * JSON API
  * API Request parameters: vehicle code, pick up and drop off dates

  ```shell
  GET http://campervans4all.domain/api/search?vehicle_code=xxx&pick_up=yyyy-mm-dd&drop_off=yyyy-mm-dd
  ```

  * API Response: all prices are in USD

  ```
  {
    "result": {
      "vehicle_code": "XXX",
      "availability": "Available|NotAvailable|OnRequest",
      "total_price": XXX
    }
  }
  ```

Exercise 1
----------

Implement a solution for this API entry point using the PHP Symfony framework with emphasis on the use of best practices and
clean architectures.

Exercise 2
----------

Implement tests in the part of the code you find most useful to cover.

Question 1
----------

What caching methods (and at what levels) can be applied to the solution to improve performance? Please explain your
reasons

Question 2
----------

Integrations with provider APIs are often time-consuming, how would you propose a solution to transform this use case
asynchronously in order not to block the search process? Please detail a solution

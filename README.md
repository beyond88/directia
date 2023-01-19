# Directia
Directia is a professional, powerful, flexible, high quality directory plugin, you can create any kind of directory site. Help businesses everywhere get found through their listings by your directory website visitors.

View plugin [readme](./readme.txt)  
***

## Installation

You can install the packages via composer:

```bash
composer install
```

## API

Following the endpoint is responsible to retrieve listing by id. To retrieve all listings just remove `?id=xxx`.
<br>
`/wp-json/directia-api/v1/listings?id=xxxx`

Following the endpoint is responsible to create listing using listing submission form block. You have to send post request to create a listing.
<br>
`/wp-json/directia-api/v1/create-listing`


## Blocks

- Directia Listing Form
- Directia Listing Block

## Pages

- Directia Admin Page (Menu page)
- Listing Details Page (Submenu page) [*Listing id is required to see listing details*]
- Directia Listing Details (Client area page) [*Listing id is required to see listing details*]

## Tables

- One table <strong>(prefix_directia)</strong> will be created when the plugin is activated. 

## Screenshots
<a href="https://github.com/beyond88/directia/blob/main/assets/img/listing-table.png" rel="nofollow">Listing table</a></li>
<a href="https://github.com/beyond88/directia/blob/main/assets/img/listing-form.png" rel="nofollow">Listing block</a></li>
<a href="https://github.com/beyond88/directia/blob/main/assets/img/listing-details.png" rel="nofollow">Listing details (admin panel)</a></li>
<a href="https://github.com/beyond88/directia/blob/main/assets/img/grid-view.png" rel="nofollow">Grid view (client area)</a></li>
<a href="https://github.com/beyond88/directia/blob/main/assets/img/blocks.png" rel="nofollow">Blocks</a></li>


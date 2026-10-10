# restaurant_collection

A PHP and MySQL web application for finding nearby restaurants and keeping a personal food collection. Pick a location on the map, discover restaurants from the stored catalog, and save places you want to try or visit again.

The interface is primarily in Traditional Chinese. The supplied restaurant data covers the Gongguan area of Taipei.

## Features

- **Accounts:** register, sign in, and sign out using PHP sessions. Registered users' passwords are hashed with bcrypt.
- **Map search:** choose a search center by clicking the Google Map and enter a radius in meters. Sort matching restaurants by Google rating, Google review count, or distance, or restrict results to your wishlist or favorites.
- **Wishlist:** save restaurants to try, add them to favorites, or remove them from the list.
- **Favorites:** keep favorite restaurants and write or update a personal review for each restaurant.
- **Tags:** assign keywords to restaurants and search by an exact keyword match.
- **Google Maps links:** open a restaurant's Google Maps page using its Place ID.
- **Restaurant administration:** search by restaurant name and add, edit, or delete catalog entries.

Search uses the restaurants already stored in MySQL; it does not fetch new Google Places results on each search. Ratings and review counts are snapshots from the imported data, separate from users' personal reviews.

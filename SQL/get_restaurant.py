import requests
import time
import csv


def get_nearby_restaurants(api_key, location, radius, max_results=60, type='restaurant'):
    endpoint_url = "https://maps.googleapis.com/maps/api/place/nearbysearch/json"
    params = {
        'location': location,  # Location in the format "latitude,longitude"
        'radius': radius,      # Radius in meters
        'type': type,          # Place type
        'key': api_key,         # Your API key
        'language': 'zh-TW'
    }

    results = []
    while True:
        response = requests.get(endpoint_url, params=params)
        if response.status_code != 200:
            break
        
        data = response.json()
        results.extend(data.get('results', []))
        
        if 'next_page_token' not in data or len(results) >= max_results:
            break
        
        next_page_token = data['next_page_token']
        params['pagetoken'] = next_page_token
        
        time.sleep(2)
    
    return results[:max_results]

def write_to_csv(restaurants, filename="restaurants.csv"):
    with open(filename, mode='w', newline='', encoding='utf-8') as file:
        writer = csv.writer(file)
        # Write the header
        writer.writerow(['name', 'place_id', 'latitude', 'longitude', 'rating', 'user_ratings_total'])

        # Write the restaurant data
        for place in restaurants:
            name = place.get('name')
            place_id = place.get('place_id')
            location = place.get('geometry', {}).get('location', {})
            latitude = location.get('lat')
            longitude = location.get('lng')
            rating = place.get('rating')
            user_ratings_total = place.get('user_ratings_total')
            writer.writerow([name, place_id, latitude, longitude, rating, user_ratings_total])

def write_to_sql(restaurants, filename="insert_restaurant.sql"):
    with open(filename, mode='w', encoding='utf-8') as file:
        file.write('INSERT INTO restaurant (id, name, latitude, longitude, rating, comment_num) VALUES\n')
        for i, place in enumerate(restaurants):
            name = place.get('name')
            place_id = place.get('place_id')
            link = f'https://www.google.com/maps/place/?q=place_id:{place_id}'
            location = place.get('geometry', {}).get('location', {})
            latitude = location.get('lat')
            longitude = location.get('lng')
            rating = place.get('rating')
            user_ratings_total = place.get('user_ratings_total')
            if i == len(restaurants) - 1:
                file.write(f"('{place_id}', '{name}', {latitude}, {longitude}, {rating}, {user_ratings_total});")
            else:
                file.write(f"('{place_id}', '{name}', {latitude}, {longitude}, {rating}, {user_ratings_total}),\n")


def print_restaurants(restaurants):
    for idx, place in enumerate(restaurants, start=1):
        name = place.get('name')
        place_id = place.get('place_id')
        location = place.get('geometry', {}).get('location', {})
        latitude = location.get('lat')
        longitude = location.get('lng')
        rating = place.get('rating')
        user_ratings_total = place.get('user_ratings_total')
        print(f"{idx}. {name}, {place_id}, ({latitude}, {longitude}), {rating}, {user_ratings_total}")

if __name__ == "__main__":
    api_key = ""
    location = "25.0151, 121.5340" # 公館
    radius = 2000 # meter

    restaurants = get_nearby_restaurants(api_key, location, radius)

    if restaurants:
        write_to_csv(restaurants)
        write_to_sql(restaurants)
        print_restaurants(restaurants)
    else:
        print("No restaurants found.")
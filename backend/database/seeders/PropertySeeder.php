<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class PropertySeeder extends Seeder
{
    public function run(): void
    {
        // Find users who have the owner role.
        $ownerIds = DB::table('users')
            ->join('user_roles', 'users.id', '=', 'user_roles.user_id')
            ->join('roles', 'user_roles.role_id', '=', 'roles.id')
            ->where('roles.name', 'owner')
            ->pluck('users.id')
            ->unique()
            ->values()
            ->all();

        if (empty($ownerIds)) {
            throw new RuntimeException(
                'No users with the owner role found. Run UserSeeder first.'
            );
        }

        $amenityIds = DB::table('amenities')
            ->where('is_active', true)
            ->pluck('id', 'name')
            ->all();

        $properties = [
            [
                'title' => 'Modern Luxury Apartment in Gulshan',
                'description' => 'A spacious luxury apartment with modern interiors in a prime residential area.',
                'property_type' => 'apartment',
                'address' => 'Road 12, House 45, Gulshan 2',
                'area' => 'Gulshan',
                'district' => 'Dhaka',
                'division' => 'Dhaka',
                'size_sqft' => 1800,
                'bedrooms' => 3,
                'bathrooms' => 3,
                'balconies' => 2,
                'floor_number' => 5,
                'total_floors' => 10,
                'furnishing_status' => 'fully_furnished',
                'listing_status' => 'approved',
                'availability_status' => 'available',
                'rental_type' => 'long_term',
                'price' => 65000,
                'price_unit' => 'month',
                'security_deposit' => 130000,
                'advance_amount' => 65000,
                'utility_included' => false,
                'minimum_nights' => null,
                'maximum_nights' => null,
                'guest_capacity' => null,
                'amenities' => [
                    'Wi-Fi',
                    'Air Conditioning',
                    'Parking',
                    'Elevator',
                    'Security',
                    'CCTV',
                    'Generator',
                ],
                'images' => [
                    'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c',
                    'https://images.unsplash.com/photo-1600607687920-4e2a09cf159d',
                ],
            ],
            [
                'title' => 'Family Apartment in Dhanmondi',
                'description' => 'A comfortable family apartment close to schools, hospitals and shopping facilities.',
                'property_type' => 'apartment',
                'address' => 'Road 8A, House 22, Dhanmondi',
                'area' => 'Dhanmondi',
                'district' => 'Dhaka',
                'division' => 'Dhaka',
                'size_sqft' => 1450,
                'bedrooms' => 3,
                'bathrooms' => 2,
                'balconies' => 2,
                'floor_number' => 4,
                'total_floors' => 8,
                'furnishing_status' => 'semi_furnished',
                'listing_status' => 'approved',
                'availability_status' => 'available',
                'rental_type' => 'long_term',
                'price' => 42000,
                'price_unit' => 'month',
                'security_deposit' => 84000,
                'advance_amount' => 42000,
                'utility_included' => false,
                'minimum_nights' => null,
                'maximum_nights' => null,
                'guest_capacity' => null,
                'amenities' => [
                    'Parking',
                    'Elevator',
                    'Security',
                    'Balcony',
                    'Gas Connection',
                    'Water Supply',
                ],
                'images' => [
                    'https://images.unsplash.com/photo-1600210492486-724fe5c67fb0',
                    'https://images.unsplash.com/photo-1600607687644-c7171b42498f',
                ],
            ],
            [
                'title' => 'Fully Furnished Studio in Banani',
                'description' => 'A stylish studio apartment suitable for short stays and business travellers.',
                'property_type' => 'studio',
                'address' => 'Road 11, Banani',
                'area' => 'Banani',
                'district' => 'Dhaka',
                'division' => 'Dhaka',
                'size_sqft' => 650,
                'bedrooms' => 1,
                'bathrooms' => 1,
                'balconies' => 1,
                'floor_number' => 6,
                'total_floors' => 12,
                'furnishing_status' => 'fully_furnished',
                'listing_status' => 'approved',
                'availability_status' => 'available',
                'rental_type' => 'short_term',
                'price' => 3500,
                'price_unit' => 'night',
                'security_deposit' => null,
                'advance_amount' => null,
                'utility_included' => true,
                'minimum_nights' => 2,
                'maximum_nights' => 30,
                'guest_capacity' => 2,
                'amenities' => [
                    'Wi-Fi',
                    'Air Conditioning',
                    'Elevator',
                    'Security',
                    'Furnished',
                    'Washing Machine',
                ],
                'images' => [
                    'https://images.unsplash.com/photo-1616486338812-3dadae4b4ace',
                    'https://images.unsplash.com/photo-1615874694520-474822394e73',
                ],
            ],
            [
                'title' => 'Spacious Family House in Uttara',
                'description' => 'A spacious residential house with multiple bedrooms and family-friendly surroundings.',
                'property_type' => 'house',
                'address' => 'Sector 10, Road 5, Uttara',
                'area' => 'Uttara',
                'district' => 'Dhaka',
                'division' => 'Dhaka',
                'size_sqft' => 2200,
                'bedrooms' => 4,
                'bathrooms' => 3,
                'balconies' => 3,
                'floor_number' => 2,
                'total_floors' => 4,
                'furnishing_status' => 'unfurnished',
                'listing_status' => 'approved',
                'availability_status' => 'available',
                'rental_type' => 'long_term',
                'price' => 55000,
                'price_unit' => 'month',
                'security_deposit' => 110000,
                'advance_amount' => 55000,
                'utility_included' => false,
                'minimum_nights' => null,
                'maximum_nights' => null,
                'guest_capacity' => null,
                'amenities' => [
                    'Parking',
                    'Security',
                    'Balcony',
                    'Gas Connection',
                    'Water Supply',
                    'Rooftop Access',
                ],
                'images' => [
                    'https://images.unsplash.com/photo-1600585154340-be6161a56a0c',
                    'https://images.unsplash.com/photo-1600566753086-00f18fb6b3ea',
                ],
            ],
            [
                'title' => 'Modern Apartment in Bashundhara',
                'description' => 'A modern apartment in a peaceful residential neighbourhood.',
                'property_type' => 'apartment',
                'address' => 'Block C, Bashundhara R/A',
                'area' => 'Bashundhara',
                'district' => 'Dhaka',
                'division' => 'Dhaka',
                'size_sqft' => 1600,
                'bedrooms' => 3,
                'bathrooms' => 3,
                'balconies' => 2,
                'floor_number' => 7,
                'total_floors' => 12,
                'furnishing_status' => 'semi_furnished',
                'listing_status' => 'pending',
                'availability_status' => 'available',
                'rental_type' => 'long_term',
                'price' => 48000,
                'price_unit' => 'month',
                'security_deposit' => 96000,
                'advance_amount' => 48000,
                'utility_included' => false,
                'minimum_nights' => null,
                'maximum_nights' => null,
                'guest_capacity' => null,
                'amenities' => [
                    'Parking',
                    'Elevator',
                    'Generator',
                    'Security',
                    'Gym',
                    'Balcony',
                ],
                'images' => [
                    'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c',
                    'https://images.unsplash.com/photo-1600210492486-724fe5c67fb0',
                ],
            ],
            [
                'title' => 'Budget Apartment in Mirpur',
                'description' => 'An affordable apartment suitable for a small family.',
                'property_type' => 'apartment',
                'address' => 'Section 11, Mirpur',
                'area' => 'Mirpur',
                'district' => 'Dhaka',
                'division' => 'Dhaka',
                'size_sqft' => 950,
                'bedrooms' => 2,
                'bathrooms' => 2,
                'balconies' => 1,
                'floor_number' => 3,
                'total_floors' => 6,
                'furnishing_status' => 'unfurnished',
                'listing_status' => 'draft',
                'availability_status' => 'available',
                'rental_type' => 'long_term',
                'price' => 18000,
                'price_unit' => 'month',
                'security_deposit' => 36000,
                'advance_amount' => 18000,
                'utility_included' => false,
                'minimum_nights' => null,
                'maximum_nights' => null,
                'guest_capacity' => null,
                'amenities' => [
                    'Water Supply',
                    'Gas Connection',
                    'Balcony',
                ],
                'images' => [
                    'https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3',
                    'https://images.unsplash.com/photo-1600607687920-4e2a09cf159d',
                ],
            ],
            [
                'title' => 'Beachside Holiday Apartment',
                'description' => 'A holiday apartment with a comfortable interior, ideal for visitors to Cox’s Bazar.',
                'property_type' => 'apartment',
                'address' => 'Kolatoli Road, Cox’s Bazar',
                'area' => 'Kolatoli',
                'district' => 'Cox’s Bazar',
                'division' => 'Chattogram',
                'size_sqft' => 1100,
                'bedrooms' => 2,
                'bathrooms' => 2,
                'balconies' => 1,
                'floor_number' => 5,
                'total_floors' => 10,
                'furnishing_status' => 'fully_furnished',
                'listing_status' => 'approved',
                'availability_status' => 'available',
                'rental_type' => 'short_term',
                'price' => 5000,
                'price_unit' => 'night',
                'security_deposit' => null,
                'advance_amount' => null,
                'utility_included' => true,
                'minimum_nights' => 1,
                'maximum_nights' => 14,
                'guest_capacity' => 5,
                'amenities' => [
                    'Wi-Fi',
                    'Air Conditioning',
                    'Parking',
                    'Elevator',
                    'Security',
                    'Furnished',
                ],
                'images' => [
                    'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c',
                    'https://images.unsplash.com/photo-1600607687644-c7171b42498f',
                ],
            ],
            [
                'title' => 'Spacious Apartment in Mohammadpur',
                'description' => 'A large apartment with convenient access to nearby markets and transport.',
                'property_type' => 'apartment',
                'address' => 'Town Hall Road, Mohammadpur',
                'area' => 'Mohammadpur',
                'district' => 'Dhaka',
                'division' => 'Dhaka',
                'size_sqft' => 1700,
                'bedrooms' => 3,
                'bathrooms' => 3,
                'balconies' => 2,
                'floor_number' => 4,
                'total_floors' => 8,
                'furnishing_status' => 'semi_furnished',
                'listing_status' => 'rejected',
                'availability_status' => 'available',
                'rental_type' => 'long_term',
                'price' => 35000,
                'price_unit' => 'month',
                'security_deposit' => 70000,
                'advance_amount' => 35000,
                'utility_included' => false,
                'minimum_nights' => null,
                'maximum_nights' => null,
                'guest_capacity' => null,
                'amenities' => [
                    'Parking',
                    'Elevator',
                    'Balcony',
                    'Water Supply',
                    'Gas Connection',
                ],
                'images' => [
                    'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c',
                    'https://images.unsplash.com/photo-1600210492486-724fe5c67fb0',
                ],
            ],
            [
                'title' => 'Compact Studio Apartment in Badda',
                'description' => 'A compact studio apartment suitable for an individual or working professional.',
                'property_type' => 'studio',
                'address' => 'Middle Badda, Dhaka',
                'area' => 'Badda',
                'district' => 'Dhaka',
                'division' => 'Dhaka',
                'size_sqft' => 550,
                'bedrooms' => 1,
                'bathrooms' => 1,
                'balconies' => 0,
                'floor_number' => 2,
                'total_floors' => 6,
                'furnishing_status' => 'fully_furnished',
                'listing_status' => 'approved',
                'availability_status' => 'unavailable',
                'rental_type' => 'long_term',
                'price' => 16000,
                'price_unit' => 'month',
                'security_deposit' => 32000,
                'advance_amount' => 16000,
                'utility_included' => true,
                'minimum_nights' => null,
                'maximum_nights' => null,
                'guest_capacity' => null,
                'amenities' => [
                    'Wi-Fi',
                    'Air Conditioning',
                    'Furnished',
                    'Refrigerator',
                    'Washing Machine',
                ],
                'images' => [
                    'https://images.unsplash.com/photo-1616486338812-3dadae4b4ace',
                    'https://images.unsplash.com/photo-1615874694520-474822394e73',
                ],
            ],
            [
                'title' => 'Luxury Holiday Studio in Cox’s Bazar',
                'description' => 'A furnished holiday studio designed for couples and short-stay visitors.',
                'property_type' => 'studio',
                'address' => 'Sugandha Point, Cox’s Bazar',
                'area' => 'Sugandha',
                'district' => 'Cox’s Bazar',
                'division' => 'Chattogram',
                'size_sqft' => 700,
                'bedrooms' => 1,
                'bathrooms' => 1,
                'balconies' => 1,
                'floor_number' => 8,
                'total_floors' => 12,
                'furnishing_status' => 'fully_furnished',
                'listing_status' => 'approved',
                'availability_status' => 'available',
                'rental_type' => 'short_term',
                'price' => 4000,
                'price_unit' => 'night',
                'security_deposit' => null,
                'advance_amount' => null,
                'utility_included' => true,
                'minimum_nights' => 1,
                'maximum_nights' => 10,
                'guest_capacity' => 2,
                'amenities' => [
                    'Wi-Fi',
                    'Air Conditioning',
                    'Elevator',
                    'Security',
                    'Furnished',
                    'Balcony',
                ],
                'images' => [
                    'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c',
                    'https://images.unsplash.com/photo-1600607687644-c7171b42498f',
                ],
            ],
        ];

        DB::transaction(function () use ($properties, $ownerIds, $amenityIds) {
            foreach ($properties as $index => $data) {
                $ownerId = $ownerIds[$index % count($ownerIds)];

                $propertyId = DB::table('properties')
                    ->where('title', $data['title'])
                    ->where('user_id', $ownerId)
                    ->value('id');

                $propertyData = [
                    'user_id' => $ownerId,
                    'title' => $data['title'],
                    'description' => $data['description'],
                    'property_type' => $data['property_type'],
                    'address' => $data['address'],
                    'area' => $data['area'],
                    'district' => $data['district'],
                    'division' => $data['division'],
                    'size_sqft' => $data['size_sqft'],
                    'bedrooms' => $data['bedrooms'],
                    'bathrooms' => $data['bathrooms'],
                    'balconies' => $data['balconies'],
                    'floor_number' => $data['floor_number'],
                    'total_floors' => $data['total_floors'],
                    'furnishing_status' => $data['furnishing_status'],
                    'listing_status' => $data['listing_status'],
                    'availability_status' => $data['availability_status'],
                    'updated_at' => now(),
                ];

                if ($propertyId) {
                    DB::table('properties')
                        ->where('id', $propertyId)
                        ->update($propertyData);
                } else {
                    $propertyData['created_at'] = now();

                    $propertyId = DB::table('properties')
                        ->insertGetId($propertyData);
                }

                // Rental details
                DB::table('rental_details')->updateOrInsert(
                    ['property_id' => $propertyId],
                    [
                        'rental_type' => $data['rental_type'],
                        'price' => $data['price'],
                        'price_unit' => $data['price_unit'],
                        'security_deposit' => $data['security_deposit'],
                        'advance_amount' => $data['advance_amount'],
                        'utility_included' => $data['utility_included'],
                        'available_from' => now()->toDateString(),
                        'minimum_nights' => $data['minimum_nights'],
                        'maximum_nights' => $data['maximum_nights'],
                        'guest_capacity' => $data['guest_capacity'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );

                // Replace existing seed images so rerunning stays consistent.
                DB::table('property_images')
                    ->where('property_id', $propertyId)
                    ->delete();

                foreach ($data['images'] as $imageIndex => $imagePath) {
                    DB::table('property_images')->insert([
                        'property_id' => $propertyId,
                        'image_path' => $imagePath,
                        'is_primary' => $imageIndex === 0,
                        'sort_order' => $imageIndex,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                // Replace existing amenity links.
                DB::table('property_amenities')
                    ->where('property_id', $propertyId)
                    ->delete();

                foreach ($data['amenities'] as $amenityName) {
                    if (isset($amenityIds[$amenityName])) {
                        DB::table('property_amenities')->insert([
                            'property_id' => $propertyId,
                            'amenity_id' => $amenityIds[$amenityName],
                        ]);
                    }
                }
            }
        });
    }
}

<?php

namespace App\Http\Requests;

use App\Models\Property;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class StorePropertyRequest extends FormRequest
{
    /**
     * Determine whether the user can create a property.
     */
    public function authorize(): bool
    {
        return $this->user()?->can('create', Property::class) ?? false;
    }

    /**
     * Get the validation rules.
     */
    public function rules(): array
    {
        return [
            // Basic property information
            'title' => ['required', 'string', 'max:150'],
            'description' => ['required', 'string', 'max:5000'],

            'property_type' => [
                'required',
                Rule::in(['house', 'apartment']),
            ],

            // Location
            'address' => ['required', 'string', 'max:500'],
            'area' => ['required', 'string', 'max:100'],
            'district' => ['required', 'string', 'max:100'],
            'division' => ['required', 'string', 'max:100'],

            // Physical details
            'size_sqft' => ['required', 'numeric', 'min:1'],
            'bedrooms' => ['required', 'integer', 'min:0'],
            'bathrooms' => ['required', 'integer', 'min:1'],
            'balconies' => ['nullable', 'integer', 'min:0'],
            'floor_number' => ['nullable', 'integer', 'min:0'],
            'total_floors' => ['nullable', 'integer', 'min:1'],

            'furnishing_status' => [
                'required',
                Rule::in([
                    'furnished',
                    'semi_furnished',
                    'unfurnished',
                ]),
            ],

            // Rental details
            'rental_details' => [
                'required',
                'array:rental_type,price,price_unit,security_deposit,advance_amount,utility_included,available_from,minimum_nights,maximum_nights,guest_capacity',
            ],

            'rental_details.rental_type' => [
                'required',
                Rule::in(['short_term', 'monthly']),
            ],

            'rental_details.price' => [
                'required',
                'numeric',
                'min:0.01',
            ],

            'rental_details.price_unit' => [
                'required',
                Rule::in(['night', 'month']),
            ],

            'rental_details.security_deposit' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'rental_details.advance_amount' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'rental_details.utility_included' => [
                'required',
                'boolean',
            ],

            'rental_details.available_from' => [
                'nullable',
                'date',
            ],

            // Short-term rental fields
            'rental_details.minimum_nights' => [
                'exclude_unless:rental_details.rental_type,short_term',
                'required',
                'integer',
                'min:1',
            ],

            'rental_details.maximum_nights' => [
                'exclude_unless:rental_details.rental_type,short_term',
                'nullable',
                'integer',
                'min:1',
            ],

            'rental_details.guest_capacity' => [
                'exclude_unless:rental_details.rental_type,short_term',
                'required',
                'integer',
                'min:1',
            ],
            'amenities' => [
                'sometimes',
                'array',
                'max:30',
            ],

            'amenities.*' => [
                'required',
                'integer',
                'distinct',
                'exists:amenities,id',
            ],
            'images' => [
                'sometimes',
                'array',
                'max:10',
            ],

            'images.*' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'primary_image_index' => [
                'nullable',
                'integer',
                'min:0',
            ],
        ];
    }

    /**
     * Additional validation after the regular rules.
     */
    public function after(): array
    {
        return [
            function (Validator $validator) {
                $rentalType = $this->input('rental_details.rental_type');
                $priceUnit = $this->input('rental_details.price_unit');

                // Ensure rental type and price unit match.
                if (
                    $rentalType === 'short_term'
                    && $priceUnit !== 'night'
                ) {
                    $validator->errors()->add(
                        'rental_details.price_unit',
                        'Short-term rentals must use night as the price unit.'
                    );
                }

                if (
                    $rentalType === 'monthly'
                    && $priceUnit !== 'month'
                ) {
                    $validator->errors()->add(
                        'rental_details.price_unit',
                        'Monthly rentals must use month as the price unit.'
                    );
                }

                // Maximum nights cannot be less than minimum nights.
                $minimumNights = $this->input(
                    'rental_details.minimum_nights'
                );

                $maximumNights = $this->input(
                    'rental_details.maximum_nights'
                );

                if (
                    $maximumNights !== null
                    && $minimumNights !== null
                    && (int) $maximumNights < (int) $minimumNights
                ) {
                    $validator->errors()->add(
                        'rental_details.maximum_nights',
                        'Maximum nights cannot be less than minimum nights.'
                    );
                }

                // Floor number cannot exceed total floors.
                $floorNumber = $this->input('floor_number');
                $totalFloors = $this->input('total_floors');

                if (
                    $floorNumber !== null
                    && $totalFloors !== null
                    && (int) $floorNumber > (int) $totalFloors
                ) {
                    $validator->errors()->add(
                        'floor_number',
                        'Floor number cannot exceed total floors.'
                    );
                }
                
                $images = $this->file('images', []);
                $primaryImageIndex = $this->input('primary_image_index');

                if (
                    $primaryImageIndex !== null
                    && (int) $primaryImageIndex >= count($images)
                ) {
                    $validator->errors()->add(
                        'primary_image_index',
                        'The selected primary image does not exist.'
                    );
                }
            },
        ];
    }
}
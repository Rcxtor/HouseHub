<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Requests\StorePropertyRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;
use RuntimeException;

class PropertyController extends Controller
{
    /**
     * Display a listing of properties.
     */
    use AuthorizesRequests;
    public function index(Request $request)
    {
        $this->authorize('viewAny', Property::class);

        $user = $request->user();

        $query = Property::query()
            ->with([
                'primaryImage',
                'rentalDetail',
            ])
            ->latest();

        // Admins can see all properties.
        if (!$user || !$user->hasRole('admin')) {
            $query->where(function ($query) use ($user) {
                // Everyone can see approved properties.
                $query->where('listing_status', 'approved');

                // Owners can also see their own unpublished properties.
                if ($user && $user->hasRole('owner')) {
                    $query->orWhere('user_id', $user->id);
                }
            });
        }

        $properties = $query->paginate(12);

        return response()->json($properties);
    }

    /**
     * Display a specific property.
     */
    public function show(Property $property)
    {
        $this->authorize('view', $property);

        $property->load([
            'primaryImage',
            'images',
            'rentalDetail',
            'amenities',
            'owner.ownerProfile',
        ]);

        return response()->json([
            'data' => $property,
        ]);
    }

    /**
     * Store a newly created property.
     */
    public function store(StorePropertyRequest $request)
    {
        $data = $request->validated();

        $rentalDetails = $data['rental_details'];
        $amenityIds = $data['amenities'] ?? [];
        $images = $data['images'] ?? [];

        // If no primary image is selected, use the first image.
        $primaryImageIndex = isset($data['primary_image_index'])
            ? (int) $data['primary_image_index']
            : 0;

        unset(
            $data['rental_details'],
            $data['amenities'],
            $data['images'],
            $data['primary_image_index']
        );

        $uploadedPaths = [];

        try {
            $property = DB::transaction(function () use ($data, $rentalDetails, $amenityIds, $images, $primaryImageIndex, $request, &$uploadedPaths) {
                // 1. Create property
                $property = Property::create([
                    ...$data,
                    'user_id' => $request->user()->id,
                    'listing_status' => 'draft',
                    'availability_status' => 'available',
                ]);

                // 2. Create rental details
                $property->rentalDetail()->create($rentalDetails);

                // 3. Attach amenities
                $property->amenities()->sync($amenityIds);

                // 4. Upload images and create image records
                foreach ($images as $index => $image) {
                    $path = $image->store('properties', 'public');

                    if (!$path) {
                        throw new RuntimeException(
                            'Failed to upload property image.'
                        );
                    }

                    $uploadedPaths[] = $path;

                    $property->images()->create([
                        'image_path' => $path,
                        'is_primary' => $index === $primaryImageIndex,
                        'sort_order' => $index,
                    ]);
                }

                return $property;
            });
        } catch (Throwable $exception) {
            // Database rollback does not automatically delete uploaded files.
            if (!empty($uploadedPaths)) {
                Storage::disk('public')->delete($uploadedPaths);
            }

            throw $exception;
        }

        $property->load([
            'primaryImage',
            'images',
            'rentalDetail',
            'amenities',
            'owner.ownerProfile',
        ]);

        return response()->json([
            'message' => 'Property created successfully.',
            'data' => $property,
        ], 201);
    }

    public function update(Request $request, Property $property)
    {
        //
    }

    public function destroy(Property $property)
    {
        //
    }
}
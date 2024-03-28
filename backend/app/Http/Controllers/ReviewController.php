<?php

namespace App\Http\Controllers;

use App\Models\Reviews;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->query('page');
        $unit = $request->query('unit');
        $allReviews = Reviews::orderBy('created_at', 'desc')->get()->toArray();
        $allPages = ceil(count($allReviews) / $unit);
        $reviews = array_slice($allReviews, $unit * ($page - 1), $unit);
        return response()->json([
            "message" => "Get all successfully.",
            "payload" => [
                "allReviews" => $reviews,
                "allPages" => $allPages,
            ],
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $newReview = new Reviews;
        // $newReview->rating = $request->rating;
        // $newReview->comment = $request->comment;
        // $newReview->save();
        $newReview = Reviews::create($request->all());
        return response()->json([
            "message" => "Inserted successfully.",
            "insertedReview" => $newReview,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $updatedReview = Reviews::where('id', $id)->firstOrFail();
            $updatedReview->response = $request->response;
            $updatedReview->save();
            return response()->json([
                "message" => "Updated Successfully.",
                "updatedReview" => $updatedReview,
            ], 200);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                "message" => "Not exist this review.",
            ], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $deleted = Reviews::where('id', $id)->delete();
            return response()->json([
                "message" => "Deleted Successfully.",
                "deletedStatus" => true,
            ], 200);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                "message" => "Not exist this review.",
            ], 401);
        }
    }
}

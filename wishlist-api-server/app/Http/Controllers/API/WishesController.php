<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Wish;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class WishesController extends Controller
{
    // All wishes
    public function all() {

        $allWishes = Wish::whereIsArchived(false)
            ->get()
            ->all();

        return response()->json($allWishes, 201);

    }

    // Single wishes list of another user
    public function single(int $id) {

        $singleWishes = Wish::whereUserId($id)
            ->where('user_id', $id)
            ->get()
            ->all();

        return response()->json($singleWishes, 201);

    }

    // Self user wishes list
    public function self() {

        $selfWishes = auth()
            ->user()
            ->wishes()
            ->whereIsArchived(false)
            ->get()
            ->all();

        return response()->json($selfWishes, 201);

    }

    // Self user archived wishes list
    public function selfArchive() {

        $selfWishes = auth()
            ->user()
            ->wishes()
            ->whereIsArchived(true)
            ->get()
            ->all();

        return response()->json($selfWishes, 201);

    }

    public function store(Request $request) {

        $fields = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string'
        ]);

        $wish = Wish::create([
            'user_id' => auth()->user()->id,
            'title' => $fields['title'],
            'description' => $fields['description'],
        ]);

        return response()->json([
            'wish' => $wish
        ], 201);

    }

    // Edit fields of model
    public function edit(int $id, Request $request) {

        $editedWish = Wish::find($id);

        try {
            Gate::authorize('wish-belongs-to-user', [$editedWish]);
        } catch (AuthorizationException $exception) {
            return response()->json([
                'message' => $exception->getMessage()
            ], 403);
        }

        $fields = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'percentage_of_implementation' => 'required|numeric'
        ]);

        $editedWish->title = $fields['title'];
        $editedWish->description = $fields['description'];
        $editedWish->percentage_of_implementation = $fields['percentage_of_implementation'];
        $result = $editedWish->save();

        if(!$result) {
            return response()->json([
                'message' => 'Error while editing entity'
            ], 500);
        }

        return response()->json([
            'wish' => $editedWish
        ], 201);

    }

    public function archive(int $id) {

        $archivedWish = Wish::find($id);

        try {
            Gate::authorize('wish-belongs-to-user', [$archivedWish]);
        } catch (AuthorizationException $exception) {
            return response()->json([
                'message' => $exception->getMessage()
            ], 403);
        }

        $archivedWish->is_archived = true;
        $result = $archivedWish->save();

        if(!$result) {
            return response()->json([
                'message' => 'Error while add to archive entity'
            ], 500);
        }

        return response()->json([
            'wish' => $archivedWish
        ], 201);

    }
}

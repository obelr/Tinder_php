<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use OpenApi\Attributes as OA;

class LikeController extends Controller
{
    #[OA\Post(
        path: '/api/people/{id}/like',
        operationId: 'likePerson',
        summary: 'Like a person',
        tags: ['Likes'],
        parameters: [
            new OA\PathParameter(name: 'id', description: 'Person ID', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Person liked successfully',
                content: new OA\JsonContent(
                    type: 'object',
                    properties: [
                        'message' => new OA\Property(property: 'message', type: 'string'),
                        'data' => new OA\Property(property: 'data', type: 'object'),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Person not found'),
        ]
    )]
    public function like(Request $request, int $id)
    {
        $userId = $request->user()?->id ?? 1;

        $person = Person::findOrFail($id);

        $like = null;

        DB::transaction(function () use ($userId, $person, &$like) {
            $like = Like::lockForUpdate()->firstOrNew([
                'user_id' => $userId,
                'person_id' => $person->id,
            ]);

            $wasLiked = $like->exists && $like->liked;

            $like->fill(['liked' => true]);
            $like->save();

            if (! $wasLiked) {
                $person->increment('likes_count');
            }
        });

        return response()->json([
            'message' => 'Person liked',
            'data' => $like->load('person'),
        ]);
    }

    #[OA\Post(
        path: '/api/people/{id}/dislike',
        operationId: 'dislikePerson',
        summary: 'Dislike a person',
        tags: ['Likes'],
        parameters: [
            new OA\PathParameter(name: 'id', description: 'Person ID', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Person disliked successfully',
                content: new OA\JsonContent(
                    type: 'object',
                    properties: [
                        'message' => new OA\Property(property: 'message', type: 'string'),
                        'data' => new OA\Property(property: 'data', type: 'object'),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Person not found'),
        ]
    )]
    public function dislike(Request $request, int $id)
    {
        $userId = $request->user()?->id ?? 1;

        $person = Person::findOrFail($id);

        $like = null;

        DB::transaction(function () use ($userId, $person, &$like) {
            $like = Like::lockForUpdate()->firstOrNew([
                'user_id' => $userId,
                'person_id' => $person->id,
            ]);

            if ($like->exists && $like->liked && $person->likes_count > 0) {
                $person->decrement('likes_count');
            }

            $like->fill(['liked' => false]);
            $like->save();
        });

        return response()->json([
            'message' => 'Person disliked',
            'data' => $like->load('person'),
        ]);
    }

    #[OA\Get(
        path: '/api/liked',
        operationId: 'likedList',
        summary: 'List liked people',
        tags: ['Likes'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Liked people retrieved successfully',
                content: new OA\JsonContent(
                    type: 'object',
                    properties: [
                        'data' => new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(
                                type: 'object',
                                properties: [
                                    'id' => new OA\Property(property: 'id', type: 'integer'),
                                    'name' => new OA\Property(property: 'name', type: 'string'),
                                    'age' => new OA\Property(property: 'age', type: 'integer'),
                                    'pictures' => new OA\Property(property: 'pictures', type: 'array', items: new OA\Items(type: 'string')),
                                    'location' => new OA\Property(property: 'location', type: 'string'),
                                    'likes_count' => new OA\Property(property: 'likes_count', type: 'integer'),
                                ]
                            )
                        ),
                    ]
                )
            ),
        ]
    )]
    public function likedList(Request $request)
    {
        $userId = $request->user()?->id ?? 1;

        $liked = Like::with('person')
            ->where('user_id', $userId)
            ->where('liked', true)
            ->latest()
            ->get()
            ->pluck('person')
            ->filter()
            ->values();

        return response()->json([
            'data' => $liked,
        ]);
    }
}

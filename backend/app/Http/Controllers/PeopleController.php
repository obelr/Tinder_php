<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class PeopleController extends Controller
{
    #[OA\Get(
        path: '/api/people',
        operationId: 'listPeople',
        summary: 'List available people to swipe on',
        tags: ['People'],
        parameters: [
            new OA\QueryParameter(
                name: 'per_page',
                description: 'Number of people per page',
                required: false,
                schema: new OA\Schema(type: 'integer', default: 10)
            ),
            new OA\QueryParameter(
                name: 'page',
                description: 'Page number',
                required: false,
                schema: new OA\Schema(type: 'integer', default: 1)
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Paginated people list',
                content: new OA\JsonContent(
                    type: 'object',
                    properties: [
                        'current_page' => new OA\Property(property: 'current_page', type: 'integer'),
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
                        'per_page' => new OA\Property(property: 'per_page', type: 'integer'),
                        'total' => new OA\Property(property: 'total', type: 'integer'),
                    ]
                )
            )
        ]
    )]
    public function index(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);

        $people = Person::orderByDesc('created_at')->paginate($perPage);

        return response()->json($people);
    }
}

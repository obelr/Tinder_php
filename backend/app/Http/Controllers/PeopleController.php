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
                description: 'Paginated people list'
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

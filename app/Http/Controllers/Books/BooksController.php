<?php

namespace App\Http\Controllers\Books;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;

use App\Repositories\BookRepository;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * @OA\Info(
 *     description="API Documentation - Basic CRUD Laravel",
 *     version="1.0.0",
 *     title="Basic CRUD Laravel API Documentation",
 *     @OA\Contact(
 *         email="manirujjamanakash@gmail.com"
 *     ),
 *     @OA\License(
 *         name="GPL2",
 *         url="https://devsenv.com"
 *     )
 * )
 */

class BooksController extends Controller
{
    /**
     * Response trait to handle return responses.
     */
    use ResponseTrait;

    /**
     * Books Repository class.
     *
     * @var BooksRepository
     */
    public $bookRepository;

    public function __construct(BookRepository $bookRepository)
    {
        $this->middleware('auth:api', ['except' => ['indexAll']]);
        $this->bookRepository = $bookRepository;
    }

    /**
     * @OA\GET(
     *     path="/api/books",
     *     tags={"Books"},
     *     summary="Get Books List",
     *     description="Get Books List as Array",
     *     operationId="index",
     *     security={{"bearer":{}}},
     *     @OA\Response(response=200,description="Get Books List as Array"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(): JsonResponse
    {
        try {
            $data = $this->bookRepository->getAll();
            return $this->responseSuccess($data, 'Books List Fetch Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/books/view/all",
     *     tags={"Books"},
     *     summary="All Books - Publicly Accessible",
     *     description="All Books - Publicly Accessible",
     *     operationId="indexAll",
     *     @OA\Parameter(name="perPage", description="perPage, eg; 20", example=20, in="query", @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="All Books - Publicly Accessible" ),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function indexAll(Request $request): JsonResponse
    {
        try {
            $data = $this->bookRepository->getPaginatedData($request->perPage);
            return $this->responseSuccess($data, 'Books List Fetched Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/books/view/search",
     *     tags={"Books"},
     *     summary="All Books - Publicly Accessible",
     *     description="All Books - Publicly Accessible",
     *     operationId="search",
     *     @OA\Parameter(name="perPage", description="perPage, eg; 20", example=20, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter(name="search", description="search, eg; Test", example="Test", in="query", @OA\Schema(type="string")),
     *     @OA\Response(response=200, description="All Books - Publicly Accessible" ),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function search(Request $request): JsonResponse
    {
        try {
            $data = $this->bookRepository->searchBooks($request->search, $request->perPage);
            return $this->responseSuccess($data, 'Books List Fetched Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\POST(
     *     path="/api/books",
     *     tags={"Books"},
     *     summary="Create New Books",
     *     description="Create New Books",
     *     operationId="store",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="title", type="string", example="Books 1"),
     *              @OA\Property(property="description", type="string", example="Description"),
     *              @OA\Property(property="price", type="integer", example=10120),
     *              @OA\Property(property="file", type="string", example=""),
     *          ),
     *      ),
     *      security={{"bearer":{}}},
     *      @OA\Response(response=200, description="Create New Books" ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function store(BookRequest $request): JsonResponse
    {
        try {
            $book = $this->bookRepository->create($request->all());
            return $this->responseSuccess($book, 'New Books Created Successfully !');
        } catch (\Exception $exception) {
            return $this->responseError(null, $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/books/{id}",
     *     tags={"Books"},
     *     summary="Show Books Details",
     *     description="Show Books Details",
     *     operationId="show",
     *     security={{"bearer":{}}},
     *     @OA\Parameter(name="id", description="id, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Show Books Details"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show($id): JsonResponse
    {
        try {
            $data = $this->bookRepository->getByID($id);
            if (is_null($data)) {
                return $this->responseError(null, 'Books Not Found', Response::HTTP_NOT_FOUND);
            }

            return $this->responseSuccess($data, 'Books Details Fetch Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\PUT(
     *     path="/api/books/{id}",
     *     tags={"Books"},
     *     summary="Update Books",
     *     description="Update Books",
     *     @OA\Parameter(name="id", description="id, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="title", type="string", example="Books 1"),
     *              @OA\Property(property="description", type="string", example="Description"),
     *              @OA\Property(property="price", type="integer", example=10120),
     *              @OA\Property(property="file", type="string", example=""),
     *          ),
     *      ),
     *     operationId="update",
     *     security={{"bearer":{}}},
     *     @OA\Response(response=200, description="Update Books"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function update(BookRequest $request, $id): JsonResponse
    {
        try {
            $data = $this->bookRepository->update($id, $request->all());
            if (is_null($data))
                return $this->responseError(null, 'Books Not Found', Response::HTTP_NOT_FOUND);

            return $this->responseSuccess($data, 'Books Updated Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\DELETE(
     *     path="/api/books/{id}",
     *     tags={"Books"},
     *     summary="Delete Books",
     *     description="Delete Books",
     *     operationId="destroy",
     *     security={{"bearer":{}}},
     *     @OA\Parameter(name="id", description="id, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Delete Books"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroy($id): JsonResponse
    {
        try {
            $book =  $this->bookRepository->getByID($id);
            if (empty($book)) {
                return $this->responseError(null, 'Books Not Found', Response::HTTP_NOT_FOUND);
            }

            $deleted = $this->bookRepository->delete($id);
            if (!$deleted) {
                return $this->responseError(null, 'Failed to delete the book.', Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            return $this->responseSuccess($book, 'Books Deleted Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

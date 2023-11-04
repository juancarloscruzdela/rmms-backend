<?php

namespace App\Http\Controllers\Videos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\VideoRequest;

use App\Repositories\VideoRepository;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class VideosController extends Controller
{
    /**
     * Response trait to handle return responses.
     */
    use ResponseTrait;

    /**
     * Videos Repository class.
     *
     * @var VideosRepository
     */
    public $videoRepository;

    public function __construct(VideoRepository $videoRepository)
    {
        $this->middleware('auth:api', ['except' => ['indexAll']]);
        $this->videoRepository = $videoRepository;
    }

    /**
     * @OA\GET(
     *     path="/api/videos",
     *     tags={"Videos"},
     *     summary="Get Videos List",
     *     description="Get Videos List as Array",
     *     operationId="indexVideo",
     *     security={{"bearer":{}}},
     *     @OA\Response(response=200,description="Get Videos List as Array"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(): JsonResponse
    {
        try {
            $data = $this->videoRepository->getAll();
            return $this->responseSuccess($data, 'Videos List Fetch Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/videos/view/all",
     *     tags={"Videos"},
     *     summary="All Videos - Publicly Accessible",
     *     description="All Videos - Publicly Accessible",
     *     operationId="indexAllVideo",
     *     @OA\Parameter(name="perPage", description="perPage, eg; 20", example=20, in="query", @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="All Videos - Publicly Accessible" ),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function indexAll(Request $request): JsonResponse
    {
        try {
            $data = $this->videoRepository->getPaginatedData(500);
            return $this->responseSuccess($data, 'Videos List Fetched Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/videos/view/search",
     *     tags={"Videos"},
     *     summary="All Videos - Publicly Accessible",
     *     description="All Videos - Publicly Accessible",
     *     operationId="searchVideo",
     *     @OA\Parameter(name="perPage", description="perPage, eg; 20", example=20, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter(name="search", description="search, eg; Test", example="Test", in="query", @OA\Schema(type="string")),
     *     @OA\Response(response=200, description="All Videos - Publicly Accessible" ),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function search(Request $request): JsonResponse
    {
        try {
            $data = $this->videoRepository->searchVideos($request->search, 500);
            return $this->responseSuccess($data, 'Videos List Fetched Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\POST(
     *     path="/api/videos",
     *     tags={"Videos"},
     *     summary="Create New Videos",
     *     description="Create New Videos",
     *     operationId="storeVideo",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="title", type="string", example="Videos 1"),
     *              @OA\Property(property="description", type="string", example="Description"),
     *              @OA\Property(property="price", type="integer", example=10120),
     *              @OA\Property(property="file", type="string", example=""),
     *          ),
     *      ),
     *      security={{"bearer":{}}},
     *      @OA\Response(response=200, description="Create New Videos" ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function store(VideoRequest $request): JsonResponse
    {
        try {
            $video = $this->videoRepository->create($request->all());
            return $this->responseSuccess($video, 'New Videos Created Successfully !');
        } catch (\Exception $exception) {
            return $this->responseError(null, $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/videos/{id}",
     *     tags={"Videos"},
     *     summary="Show Videos Details",
     *     description="Show Videos Details",
     *     operationId="showVideo",
     *     security={{"bearer":{}}},
     *     @OA\Parameter(name="id", description="id, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Show Videos Details"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show($id): JsonResponse
    {
        try {
            $data = $this->videoRepository->getByID($id);
            if (is_null($data)) {
                return $this->responseError(null, 'Videos Not Found', Response::HTTP_NOT_FOUND);
            }

            return $this->responseSuccess($data, 'Videos Details Fetch Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\PUT(
     *     path="/api/videos/{id}",
     *     tags={"Videos"},
     *     summary="Update Videos",
     *     description="Update Videos",
     *     @OA\Parameter(name="id", description="id, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="title", type="string", example="Videos 1"),
     *              @OA\Property(property="description", type="string", example="Description"),
     *              @OA\Property(property="price", type="integer", example=10120),
     *              @OA\Property(property="file", type="string", example=""),
     *          ),
     *      ),
     *     operationId="updateVideo",
     *     security={{"bearer":{}}},
     *     @OA\Response(response=200, description="Update Videos"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function update(VideoRequest $request, $id): JsonResponse
    {
        try {
            $data = $this->videoRepository->update($id, $request->all());
            if (is_null($data))
                return $this->responseError(null, 'Videos Not Found', Response::HTTP_NOT_FOUND);

            return $this->responseSuccess($data, 'Videos Updated Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\DELETE(
     *     path="/api/videos/{id}",
     *     tags={"Videos"},
     *     summary="Delete Videos",
     *     description="Delete Videos",
     *     operationId="destroyVideo",
     *     security={{"bearer":{}}},
     *     @OA\Parameter(name="id", description="id, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Delete Videos"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroy($id): JsonResponse
    {
        try {
            $video =  $this->videoRepository->getByID($id);
            if (empty($video)) {
                return $this->responseError(null, 'Videos Not Found', Response::HTTP_NOT_FOUND);
            }

            $deleted = $this->videoRepository->delete($id);
            if (!$deleted) {
                return $this->responseError(null, 'Failed to delete the video.', Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            return $this->responseSuccess($video, 'Videos Deleted Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

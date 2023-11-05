<?php

namespace App\Http\Controllers\Devices;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeviceRequest;

use App\Repositories\DeviceRepository;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class DevicesController extends Controller
{
    /**
     * Response trait to handle return responses.
     */
    use ResponseTrait;

    /**
     * Devices Repository class.
     *
     * @var DevicesRepository
     */
    public $deviceRepository;

    public function __construct(DeviceRepository $deviceRepository)
    {
        $this->middleware('auth:api', ['except' => ['indexAll']]);
        $this->deviceRepository = $deviceRepository;
    }

    /**
     * @OA\GET(
     *     path="/api/devices",
     *     tags={"Devices"},
     *     summary="Get Devices List",
     *     description="Get Devices List as Array",
     *     operationId="indexDevices",
     *     security={{"bearer":{}}},
     *     @OA\Response(response=200,description="Get Devices List as Array"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(): JsonResponse
    {
        try {
            $data = $this->deviceRepository->getAll();
            return $this->responseSuccess($data, 'Devices List Fetch Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/devices/view/all",
     *     tags={"Devices"},
     *     summary="All Devices - Publicly Accessible",
     *     description="All Devices - Publicly Accessible",
     *     operationId="indexAllDevices",
     *     @OA\Parameter(name="perPage", description="perPage, eg; 20", example=20, in="query", @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="All Devices - Publicly Accessible" ),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function indexAll(Request $request): JsonResponse
    {
        try {
            $data = $this->deviceRepository->getPaginatedData(70);
            return $this->responseSuccess($data, 'Devices List Fetched Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/devices/view/search",
     *     tags={"Devices"},
     *     summary="All Devices - Publicly Accessible",
     *     description="All Devices - Publicly Accessible",
     *     operationId="searchDevice",
     *     @OA\Parameter(name="perPage", description="perPage, eg; 20", example=20, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter(name="search", description="search, eg; Test", example="Test", in="query", @OA\Schema(type="string")),
     *     @OA\Response(response=200, description="All Devices - Publicly Accessible" ),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function search(Request $request): JsonResponse
    {
        try {
            $data = $this->deviceRepository->searchDevice($request->search, 70);
            return $this->responseSuccess($data, 'Devices List Fetched Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\POST(
     *     path="/api/devices",
     *     tags={"Devices"},
     *     summary="Create New Devices",
     *     description="Create New Devices",
     *     operationId="storeDevices",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="ip", type="string", example="Devices 1"),
     *          ),
     *      ),
     *      security={{"bearer":{}}},
     *      @OA\Response(response=200, description="Create New Devices" ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function store(DeviceRequest $request): JsonResponse
    {
        try {
            $device = $this->deviceRepository->create($request->all());
            return $this->responseSuccess($device, 'New Devices Created Successfully !');
        } catch (\Exception $exception) {
            return $this->responseError(null, $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/devices/{id}",
     *     tags={"Devices"},
     *     summary="Show Devices Details",
     *     description="Show Devices Details",
     *     operationId="showDevices",
     *     security={{"bearer":{}}},
     *     @OA\Parameter(name="id", description="id, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Show Devices Details"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show($id): JsonResponse
    {
        try {
            $data = $this->deviceRepository->getByID($id);
            if (is_null($data)) {
                return $this->responseError(null, 'Devices Not Found', Response::HTTP_NOT_FOUND);
            }

            return $this->responseSuccess($data, 'Devices Details Fetch Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\PUT(
     *     path="/api/devices/{id}",
     *     tags={"Devices"},
     *     summary="Update Devices",
     *     description="Update Devices",
     *     @OA\Parameter(name="id", description="id, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="ip", type="string", example="Devices 1"),
     *          ),
     *      ),
     *     operationId="updateDevices",
     *     security={{"bearer":{}}},
     *     @OA\Response(response=200, description="Update Devices"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function update(DeviceRequest $request, $id): JsonResponse
    {
        try {
            $data = $this->deviceRepository->update($id, $request->all());
            if (is_null($data))
                return $this->responseError(null, 'Devices Not Found', Response::HTTP_NOT_FOUND);

            return $this->responseSuccess($data, 'Devices Updated Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\DELETE(
     *     path="/api/devices/{id}",
     *     tags={"Devices"},
     *     summary="Delete Devices",
     *     description="Delete Devices",
     *     operationId="destroyDevices",
     *     security={{"bearer":{}}},
     *     @OA\Parameter(name="id", description="id, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Delete Devices"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroy($id): JsonResponse
    {
        try {
            $device =  $this->deviceRepository->getByID($id);
            if (empty($device)) {
                return $this->responseError(null, 'Devices Not Found', Response::HTTP_NOT_FOUND);
            }

            $deleted = $this->deviceRepository->delete($id);
            if (!$deleted) {
                return $this->responseError(null, 'Failed to delete the device.', Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            return $this->responseSuccess($device, 'Devices Deleted Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

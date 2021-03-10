<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatetruckAPIRequest;
use App\Http\Requests\API\UpdatetruckAPIRequest;
use App\Models\truck;
use App\Repositories\truckRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class truckController
 * @package App\Http\Controllers\API
 */

class truckAPIController extends AppBaseController
{
    /** @var  truckRepository */
    private $truckRepository;

    public function __construct(truckRepository $truckRepo)
    {
        $this->truckRepository = $truckRepo;
    }

    /**
     * Display a listing of the truck.
     * GET|HEAD /trucks
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->truckRepository->pushCriteria(new RequestCriteria($request));
        $this->truckRepository->pushCriteria(new LimitOffsetCriteria($request));
        $trucks = $this->truckRepository->all();

        return $this->sendResponse($trucks->toArray(), 'Trucks retrieved successfully');
    }

    /**
     * Store a newly created truck in storage.
     * POST /trucks
     *
     * @param CreatetruckAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatetruckAPIRequest $request)
    {
        $input = $request->all();

        $trucks = $this->truckRepository->create($input);

        return $this->sendResponse($trucks->toArray(), 'Truck saved successfully');
    }

    /**
     * Display the specified truck.
     * GET|HEAD /trucks/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var truck $truck */
        $truck = $this->truckRepository->findWithoutFail($id);

        if (empty($truck)) {
            return $this->sendError('Truck not found');
        }

        return $this->sendResponse($truck->toArray(), 'Truck retrieved successfully');
    }

    /**
     * Update the specified truck in storage.
     * PUT/PATCH /trucks/{id}
     *
     * @param  int $id
     * @param UpdatetruckAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatetruckAPIRequest $request)
    {
        $input = $request->all();

        /** @var truck $truck */
        $truck = $this->truckRepository->findWithoutFail($id);

        if (empty($truck)) {
            return $this->sendError('Truck not found');
        }

        $truck = $this->truckRepository->update($input, $id);

        return $this->sendResponse($truck->toArray(), 'truck updated successfully');
    }

    /**
     * Remove the specified truck from storage.
     * DELETE /trucks/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var truck $truck */
        $truck = $this->truckRepository->findWithoutFail($id);

        if (empty($truck)) {
            return $this->sendError('Truck not found');
        }

        $truck->delete();

        return $this->sendResponse($id, 'Truck deleted successfully');
    }
}

<?php namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;

use App\Http\Requests\CreatetruckRequest;
use App\Http\Requests\UpdatetruckRequest;
use App\Repositories\truckRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use app\Models\truck;


class truckController extends AppBaseController
{
    /** @var  truckRepository */
    private $truckRepository;

    public function __construct(truckRepository $truckRepo)
    {
        $this->truckRepository = $truckRepo;
    }

    public function changeStatus ()
    {
      $id = Input::get('id');

      $truck = Truck::findOrFail($id);
      $truck->favorite = !$truck->favorite;
      $truck->save();

      return response()->json($truck);
    }

    /**
     * Display a listing of the truck.
     * @param Request $request
     * @return Response
     */

    public function index(Request $request)
    {
        $this->truckRepository->pushCriteria(new RequestCriteria($request));
        $trucks = $this->truckRepository->all();

        return view('trucks.index')
            ->with('trucks', $trucks);
    }
    /**
     * Show the form for creating a new truck.
     * @return Response
     */
    public function create()
    {
        return view('trucks.create');
    }

    /**
     * Store a newly created truck in storage.
     * @param CreatetruckRequest $request
     * @return Response
     */
    public function store(CreatetruckRequest $request)
    {
        $input = $request->all();
        $truck = $this->truckRepository->create($input);
        Flash::success('Truck saved successfully.');
        return redirect(route('trucks.post'));
    }

    /**
     * Display the specified truck.
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $truck = $this->truckRepository->findWithoutFail($id);

        if (empty($truck))
         {
            Flash::error('Truck not found');

            return redirect(route('trucks.index'));
          }
        return view('trucks.show')->with('truck', $truck);
    }

    /**
     * Show the form for editing the specified truck.
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $truck = $this->truckRepository->findWithoutFail($id);

        if (empty($truck))
        {
            Flash::error('Truck not found');
            return redirect(route('trucks.index'));
        }
        return view('trucks.edit')->with('truck', $truck);
    }

      /**
     * Update the specified truck in storage.
     *
     * @param  int              $id
     * @param UpdatetruckRequest $request
     * @return Response
     */
    public function update($id, UpdatetruckRequest $request)
    {
        $truck = $this->truckRepository->findWithoutFail($id);

        if (empty($truck))
        {
          Flash::error('Truck not found');
          return redirect(route('trucks.index'));
        }

        $truck = $this->truckRepository->update($request->all(), $id);
        Flash::success('Truck updated successfully.');
        return redirect(route('trucks.index'));
    }
    /**
     * Remove the specified truck from storage.     *
     * @param  int $id     *
     * @return Response
     */
    public function destroy($id)
    {
        $truck = $this->truckRepository->findWithoutFail($id);
        if (empty($truck))
         {
            Flash::error('Truck not found');
            return redirect(route('trucks.index'));
          }
        $this->truckRepository->delete($id);
        Flash::success('Truck deleted successfully.');
        return redirect(route('trucks.index'));
    }
}

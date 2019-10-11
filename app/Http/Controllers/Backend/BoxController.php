<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Boxes\EditBoxRequest;
use App\Http\Requests\Backend\Boxes\ManageBoxRequest;
use App\Http\Requests\Backend\Boxes\StoreBoxRequest;
use App\Http\Requests\Backend\Boxes\UpdateBoxRequest;
use App\Models\Box;
use App\Repositories\Backend\BoxRepository;
use Illuminate\Http\Request;
use PragmaRX\Countries\Package\Countries;

class BoxController extends Controller
{
//    /**
//     * Create a new token for the user.
//     *
//     * @return string
//     */
//    public function createNewToken()
//    {
//        return hash_hmac('sha256', Str::random(40), $this->hashKey);
//    }
    /**
     * @var BoxRepository
     */
    protected $boxRepository;

    /**
     * @param BoxRepository $boxRepository
     */
    public function __construct(BoxRepository $boxRepository)
    {
        $this->boxRepository = $boxRepository;
//        $this->middleware('permission:view box', ['only' => ['view', 'manage', 'index','updateActiveBox']]);
//        $this->middleware('role:'.config('access.users.box_admin_role'), ['only' => 'destroy']);
//        $this->middleware('permission:update box|edit box', ['only' => ['create', 'store', 'edit', 'update']]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function updateActiveBox(Request $request){

        $boxID = $request->input('active-box');
        $box = Box::find($boxID);

        if(auth()->user()->getAllBoxes()->contains('id', $box->id)){
            session(['active_box' => $box]);
            if(fnmatch("*/admin/boxes/*/view",$request->headers->get('referer'))){
                return redirect()->route('admin.boxes.view', $box)->withFlashSuccess("Updated Active Box");
            }
            return redirect()->back()->withFlashSuccess("Updated Active Box");
        }
        return redirect()->back()->withFlashWarning("You don\'t have permission to do that.");
    }

    /**
     *
     * @return mixed
     */
    public function index()
    {
        return view('backend.boxes.index')
            ->withBoxes(auth()->user()->getAllBoxes());
    }

    /**
     * Show the page of a specific
     *
     * @param ManageBoxRequest $request
     * @param Box $box
     * @return \Illuminate\Http\Response
     */
    public function view(ManageBoxRequest $request, Box $box)
    {
        return view('backend.boxes.box')->withBox($box);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.boxes.create');
    }

    /**
     * @param  StoreBoxRequest  $request
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function store(StoreBoxRequest $request)
    {
        $this->boxRepository->create($request->only('name',
            'short_description',
            'long_description',
            'address_line_1',
            'address_line_2',
            'city',
            'state',
            'zip',
            'country',
            'is_active'
        ));

        return redirect()->route('admin.boxes.index')->withFlashSuccess(__('alerts.backend.boxes.created'));
    }

    /**
     * @param EditBoxRequest $request
     * @param Box $box
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(EditBoxRequest $request, Box $box)
    {
        return view('backend.boxes.edit')
            ->withBox($box);
    }

    /**
     * @param  UpdateBoxRequest  $request
     * @param  Box  $box
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function update(UpdateBoxRequest $request, Box $box)
    {

        $request['is_active'] = isset($request['is_active']) ? $request['is_active'] : false;

        $this->boxRepository->update($box, $request->only(
            'name',
            'short_description',
            'long_description',
            'address_line_1',
            'address_line_2',
            'city',
            'state',
            'zip',
            'country',
            'is_active'));

        return redirect()->route('admin.boxes.index')->withFlashSuccess(__('alerts.backend.boxes.updated'));
    }

    /**
     * @param ManageBoxRequest $request
     * @param Box              $box
     *
     * @throws \Exception
     * @return mixed
     */
    public function destroy(ManageBoxRequest $request, Box $box)
    {
        $this->boxRepository->deleteById($box->id);

        return redirect()->route('admin.boxes.index')->withFlashSuccess(__('alerts.backend.boxes.deleted'));
    }
}

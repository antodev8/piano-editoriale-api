<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditorialProjectDestroyRequest;
use App\Http\Requests\EditorialProjectIndexRequest;
use App\Http\Requests\EditorialProjectShowRequest;
use App\Http\Requests\EditorialProjectStoreRequest;
use App\Http\Requests\EditorialProjectUpdateRequest;
use App\Http\Resources\EditorialProjectResource;
use App\Jobs\StoreEditorialProjectLogJob;
use App\Models\EditorialProject;
use App\Models\EditorialProjectLog;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EditorialProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(EditorialProjectIndexRequest $request): AnonymousResourceCollection
    {
        $per_page = $request->query('per_page') ?: 15;

        $editorial_projects = EditorialProject::query();

        // Filter by text
        if ($text = $request->query('text')) {
            $editorial_projects->where(function ($query) use ($text) {
                $query->where('title', 'like', '%' . $text . '%');
            });
        }

        // Filter by trashed 
        if ($request->has('trashed')) {
            switch ($request->query('trashed')) {
                case 'with':
                    $editorial_projects->withTrashed();
                    break;
                case 'only':
                    $editorial_projects->onlyTrashed();
                    break;
                default:
                    $editorial_projects->withTrashed();
            }
        }

        $editorial_projects = $editorial_projects->paginate((int)$per_page);

        // Include relationship
        if ($request->has('with')) {
            $editorial_projects->load($request->query('with'));
        }

        return EditorialProjectResource::collection($editorial_projects);

}
/**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EditorialProjectStoreRequest $request): EditorialProjectResource
    {
      db::beginTransaction();

      try {

       $editorial_projects = new EditorialProjects();
       $editorial_projects = title = $request->title;
       $editorial_projects = pubblication_date = $request->pubblication_date;
       $editorial_projects = pages = $request->pages;
       $editorial_projects = price = $request->price;
       $editorial_projects = cost = $request->cost;
       $editorial_projects = author_id = $request->has(author_id) ? $request -> author_id : auth::id();
       $editorial_projects = sector_id = $request->sector_id;
       $editorial_projects->save();
       
       

      

    db::commit();  
    }
    catch(Exception $exception){
        db::rollBack();
        throw $exception;
        
    }
    
    return new EditorialProjectResource($editorial_projects);

       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(EditorialProjectShowRequest $request, EditorialProject $editorial_project):EditorialProjectResource
    {
        // Include relationship
        if ($request->query('with')) {
            $editorial_project->load($request->query('with'));
        }

        return new EditorialProjectResource($editorial_project);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditorialProjectUpdateRequest $request, EditorialProject $editorial_project): EditorialProjectResource
    {

        DB::beginTransaction();

        try {

            $editorial_project->update($request->only(['title', 'sector_id', 'is_approved_by_ceo']));

            //StoreEditorialProjectLogJob::dispatchAfterResponse(Auth::id(), $editorial_project->id, EditorialProjectLog::ACTION_UPDATE);

            DB::commit();
        } catch (Exception $exception) {

            DB::rollBack();
            throw $exception;
        }

        return new EditorialProjectResource($editorial_project);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $editorial_project->delete(EditorialProjectDestroyRequest $request, EditorialProject $editorial_project): Response

        //StoreEditorialProjectLogJob::dispatchAfterResponse(Auth::id(), $editorial_project->id, EditorialProjectLog::ACTION_DESTROY);

        return response(null, 204);
    }
}

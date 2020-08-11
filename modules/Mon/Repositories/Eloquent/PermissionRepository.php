<?php
namespace Modules\Mon\Repositories\Eloquent;

use \Modules\Mon\Repositories\Eloquent\BaseRepository;
use Modules\Mon\Repositories\PermissionRepository as PermissionRepositoryInterface;
use Illuminate\Http\Request;

class PermissionRepository extends BaseRepository implements PermissionRepositoryInterface {

    public function create($data)
    {
        $permission = $this->model->create($data);
        $permission->description = $data['description'];
        $permission->save();
        return $permission;
    }

    public function update($model, $data)
    {
        $model->update($data);
        $model->description = $data['description'];
        $model->save();
        return $model;
    }
    public function serverPagingFor(Request $request, $relations = null)
    {
        $query = $this->newQueryBuilder();
        if ($relations) {
            $query = $query->with($relations);
        }

        if ($request->get('search') !== null) {
            $keyword = $request->get('search');
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'LIKE', "%{$keyword}%")
                    ->orWhere('guard_name', 'LIKE', "%{$keyword}%")
                    ->orWhere('id', 'LIKE', "%{$keyword}%");
            });
        }

        if ($request->get('guard_name') !== null) {
            $query->where('guard_name', '=', $request->get('guard_name'));
        }
        if ($request->get('role_id') !== null) {
            $in_role =$request->get('in_role') ;
            if ( $in_role !== null) {
                if ($in_role) {
                    $query->whereHas('roles', function ($query) use ($request) {
                        $query->where('id', '=', $request->get('role_id'));
                    });
                } else {
                    $query->whereDoesntHave('roles', function ($query) use ($request){
                        $query->where('id', '=', $request->get('role_id'));
                    });
                }
            }else {
                $query->whereHas('roles', function ($query) use ($request) {
                    $query->where('id', '=', $request->get('role_id'));
                });
            }

        }

        if ($request->get('name') !== null) {
            $query->where('name', '=', $request->get('name'));
        }
        $query->select('permissions.*');

        return $query->paginate($request->get('per_page', 10));
    }
}

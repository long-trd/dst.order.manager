<?php

namespace Cms\Modules\Core\Repositories;

use Carbon\Carbon;
use Cms\Modules\Core\Models\Site;
use Cms\Modules\Core\Repositories\Contracts\SiteRepositoryContract;
use Illuminate\Support\Facades\DB;

class SiteRepository implements SiteRepositoryContract
{
    protected $model;

    public function __construct(Site $model) {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->get();
    }

    public function paginate($data)
    {
        return $this->model->with('user')->paginate($data);
    }

    public function store($data)
    {
        return $this->model->create($data);
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function update($id, $data)
    {
        return $this->model->find($id)->update($data);
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    public function findByQuery($request, $paginate)
    {
        $searchName = $request['name'] ?? null;
        $searchUser = $request['user'] ?? null;
        $searchStatus = $request['status'] ?? null;
        $query = $this->model;

        if ($searchName) {
            $query = $query->where('name', 'like', '%' . $searchName . '%');
        }

        if ($searchStatus) {
            $query = $query->where('status', $searchStatus);
        }

        if ($searchUser) {
            $query = $query->where('user_id', $searchUser);
        }

        if (isset($request['start_date']) && isset($request['end_date'])) {
            $startDate = Carbon::parse($request['start_date'])->startOfDay();
            $endDate = Carbon::parse($request['end_date'])->endOfDay();
            $query = $query->whereBetween('created_at', [$startDate, $endDate]);
        } elseif (isset($request['start_date'])) {
            $startDate = Carbon::parse($request['start_date'])->startOfDay();
            $endDate = Carbon::now()->endOfDay();
            $query = $query->whereBetween('created_at', [$startDate, $endDate]);
        } elseif (isset($request['end_date'])) {
            $startDate = Carbon::now()->startOfDay();
            $endDate = Carbon::parse($request['end_date'])->endOfDay();
            $query = $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        $sites = $query->paginate($paginate);

        return $sites;
    }

    public function getActiveSite()
    {
        return $this->model
            ->whereIn('status', ['live', 'pause'])
            ->get();
    }
}


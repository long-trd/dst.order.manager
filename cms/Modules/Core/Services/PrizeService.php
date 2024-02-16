<?php

namespace Cms\Modules\Core\Services;

use Carbon\Carbon;
use Cms\Modules\Core\Repositories\Contracts\PrizeRepositoryContract;
use Cms\Modules\Core\Services\Contracts\PrizeServiceContract;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PrizeService implements PrizeServiceContract
{
    protected $repository;

    function __construct
    (
        PrizeRepositoryContract $repository
    )
    {
        $this->repository = $repository;
    }

    public function paginate()
    {
        return $this->repository->paginate();
    }

    public function getAll()
    {
        return $this->repository->getAll();
    }

    public function find($id)
    {
        return $this->repository->find($id);
    }

    public function store($request)
    {
        $data = $request->all();
        $data['img'] = $request->hasFile('img') ? $this->uploadImage($request->img) : null;
        $prize = $this->repository->store($data);

        return $prize;
    }

    public function update($id, $request)
    {
        $prize = $this->repository->find($id);
        $data = $request->all();
        $data['img'] = $request->hasFile('img') ? $this->uploadImage($request->img, $prize->img) : $prize->img;
        $prize = $this->repository->update($id, $data);

        return $prize;
    }

    public function uploadImage($file, $oldFile = null)
    {
        if ($file) {
            if (File::exists(public_path($oldFile)))
                File::delete(public_path($oldFile));

            $imageExtension = $file->getClientOriginalExtension();
            $imageName = Carbon::now()->timestamp .'_' . Str::random(11) . '.' . $imageExtension;

            $file->move(public_path() . '/lucky-wheel', $imageName);;

            return '/lucky-wheel/' . $imageName;
        }

        return $oldFile ?? null;
    }

    public function delete($id)
    {
        $prize = $this->repository->find($id);

        if (File::exists(public_path($prize->img)))
            File::delete(public_path($prize->img));

        return $prize->delete();
    }

    public function getPrizeByWheelEventId($wheelEventId)
    {
        return $this->repository->getPrizeByWheelEventId($wheelEventId);
    }

    public function countPrizeByUser($userId, $wheelEventId)
    {
        return $this->repository->countPrizeByUser($userId, $wheelEventId);
    }
}


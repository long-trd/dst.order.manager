<?php

namespace Cms\Modules\Core\Services;

use Carbon\Carbon;
use Cms\Modules\Core\Repositories\Contracts\SiteLogRepositoryContract;
use Cms\Modules\Core\Services\Contracts\SiteLogServiceContract;

class SiteLogSerivce implements SiteLogServiceContract
{
    protected $repository;

    function __construct
    (
        SiteLogRepositoryContract $repository
    )
    {
        $this->repository = $repository;
    }

    public function getAll()
    {
        return $this->repository->getAll();
    }

    public function store($site, $type)
    {
        $time = Carbon::now();

        if ($type === 'created') {
            if (auth()->user()->hasRole('admin')) {
                $data['site_id'] = $site['id'];
                $data['editor_id'] = auth()->id();
                $data['message'] = 'Admin created site for '.$site->user->name.'('.$site->user->email.')'.' at ' . $time;
                $data['created_at'] = $time;
            } else {
                $data['site_id'] = $site['id'];
                $data['editor_id'] = $site['user_id'];
                $data['message'] = $site->user->name.'('.$site->user->email.')'.' created site at ' . $time;
                $data['created_at'] = $time;
            }
        } else {
            if (auth()->user()->hasRole('admin')) {
                $data['site_id'] = $site['id'];
                $data['editor_id'] = auth()->id();
                $data['message'] = 'Admin updated site for '.$site->user->name.'('.$site->user->email.')'.' at ' . $time;
                $data['created_at'] = $time;
            } else {
                $data['site_id'] = $site['id'];
                $data['editor_id'] = $site['user_id'];
                $data['message'] = $site->user->name.'('.$site->user->email.')'.' updated site at ' . $site->created_at;
                $data['created_at'] = $time;
            }
        }

        return $this->repository->store($data);
    }
}


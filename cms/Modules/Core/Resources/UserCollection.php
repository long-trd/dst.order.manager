<?php

namespace Cms\Modules\Core\Resources;

use Cms\Modules\Core\Models\User;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{

    public $collects = User::class;

    public function __construct($resource)
    {
        $this->resource = $resource;
    }

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'email' => $this->resource->email,
            'timesSpin' => count($this->resource->prize) ? 0 : 1,
            'gift' => isset($this->resource->prize[0]) ? ($this->resource->prize[0]->text . $this->resource->prize[0]->unit) : null
        ];
    }
}

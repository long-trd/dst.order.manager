<?php

namespace Cms\Modules\Core\Controllers\Admin;

use Cms\Modules\Core\Services\Contracts\UserServiceContract;
use Illuminate\Http\Request;

class NoteController
{
    protected $userService;

    public function __construct(UserServiceContract $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        return view('Core::note.index');
    }

    public function update(Request $request)
    {
        if (isset($request->notes))
            $this->userService->updateNote(auth()->user()->id, ['notes' => $request->notes]);

        return redirect()->route('admin.note.index');
    }
}

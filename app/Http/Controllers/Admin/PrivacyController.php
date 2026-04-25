<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPrivacyRequest;
use App\Http\Requests\StorePrivacyRequest;
use App\Http\Requests\UpdatePrivacyRequest;
use App\Models\Privacy;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PrivacyController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('privacy_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $privacies = Privacy::all(); 

        return view('admin.privacies.index', compact('privacies'));
    }

    public function create()
    {
        abort_if(Gate::denies('privacy_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.privacies.create');
    }

    public function store(StorePrivacyRequest $request)
    {
        $privacy = Privacy::create($request->all());

        return redirect()->route('admin.privacies.index');
    }

    public function edit(Privacy $privacy)
    {
        abort_if(Gate::denies('privacy_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.privacies.edit', compact('privacy'));
    }

    public function update(UpdatePrivacyRequest $request, Privacy $privacy)
    {
        $privacy->update($request->all());

        return redirect()->route('admin.privacies.index');
    }

    public function show(Privacy $privacy)
    {
        abort_if(Gate::denies('privacy_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $privacy->load('privacyEvents');

        return view('admin.privacies.show', compact('privacy'));
    }

    public function destroy(Privacy $privacy)
    {
        abort_if(Gate::denies('privacy_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $privacy->delete();

        return back();
    }

    public function massDestroy(MassDestroyPrivacyRequest $request)
    {
        $privacies = Privacy::find(request('ids'));

        foreach ($privacies as $privacy) {
            $privacy->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

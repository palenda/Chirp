<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class ChirpController extends Controller
{
    public function index()
    {
        return view('chirps.index', [
            'chirps' => Chirp::with('user')->latest()->get(),
        ]);
    }

    public function create()
    {
        //
    }


    public function store(Request $request): \Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);

        $request->user()->chirps()->create($validated);

        return redirect(route('chirps.index'));
    }


    public function show(Chirp $chirp)
    {
        //
    }


    /**
     * @throws AuthorizationException
     */
    public function edit(Chirp $chirp): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $this->authorize('update', $chirp);

        return view('chirps.edit', [
            'chirp' => $chirp,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Chirp $chirp
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws AuthorizationException
     */
    public function update(Request $request, Chirp $chirp): \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
    {
        $this->authorize('update', $chirp);

        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);

        $chirp->update($validated);

        return redirect(route('chirps.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Chirp $chirp
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws AuthorizationException
     */
    public function destroy(Chirp $chirp): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $this->authorize('delete', $chirp);
        $chirp->delete();
        return redirect(route('chirps.index'));
    }
}

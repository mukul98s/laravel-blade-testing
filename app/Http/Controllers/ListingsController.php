<?php

namespace App\Http\Controllers;

use App\Models\Listing;

class ListingsController extends Controller
{
    //    show all the listing
    public function index()
    {
        return view('listings.index', [
            'listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(4)
        ]);
    }

    //    show a single listing
    public function show(Listing $listing)
    {
        return view('listings.show', [
            'listing' => $listing
        ]);
    }

    public function edit(Listing $listing)
    {
        return view('listings.edit', [
            'listing' => $listing
        ]);
    }

    public function update(Listing $listing)
    {

        if ($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $formFields = request()->validate([
            'title' => 'required',
            'company' => 'required',
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if (request()->hasFile('logo')) {
            $formFields['logo'] = request()->file('logo')->store('logos', 'public');
        }


        $listing->update($formFields);

        return redirect('/listing/' . $listing->id)->with('message', 'Job Updated Successfully');
    }

    public function store()
    {
        $formFields = request()->validate([
            'title' => 'required',
            'company' => 'required',
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if (request()->hasFile('logo')) {
            $formFields['logo'] = request()->file('logo')->store('logos', 'public');
        }

        $formFields['user_id'] = auth()->id();

        Listing::create($formFields);

        return redirect('/')->with('message', 'Job Posted Successfully');
    }

    public function create()
    {
        return view('listings.create');
    }

    public function destroy(Listing $listing)
    {
        if ($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $listing->delete();
        return redirect('/')->with('message', 'Job Removed');
    }

    public function manager()
    {
        return view('listings.manager', [
            'listing' => auth()->user()->listings()->get()
        ]);
    }
}

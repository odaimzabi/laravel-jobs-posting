<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    //Show all listings
    public function index(Request $req)
    {
        return view('listings.index', ['listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(5)]);
    }

    //Show single listing
    public function show(Listing $listing)
    {
        return view('listings.show', ['listing' => $listing]);
    }
    //Show create form
    public function create()
    {
        return view('listings.create');
    }

    //Store listing
    public function store(Request $req)
    {
        $formFields = $req->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        Listing::create($formFields);
        return redirect('/')->with('message', 'Listing created sucessfully');
    }

    public function edit(Listing $listing)
    {
        return view('listings.edit', ["listing" => $listing]);
    }

    public function update(Request $req, Listing $listing)
    {
        $formFields = $req->validate([
            'title' => 'required',
            'company' => ['required'],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        $listing->update($formFields);
        return back()->with('message', 'Listing updated sucessfully');
    }

    public function destroy(Listing $listing)
    {
        $listing->delete();
        return redirect('/')->with('message', 'Listing deleted sucessfully');
    }
}

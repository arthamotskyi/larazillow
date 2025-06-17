<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class RealtorListingController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('viewAny',Listing::class);
        $filters = [
            'deleted' => $request->boolean('deleted')
        ];
        return inertia('Realtor/Index',
            ['listings' => Auth::user()->listings()->mostRecent()->filter($filters)->get()]
        );
    }

    public function destroy(Listing $listing)
    {
        Gate::authorize('delete',$listing);
        $listing->deleteOrFail();

        return redirect()->back()
            ->with('success', 'Listing was deleted!');
    }
}

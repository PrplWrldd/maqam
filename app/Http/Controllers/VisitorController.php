<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grave;

class VisitorController extends Controller
{
    /**
     * Show the main page with map and search bar.
     */
    public function index()
    {
        // Fetch graves data from the database
        $graves = Grave::all(['name', 'gps_lat', 'gps_lng', 'date_of_death', 'plot_number']);

        // Pass the graves data to the view
        return view('visitor.index', compact('graves'));
    }

    /**
     * Search graves by name, date, or other fields.
     */
    public function search(Request $request)
{
    $query = $request->input('query');

    // Perform search
    $results = Grave::where('name', 'LIKE', "%{$query}%")
        ->orWhere('ic_number', 'LIKE', "%{$query}%")
        ->orWhere('plot_number', 'LIKE', "%{$query}%")
        ->orWhere('date_of_death', 'LIKE', "%{$query}%")
        ->get(['id','ic_number','name', 'date_of_death', 'plot_number', 'gps_lat', 'gps_lng']);

    // Save search term in session
    if ($query) {
        $recentSearches = session('recent_searches', []);
        if (!in_array($query, $recentSearches)) {
            session()->push('recent_searches', $query);
        }
    }

    // Return results as JSON
    return response()->json($results);
}

    /**
     * Show grave details by ID.
     */
    public function show($id)
    {
        $grave = Grave::findOrFail($id);

        return view('visitor.show', compact('grave'));
    }

    /**
     * Clear recent search history.
     */
    public function clearHistory()
    {
        session()->forget('recent_searches');

        return redirect()->back()->with('status', 'Search history cleared.');
    }
}
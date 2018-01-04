<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\IntegerConversionInterface;
use App\Conversion;
use App\Transformers\RecentTransformer;
use App\Transformers\TopTransformer;
use Carbon\Carbon;
use DB;

class ApiController extends Controller
{
	public function __construct(IntegerConversionInterface $conversion)
	{
		$this->conversion = $conversion;
	}
	
    public function convert(Request $request)
    {
		$integer = $request->input('integer');
		
		// Convert integer to roman numerals
		try {
			$roman_numeral = $this->conversion->toRomanNumerals($integer);
		} catch (\Exception $e) {
			return response()->json(array('error' => $e->getMessage()));
		}
		
		// Save to database
		$conversion = new Conversion;
		
		$conversion->integer = $integer;
		$conversion->roman_numeral = $roman_numeral;
		
		$conversion->save();
		
		// Response
		return response()->json(array('integer' => $integer, 'roman_numeral' => $roman_numeral));
    }
    
    public function recent()
    {
	    // Get todays conversions
	    $recent = Conversion::whereDate('created_at', '=', Carbon::today()->toDateString())->orderBy('created_at', 'DESC')->get();
	    
	    //Transform
	    $recent = fractal($recent, new RecentTransformer())->toArray();
	    
	    // Response
	    return response()->json($recent);
	}
	
	public function top()
    {
	    // Get top conversions
	    $top = Conversion::groupBy('integer')->select('*', DB::raw('count(*) as conversions'))->orderBy('conversions', 'DESC')->limit(10)->get();
	    
	    // Get last conversion
	    foreach($top as $entry) {
		    $last = Conversion::where('integer', $entry->integer)->orderBy('created_at', 'DESC')->first();
		    $entry->last_converted_at = $last->created_at;
	    }
	    
	    // Transform
	    $top = fractal($top, new TopTransformer())->toArray();
	    
	    // Response
	    return response()->json($top);
	}
}
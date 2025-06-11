<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Jenssegers\Agent\Facades\Agent;
use App\Models\{ClientPreference, Category, Vendor, Product, Page, Brand, ContactUs};
use Redirect;

class HomeController extends Controller
{

	public function contactUs()
    {
        return view('frontend.pages.contact-us');
    }


	public function storeContactInquiry(Request $request)
    {
		 
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'description' => 'nullable|string|min:10',
            ]);
			 
			if (ContactUs::where('email', $request->email)->exists()) {
				return redirect()->back()->with('error', 'Your inquiry already submitted !');
			}
            $contactInquiry = new ContactUs();
            $contactInquiry->name = $request->name;
            $contactInquiry->email = $request->email;
             
            $contactInquiry->description = $request->description;
            $contactInquiry->save();

            return redirect()->back()->with('success', 'Your inquiry has been submitted successfully!');
            
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'There was an error submitting your inquiry. Please try again later.');
        }
    }

    public function share(Request $request)
    {
    	$device = Agent::device();
    	if(Agent::isTablet() || Agent::isPhone())
    	{
    		$link = ClientPreference::select('android_app_link','ios_link')->first();
    		$platform = Agent::platform();
    		if($platform == "AndroidOS")
    		{
    			if(!is_null($link->android_app_link))
    			{
    				return Redirect::to($link->android_app_link);
    			}
    		}else{
    			if(!is_null($link->ios_link))
    			{
    				return Redirect::to($link->ios_link);
    			}
    		}
    	}
    	if(isset($request->serverUrl))
    	{
    		return Redirect::to(url($request->serverUrl));
    	}
    	return Redirect::to(url('/'));
    }
    public function createSitmap()
    {
        // each Sitemap file must have no more than 50,000 URLs and must be no larger than 10MB
        $categories = Category::select(["id","slug", "updated_at"]) 
        ->orderBy("id", "desc") 
        ->get();

        $vendors = Vendor::select(["id","slug", "updated_at"]) 
        ->orderBy("id", "desc")
        ->get();

        $products = Product::with("vendor")->select(["id","url_slug","updated_at","vendor_id"]) 
        ->orderBy("id", "desc")
        ->get();

        $brands = Brand::select(["id","updated_at"])
        ->orderBy("id", "desc")
        ->get();

        $pages = page::select('id','slug','updated_at')->get();

        return response()->view('sitemap',['categories'=>$categories, 'vendors'=>$vendors, 'products'=>$products,'brands'=>$brands,'pages'=>$pages])->header('Content-Type', 'text/xml');
    }
} 

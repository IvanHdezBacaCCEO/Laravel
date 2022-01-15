<?php

namespace App\Http\Controllers\dashboard;

use App\Models\Contact;
use App\Models\ContactImage;
use App\Helpers\CustomUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
        // $this->middleware('rol.admin');
        $this->middleware(['auth', 'rol.admin']);
        //$this->middleware('auth')->only('index');
        //$this->middleware('auth')->except('index','show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = Contact::orderBy('created_at', 'desc')->paginate(10);
        //dd($contacts);
        return view('dashboard.contact.index', ['contacts' => $contacts]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        //$contact = Contact::findOrFail($id);
        //dd($contact);
        // if(isset($contact)){
        //     return view('dashboard.contact.show', ["contact"=>$contact]);
        // }
        return view('dashboard.contact.show', ["contact" => $contact]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        //echo "Eliminar el elemento ".$contact->id;
        $contact->delete();
        return back()->with('status', 'Contact eliminado con exito');
    }
}

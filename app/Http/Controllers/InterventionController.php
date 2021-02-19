<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Intervention;
use App\Models\Piece;
use App\Models\Vehicule;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InterventionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $interventions = Intervention::all();

        return view('interventions.index', ['interventions' => $interventions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('interventions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $inputs = $request->except('_token', 'created_at', 'updated_at');
        $intervention = new Intervention();
        foreach ($inputs as $key => $value) {
            $intervention->$key = $value;
        }
        $intervention->state = "doing";
        $intervention->created_by = Auth::user()->name;
        $intervention->user_id = Auth::user()->id;
        $intervention->save();
        $intervention->users()->attach(Auth::user()->id);
        return redirect(route('interventions.edit', ['intervention' => $intervention]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Intervention $intervention)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Intervention  $intervention
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {   
        $intervention =  Intervention::find($id);
        if(Auth()->user()->name != $intervention->created_by){
            $intervention->users()->attach(Auth::id());
        }
        $vehicules = Vehicule::all();
        $search = $request->get('selectVehicule');
        $vehicules = Vehicule::Where('immat', 'like', '%' . $search . '%')
            ->get();
        $categories = Categorie::all();
        $pieces = Piece::all();

        return view('interventions.edit', ['intervention' => $intervention, 'vehicules' => $vehicules, 'categories' => $categories, 'pieces' => $pieces])->with('toast', 'update');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $inputs = $request->except('_token', '_method', 'updated_at');
        $intervention = Intervention::find($id);
        foreach ($inputs as $key => $value) {
            $intervention->$key = $value;
        }
        $intervention->save();

        return redirect(route('interventions.edit', ['intervention' => $intervention]))->with('toast', 'update');
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Intervention  $intervention
     * @return \Illuminate\Http\Response
     */
    public function destroy(Intervention $intervention)
    {
        //
    }

    public function selectVehicule(Request $request)
    {
        $interventionID = $request->get('intervention_id');
        $search = $request->get('selectVehicule');
        $intervention = Intervention::find($interventionID);
        $categories = Categorie::all();
        $pieces = Piece::all();
        $vehicules = Vehicule::Where('immat', 'like', '%' . $search . '%')
            ->orWhere('marque', 'like', '%' . $search . '%')
            ->get();

        return view('interventions.edit', ['intervention' => $intervention, 'vehicules' => $vehicules, 'categories' => $categories, 'pieces' => $pieces]);
    }

    public function addOperation(Request $request){
        $interventionId = $request->get('intervention_id');
        $categorieId = $request->get('categorie_id');
        $intervention = Intervention::find($interventionId);
        $intervention->categories()->attach($categorieId);

        return redirect(route('interventions.edit', ['intervention' => $intervention]))->with('toast', 'addoperation' );
    }

    public function editOperation(Request $request){
        $interventionId = $request->get('intervention_id');
        $observation = $request->input('observations');
        $categorie_id = $request->get('categorie_id');
        $intervention = Intervention::find($interventionId);
        $intervention->categories()->sync([$categorie_id => [ 'observations' => $observation]], false);
        
        return redirect(route('interventions.edit', ['intervention' => $intervention]))->with('toast', 'comment' );
    }
    
    public function deleteOperation(Request $request){
        $interventionId = $request->get('intervention_id');
        $categorie_id = $request->get('categorie_id');
        $intervention = Intervention::find($interventionId);
        $intervention->categories()->detach($categorie_id);
        
        return redirect(route('interventions.edit', ['intervention' => $intervention]))->with('toast', 'removeoperation' );
    }

    public function addPiece(Request $request){

        $interventionId = $request->get('intervention-id');
        $pieceRef = $request->get('piece-ref');
        $qte = $request->get('qte');
    
        $intervention = Intervention::find($interventionId);

        try{
            $pieceId = Piece::Where('ref', 'like', '%' . $pieceRef . '%')->value('id');
            $piece = Piece::findOrFail($pieceId);
        }
        catch (Exception $e){
            dd('Pièce introuvable.');
        }
        
        if( $piece->qte >= $qte){
            $piece->qte -= $qte;
            $piece->save();
            $intervention->pieces()->sync([$pieceId => [ 'qte' => $qte]], false);
        }else{
            return redirect(route('interventions.edit', ['intervention' => $intervention]))->with('toast', 'nopieceqte' );
        }
        
        return redirect(route('interventions.edit', ['intervention' => $intervention]))->with('toast', 'addpiece' );
    }

    public function editPiece(Request $request){
        $interventionId = $request->get('intervention_id');
        $piece_id = $request->get('piece_id');
        $observations = $request->get('observations');
        $intervention = Intervention::find($interventionId);

        $intervention->pieces()->sync([$piece_id => [ 'observations' => $observations]], false);
        
        return redirect(route('interventions.edit', ['intervention' => $intervention]))->with('toast', 'comment' );
    }

    public function deletePiece(Request $request){
        $interventionId = $request->get('intervention_id');
        $piece_id = $request->get('piece_id');
        $intervention = Intervention::find($interventionId);

        $piece = Piece::find($piece_id);
        $qte = $intervention->pieces()->find($piece_id)->pivot->qte;

        if($intervention->pieces()->find($piece_id)->pivot->qte > 1){
            $intervention->pieces()->sync([$piece_id => [ 'qte' => $qte -1]], false);
            $piece->qte ++;
            $piece->save();
        }else{
            $intervention->pieces()->detach($piece_id);
        }
        
        return redirect(route('interventions.edit', ['intervention' => $intervention]))->with('toast', 'removepiece');
    }

    public function resumeIntervention(){

        $interventions = Intervention::Where('state', 'like', 'pause')->get();
        return view('interventions.resume', ['interventions' => $interventions]);
    }

    public function goToIntervention(Request $request){

        $id = $request->input('intervention');
        $intervention = Intervention::find($id);
        $intervention->state="doing";
        $intervention->save();
        return redirect(route('interventions.edit', ['intervention' => $intervention]));
    }

    public function joinIntervention(){

        $interventions = Intervention::Where('user_id', '!=', Auth::id())->get();
        return view('interventions.join', ['interventions' => $interventions]);
    }

    public function goToJoinIntervention(Request $request){
        $id = $request->input('intervention');
        $intervention = Intervention::find($id);
        $intervention->users()->attach(Auth::id());
        $intervention->state="doing";
        $intervention->save();

        return redirect(route('interventions.edit', ['intervention' => $intervention]));
    }

    public function leaveIntervention(Request $request){
        $id = $request->input('intervention');
        $intervention = Intervention::find($id);
        $intervention->users()->detach(Auth::id());

        return redirect(route('interventions.index'));
    }
}

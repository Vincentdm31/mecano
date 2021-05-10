<?php

namespace App\Http\Controllers;

use App\Models\Intervention;
use App\Models\Operation;
use App\Models\OperationList;
use App\Models\Piece;
use App\Models\PieceList;
use App\Models\TimeIntervention;
use App\Models\TimeOperation;
use App\Models\Vehicule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Classes\InvoiceItem;

class InterventionController extends Controller
{
    public function index()
    {
        $interventions = Intervention::where('state', '!=', 'finish')
            ->orderBy('id', 'desc')
            ->paginate(5);

        return view('interventions.index', ['interventions' => $interventions]);
    }

    public function store()
    {
        $intervention = new Intervention();

        $intervention->state = "doing";
        $intervention->created_by = Auth::user()->name;
        $intervention->user_id = Auth::user()->id;
        $intervention->start_intervention_time = Carbon::now();

        $intervention->save();
        $intervention->users()->attach(Auth::user()->id);

        return redirect(route('stepOne', ['id' => $intervention->id]));
    }

    public function edit(Request $request, $id)
    {

        $intervention =  Intervention::find($id);

        if (Auth()->user()->name != $intervention->created_by) {
            $intervention->users()->attach(Auth::id());
        }

        $operations = Operation::where('intervention_id', $id)->get();

        $operationsId = array();

        foreach ($operations as $op) {
            array_push($operationsId, $op->operation_id);
        }

        $operationsList = OperationList::all()->except($operationsId);

        $piecesList = PieceList::all();
        $pieces = Piece::all();


        $opDoing = Operation::Where('intervention_id', $id)
            ->where('state', 'like', 'doing')
            ->get();

        $opPause = Operation::Where('intervention_id', $id)
            ->where('state', 'pause')
            ->get();
        $opEnd = Operation::Where('intervention_id', $id)
            ->where('state', 'finish')
            ->get();

        $search = $request->get('selectVehicule');

        $vehicules = Vehicule::Where('license_plate', 'like', '%' . $search . '%')
            ->get();

        return view('interventions.edit', [
            'intervention' => $intervention,
            'vehicules' => $vehicules,
            'operationsList' => $operationsList,
            'piecesList' => $piecesList,
            'operations' => $operations,
            'pieces' => $pieces,
            'opDoing' => $opDoing,
            'opEnd' => $opEnd,
            'opPause' => $opPause
        ])->with(['toast' => 'update']);
    }

    public function update(Request $request, $id)
    {
        $inputs = $request->except('_token', '_method', 'updated_at');
        $intervention = Intervention::find($id);

        foreach ($inputs as $key => $value) {
            $intervention->$key = $value;
        }

        $intervention->save();

        if ($intervention->state == 'finish') {
            $intervention->end_intervention_time = Carbon::now();
            $intervention->save();

            return redirect(route('home'))->with('toast', 'endIntervention');
        }

        return redirect(route('interventions.edit', ['intervention' => $intervention]))->with('toast', 'update');
    }

    public function correctInterventionIndex(){
        $interventions = Intervention::where('state', 'like', 'recheck')->paginate(5);
        return view('interventions.recheck', ['interventions' => $interventions]);
    }

    public function correctIntervention($id){
        $intervention = Intervention::find($id);

        $intervention->state = "recheck";
        $intervention->save();

        $timeIntervention = new TimeIntervention();
        $timeIntervention->intervention_id = $id;

        $timeIntervention->start_date = $intervention->end_intervention_time;

        $timeIntervention->save();

        return redirect(route('adminIntervention'));

    }

    public function resumeCorrectIntervention($id){

        $intervention = Intervention::find($id);

        $intervention->state = "recheck";

        $intervention->save();

        $timeIntervention = TimeIntervention::where('intervention_id', 'like', $id)->latest()->first();

        $timeIntervention->end_date = Carbon::now();

        $timeIntervention->save();

        return redirect(route('interventions.edit', ['intervention' => $intervention]))->with('toast', 'update');
    }

    public function adminIntervention()
    {
        $interventions = Intervention::Where('state', 'like', '%' . 'finish' . '%')
            ->orderBy('id', 'desc')
            ->paginate(5);

        return view('interventions.adminIndex', ['interventions' => $interventions]);
    }

    public function resumeIntervention()
    {
        $interventions = Intervention::Where('state', 'like', 'pause')
            ->orderBy('id', 'desc')
            ->paginate(5);

        return view('interventions.resume', ['interventions' => $interventions]);
    }

    public function goToIntervention(Request $request)
    {
        $id = $request->input('intervention');
        $intervention = Intervention::find($id);

        $intervention->state = "doing";

        $intervention->save();

        return redirect(route('interventions.edit', ['intervention' => $intervention]));
    }

    public function joinIntervention()
    {
        $interventions = Intervention::Where('user_id', '!=', Auth::id())
            ->where('state', '!=', 'finish')
            ->orderBy('id', 'desc')
            ->get();

        return view('interventions.join', ['interventions' => $interventions]);
    }

    public function goToJoinIntervention(Request $request)
    {
        $id = $request->input('intervention');
        $intervention = Intervention::find($id);

        $intervention->users()->attach(Auth::id());
        $intervention->state = "doing";

        $intervention->save();

        return redirect(route('interventions.edit', ['intervention' => $intervention]));
    }

    public function leaveIntervention(Request $request)
    {
        $id = $request->input('intervention');
        $intervention = Intervention::find($id);

        $intervention->users()->detach(Auth::id());

        return redirect(route('home'));
    }

    public function stepOne(Request $request)
    {
        $id = $request->id;
        $intervention = Intervention::find($id);
        $vehicules = Vehicule::all();

        return view('interventions.step1', ['intervention' => $intervention, 'vehicules' => $vehicules]);
    }

    public function stepTwo(Request $request)
    {
        $intervention_id = $request->id;
        $vehicules = Vehicule::all();
        $intervention = Intervention::find($intervention_id);

        return view('interventions.step2', ['intervention' => $intervention, 'vehicules' => $vehicules]);
    }

    public function searchIntervVehicule(Request $request)
    {
        $search = $request->get('searchIntervVehicule');
        $intervention_id = $request->id;
        $intervention = Intervention::find($intervention_id);

        $vehicules = Vehicule::Where('license_plate', 'like', '%' . $search . '%')
            ->orWhere('brand', 'like', '%' . $search . '%')
            ->get();

        return view('interventions.step2', ['intervention' => $intervention, 'vehicules' => $vehicules, 'id' => $intervention_id]);
    }

    public function selectVehicule(Request $request)
    {

        $inputs = $request->except('_token', '_method');
        $intervention_id = $request->id;
        $intervention = Intervention::find($intervention_id);

        foreach ($inputs as $key => $value) {
            $intervention->$key = $value;
        }

        $intervention->save();

        return redirect(route('interventions.edit', ['intervention' => $intervention]));
    }



    public function needMove(Request $request)
    {
        $id = $request->id;
        $needMove = $request->needMove;
        $vehicules = Vehicule::all();
        $intervention = Intervention::find($id);
        $intervention->needMove = $needMove;

        $intervention->save();

        if (!$intervention->needMove) {
            return view('interventions.step2', ['intervention' => $intervention, 'vehicules' => $vehicules]);
        }

        return view('interventions.step1', ['intervention' => $intervention, 'vehicules' => $vehicules]);
    }

    public function setDeplacement(Request $request)
    {

        $inputs = $request->except('_token', '_method');
        $vehicules = Vehicule::all();
        $intervention_id = $request->id;
        $intervention = Intervention::find($intervention_id);

        foreach ($inputs as $key => $value) {
            $intervention->$key = $value;
        }

        $intervention->save();

        if ($intervention->end_move_begin != null) {
            return view('interventions.step2', ['intervention' => $intervention, 'vehicules' => $vehicules]);
        }

        return view('interventions.step1', ['intervention' => $intervention]);
    }

    public function sendVerif($id)
    {
        $intervention = Intervention::find($id);

        if ($intervention->state_verif == null) {
            $intervention->state_verif = 'checking';
        }

        $intervention->save();

        return redirect(route('adminIntervention'));
    }

    public function searchIntervention(Request $request)
    {
        $search = $request->get('searchIntervention');

        $interventions = Intervention::whereHas('vehiculeList', function ($query) use ($search) {
            $query->where('license_plate', 'like',  '%' . $search . '%');
        })->orderBy('id', 'desc')->paginate(5);

        return view('interventions.adminIndex', ['interventions' => $interventions]);
    }

    public function setEndDeplacement(Request $request)
    {

        $inputs = $request->except('_token', '_method');

        $intervention_id = $request->id;
        $intervention = Intervention::find($intervention_id);

        foreach ($inputs as $key => $value) {
            $intervention->$key = $value;
        }

        $intervention->save();

        return redirect(route('interventions.edit', ['intervention' => $intervention]));
    }

    public function exportPDF($id)
    {
        $intervention = Intervention::find($id);
        $itemList = array();
        $vehiculeType = $intervention->vehiculeList->category;

        // Calcul déplacement
        if($intervention->needMove){
            $timeMoving = Carbon::parse($intervention->end_move_begin)->diffInMinutes(Carbon::parse($intervention->start_move_begin)) + 
                            Carbon::parse($intervention->end_move_return)->diffInMinutes(Carbon::parse($intervention->start_move_return));

            array_push($itemList, (new InvoiceItem())->title("Déplacement")->quantity($timeMoving)
                ->pricePerUnit(0.33));
        }

        //Calcul main d'oeuvre intervention
        array_push($itemList, (new InvoiceItem())->title("Main d'oeuvre")->quantity($this->totalTime($id))
            ->pricePerUnit( 
                $vehiculeType == 1  ? 45/60 : (($vehiculeType == 2 ) ? 55/60 : 1  )
            ));

        // Calcul main d'oeuvre opérations
        foreach ($intervention->operations as $operation) {

            if($operation->operationList->isPackage){
                array_push($itemList, (new InvoiceItem())->title('Opération - ' . $operation->operationList->name)
                    ->quantity(1)
                    ->pricePerUnit($operation->operationList->price));
            }else{
                $totalTimeOp = 0;
                $totalTimeOp += Carbon::parse($operation->end_operation_time)->diffInMinutes(Carbon::parse($operation->start_operation_time));

                $pausesOp = TimeOperation::where('operation_id', 'like', $operation->id)->get();

                foreach ($pausesOp as $pause){
                    $totalTimeOp -= Carbon::parse($pause->end_date)->diffInMinutes(Carbon::parse($pause->start_date));
                   
                }
                array_push($itemList, (new InvoiceItem())->title('Opération - ' . $operation->operationList->name)
                    ->quantity($totalTimeOp)
                    ->pricePerUnit( ($operation->operationList->price / 60 ) * $operation->mechanic_count));
            }
            // Calcul des pièces
            foreach ($operation->pieces as $piece) {
                array_push($itemList, (new InvoiceItem())->title('Pièce - ' . $piece->PieceList->name)
                    ->quantity($piece->qte)
                    ->pricePerUnit($piece->pieceList->price));
            }
        }

        $client = new Party([
            'name'          => 'Alcis Meca',
            'address'       => '130 Route de Castres 31130 Balma'
        ]);

        $customer = new Party([
            'name'          => 'Alcis Groupe',
            'address'       => '130 Route de Castres 31130 Balma'
        ]);

        $notes = [
            '',
            '',
            'Createur: ' . '<strong>' .  $intervention->users[0]->name . '</strong>',
            'Immat: ' . '<strong>' . $intervention->vehiculeList->license_plate . '</strong>',
            'Marque: ' . '<strong>' . $intervention->vehiculeList->brand . '</strong>',
            'Modèle: ' . '<strong>' . $intervention->vehiculeList->model . '</strong>',
            'Kilométrage: ' . '<strong>' . $intervention->km_vehicule > 0 ? $intervention->km_vehicule : 'Kilométrage non renseigné' . '</strong>'

        ];

        $notes = implode("<br>", $notes);

        $invoice = Invoice::make('Facture atelier mécanique')

            ->sequence($intervention->id)
            ->serialNumberFormat('{SEQUENCE}{SERIES}')
            ->seller($client)
            ->buyer($customer)
            ->date(now())
            ->dateFormat('d/m/Y')
            ->currencySymbol('€')
            ->currencyCode('€')
            ->currencyFormat('{VALUE} {SYMBOL}')
            ->currencyThousandsSeparator('.')
            ->currencyDecimalPoint(',')
            // ->filename($client->name . ' ' . $customer->name)
            ->addItems($itemList)
            ->notes($notes)
            ->logo(public_path('images/logoFact.png'));
        // ->filename('toto')
        // ->save('public');

        return $invoice->stream();
    }

    public function totalTime($id)
    {
        $intervention = Intervention::find($id);

        $totalTimeIntervention = Carbon::parse($intervention->end_intervention_time)->diffInMinutes(Carbon::parse($intervention->start_intervention_time));

        $pauseInterventionList = TimeIntervention::Where('intervention_id', 'like', $id)->whereNotNull('end_date')->get();

        $totalTime = 0;
        $timePauseIntervention = 0;

        foreach ($pauseInterventionList as $pause) {
            $timeToMinuts = Carbon::parse($pause->end_date)->diffInMinutes(Carbon::parse($pause->start_date));
            $timePauseIntervention += $timeToMinuts;
        }

        $totalTime = $totalTimeIntervention - $timePauseIntervention;

        return $totalTime;
    }
}

<?php

namespace App\Http\Controllers\Purchase;

use Illuminate\Http\Request;
use App\Models\Configuration\Unit;
use App\Models\Purchase\Purchase;
use App\Http\Controllers\Controller;
use App\Models\Configuration\Provider;
use App\Models\Configuration\Warehouse;
use App\Models\Product\ProductWarehouse;
use App\Models\Purchase\PurchaseDetail;
use App\Http\Resources\Purchase\PurchaseResource;
use App\Http\Resources\Purchase\PurchaseCollection;

class PurchaseController extends Controller
{
    public function index(Request $request){
        $warehouse_id = $request->warehouse_id;
        $n_orden = $request->n_orden;
        $provider_id = $request->provider_id;
        $n_comprobant = $request->n_comprobant;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $search_product = $request->search_product;

        $purchases = Purchase::without(['details.product', 'details.unit', 'details.encargado'])
                                ->filterAdvance(
                                    $warehouse_id,
                                    $n_orden,
                                    $provider_id,
                                    $n_comprobant,
                                    $start_date,
                                    $end_date,
                                    $search_product,
                                    auth("api")->user()
                                )
                                ->orderBy("id","desc")
                                ->paginate(25);

        return response()->json([
            "total" => $purchases->total(),
            "purchases" => PurchaseCollection::make($purchases),
        ]);
    }

    public function config(Request $request){
        $warehouses = Warehouse::where("state",1)->get();
        $providers = Provider::where("state",1)->get();
        $units = Unit::where("state",1)->get();
        return response()->json([
            "warehouses" => $warehouses,
            "providers" => $providers,
            "units" => $units,
            "now" => now()->format("Y-m-d"),
        ]);
    }

    public function show($id){
        $purchase = Purchase::findOrFail($id);
        return response()->json([
            "purchase" => PurchaseResource::make($purchase),
        ]);
    }

    public function store(Request $request){
        
        $request->request->add(["user_id" => auth("api")->user()->id, "state" => 1]);
        $purchase = Purchase::create($request->all());

        $details = $request->details;

        foreach ($details as $key => $detail) {
            PurchaseDetail::create([
                "purchase_id" => $purchase->id,
                "product_id" => $detail["product"]["id"],
                "unit_id" => $detail["unit"]["id"],
                "description" => $detail["description"] ?? null,
                "quantity" => $detail["quantity"],
                "price_unit" => $detail["price_unit"],
                "total" => $detail["total"],
                "state" => 1,
            ]);
        }

        return response()->json([
            "message" => 200
        ]);
    }

    public function update(Request $request, $id){
        $purchase = Purchase::findOrFail($id);
        $purchase->update($request->all());
        
        return response()->json([
            "message" => 200,
        ]);
    }

    public function destroy($id){
        $purchase = Purchase::findOrFail($id);
        
        if($purchase->state == 3 || $purchase->state == 4){
            return response()->json([
                "message" => 403,
            ]);
        }
        
        $purchase->delete();

        return response()->json([
            "message" => 200,
        ]);
    }

    // Métodos adicionales para manejar detalles
    public function addDetail(Request $request){
        $detail = PurchaseDetail::create($request->all());
        
        $purchase = Purchase::findOrFail($request->purchase_id);
        
        return response()->json([
            "purchase_detail" => $detail,
            "total" => $purchase->total,
            "importe" => $purchase->importe,
            "igv" => $purchase->igv,
        ]);
    }

    public function updateDetail(Request $request, $id){
        $detail = PurchaseDetail::findOrFail($id);
        $detail->update($request->all());
        
        $purchase = Purchase::findOrFail($detail->purchase_id);
        
        return response()->json([
            "purchase_detail" => $detail,
            "total" => $purchase->total,
            "importe" => $purchase->importe,
            "igv" => $purchase->igv,
        ]);
    }

    public function deleteDetail($id){
        $detail = PurchaseDetail::findOrFail($id);
        $purchase_id = $detail->purchase_id;
        $detail->delete();
        
        $purchase = Purchase::findOrFail($purchase_id);
        
        return response()->json([
            "total" => $purchase->total,
            "importe" => $purchase->importe,
            "igv" => $purchase->igv,
        ]);
    }

    public function procesoEntrega(Request $request){
        $purchase_id = $request->purchase_id;
        $purchase_details = $request->purchase_details;
        
        foreach ($purchase_details as $detail_id) {
            $detail = PurchaseDetail::findOrFail($detail_id);
            
            $product_warehouse = ProductWarehouse::where("product_id", $detail->product_id)
                                                ->where("unit_id", $detail->unit_id)
                                                ->where("warehouse_id", $detail->purchase->warehouse_id)
                                                ->first();
            
            if(!$product_warehouse){
                ProductWarehouse::create([
                    "product_id" => $detail->product_id,
                    "unit_id" => $detail->unit_id,
                    "warehouse_id" => $detail->purchase->warehouse_id,
                    "stock" => $detail->quantity,
                ]);
            } else {
                $product_warehouse->update([
                    "stock" => $product_warehouse->stock + $detail->quantity,
                ]);
            }
            
            $detail->update([
                "state" => 2,
                "user_entrega" => auth("api")->user()->id,
                "date_entrega" => now(),
            ]);
        }
        
        $purchase = Purchase::findOrFail($purchase_id);
        $total_details = $purchase->details()->count();
        $entregados = $purchase->details()->where("state", 2)->count();
        
        if($total_details == $entregados){
            $purchase->update([
                "state" => 4,
                "date_entrega" => now(),
            ]);
        } else {
            $purchase->update([
                "state" => 3,
            ]);
        }
        
        return response()->json([
            "message" => 200,
        ]);
    }
}
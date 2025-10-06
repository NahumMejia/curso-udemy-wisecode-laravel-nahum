<?php

namespace App\Http\Controllers\Kardex;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Product\Product;
use App\Models\Configuration\Unit;
use Illuminate\Support\Facades\DB;
use App\Exports\Kardex\ExportKardex;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Configuration\Warehouse;
use App\Models\Kardex\ProductStockInitial;

class KardexController extends Controller
{
    //

public function kardex_products($warehouse_id, $year, $month, $search_product)
{
    // DE LAS ENTRADAS O INGRESOS
    $movimients_products = collect([]);
    
    // 1 ES INGRESO Y 2 ES SALIDA
    $query_purchases = DB::table("purchase_details")
        ->whereNull("purchase_details.deleted_at")
        ->join("purchases", "purchase_details.purchase_id", "=", "purchases.id")
        ->whereNull("purchases.deleted_at")
        ->join("products", "purchase_details.product_id", "=", "products.id")
        ->whereNotNull("purchase_details.date_entrega")
        ->whereYear("purchase_details.date_entrega", $year)
        ->whereMonth("purchase_details.date_entrega", $month)
        ->where("purchases.warehouse_id", $warehouse_id);
        
    if ($search_product) {
        $query_purchases->where("products.title", "like", "%" . $search_product . "%");
    }

    $query_purchases = $query_purchases->selectRaw(
        "UNIX_TIMESTAMP(purchase_details.date_entrega) as date_entrega_num,
        DATE_FORMAT(purchase_details.date_entrega, '%D %M %Y') as date_entrega_format,
        purchase_details.product_id as product_id,
        purchase_details.unit_id as unit_id,
        products.title as title_product,
        1 as type_op, 'COMPRA' as tag,
        SUM(purchase_details.quantity) as product_quantity,
        AVG(purchase_details.price_unit) as product_price_avg"
    )->groupBy('date_entrega_num', 'unit_id', 'date_entrega_format', 'product_id', 'title_product', 'type_op', 'tag')->get();

    foreach ($query_purchases as $key => $query_purchase) {
        $movimients_products->push($query_purchase);
    }

    // Repetir lo mismo para otros queries (transports, conversions, etc.)
    // Reutilizando la lógica anterior para los demás tipos de movimientos

    $query_transports = DB::table("transport_details")
        ->whereNull("transport_details.deleted_at")
        ->join("transports", "transport_details.transport_id", "=", "transports.id")
        ->whereNull("transports.deleted_at")
        ->join("products", "transport_details.product_id", "=", "products.id")
        ->whereNotNull("transport_details.date_entrega")
        ->whereYear("transport_details.date_entrega", $year)
        ->whereMonth("transport_details.date_entrega", $month)
        ->where("transports.warehouse_end_id", $warehouse_id);
        
    if ($search_product) {
        $query_transports->where("products.title", "like", "%" . $search_product . "%");
    }

    $query_transports = $query_transports->selectRaw(
        "UNIX_TIMESTAMP(transport_details.date_entrega) as date_entrega_num,
        DATE_FORMAT(transport_details.date_entrega, '%D %M %Y') as date_entrega_format,
        transport_details.product_id as product_id,
        transport_details.unit_id as unit_id,
        products.title as title_product,
        1 as type_op, 'TRANSPORTE' as tag,
        SUM(transport_details.quantity) as product_quantity,
        AVG(transport_details.price_unit) as product_price_avg"
    )->groupBy('date_entrega_num', 'unit_id', 'date_entrega_format', 'product_id', 'title_product', 'type_op', 'tag')->get();

    foreach ($query_transports as $key => $query_transport) {
        $movimients_products->push($query_transport);
    }

    // Repite este patrón para otras consultas (conversions_out, proformas, etc.)

    // Procesar los movimientos y agruparlos por producto y unidad
    $kardex_products = collect([]);
    foreach ($movimients_products->groupBy("product_id") as $key => $movimients_product) {
        // MOVIMIENTOS DE LAS UNIDADES DE UN PRODUCTO
        $movimient_units = collect([]);
        $units = collect([]);

        foreach ($movimients_product->groupBy("unit_id") as $key_unit => $movimients_for_unit) {
            // LISTA DE MOVIMIENTOS DE UNA UNIDAD EN ESPECIFICO
            $movimients = collect([]);
            $STOCK_INITIAL = ProductStockInitial::whereDate("created_at", "$year-$month-01")
                ->where("product_id", $movimients_for_unit[0]->product_id)
                ->where("unit_id", $movimients_for_unit[0]->unit_id)
                ->where("warehouse_id", $warehouse_id)
                ->first();

            $Qb = $STOCK_INITIAL ? $STOCK_INITIAL->stock : 0;
            $PUb = $STOCK_INITIAL ? $STOCK_INITIAL->price_unit_avg : 0;
            $Tb = round($Qb * $PUb, 2);

            // AGREGAMOS EL PRIMERO MOVIMIENTO QUE ES EL STOCK INICIAL
            $movimients->push([
                "fecha" => Carbon::parse("$year-$month-01")->format('d M Y'),
                "detalle" => "STOCK INICIAL",
                "ingreso" => null,
                "salida" => null,
                "existencia" => [
                    "quantity" => $Qb,
                    "price_unit" => $PUb,
                    "total" => $Tb,
                ],
            ]);

            // ORDENAMOS LOS MOVIMIENTOS SEGUN LA FECHA
            foreach ($movimients_for_unit->sortBy("date_entrega_num") as $movimient) {
                $Qactual = $movimient->product_quantity;
                $Qexistencia = 0;

                if ($movimient->type_op == 1) {
                    // ENTRADA
                    $Qexistencia = $Qb + $Qactual;
                } else {
                    // SALIDA
                    $Qexistencia = $Qb - $Qactual;
                }

                $PUactual = $movimient->product_price_avg == 0 ? $PUb : $movimient->product_price_avg;
                $Tactual = round($Qactual * $PUactual, 2);

                $Texistencia = 0;
                if ($movimient->type_op == 1) {
                    // ENTRADA
                    $Texistencia = $Tb + $Tactual;
                } else {
                    // SALIDA
                    $Texistencia = $Tb - $Tactual;
                }

                $PUexistencia = round($Texistencia / $Qexistencia, 2);

                $movimients->push([
                    "fecha" => Carbon::parse($movimient->date_entrega_format)->format('d M Y'),
                    "detalle" => $movimient->tag,
                    "ingreso" => $movimient->type_op == 1 ? [
                        "quantity" => $Qactual,
                        "price_unit" => $PUactual,
                        "total" => $Tactual,
                    ] : null,
                    "salida" => $movimient->type_op == 2 ? [
                        "quantity" => $Qactual,
                        "price_unit" => $PUactual,
                        "total" => $Tactual,
                    ] : null,
                    "existencia" => [
                        "quantity" => $Qexistencia,
                        "price_unit" => $PUexistencia,
                        "total" => $Texistencia,
                    ],
                ]);

                $Qb = $Qexistencia;
                $PUb = $PUexistencia;
                $Tb = $Texistencia;
            }

            $movimient_units->push([
                "unit_id" => $key_unit,
                "movimients" => $movimients,
            ]);
            $units->push(Unit::find($key_unit));
        }

        $product = Product::findOrFail($movimients_product[0]->product_id);
        $kardex_products->push([
            "product_id" => $movimients_product[0]->product_id,
            "title" => $movimients_product[0]->title_product,
            "sku" => $product->sku,
            "categoria" => $product->product_categorie->name,
            "movimient_units" => $movimient_units,
            "unit_first" => $units->first(),
            "units" => $units,
        ]);
    }

    return $kardex_products;
}


    public function index(Request $request){
        // LOS PARAMETROS DE BUSQUEDA
        $warehouse_id = $request->warehouse_id;
        $year = $request->year;
        $month = $request->month;
        $search_product = $request->search_product;
        
        return response()->json([
            "kardex_products" => $this->kardex_products($warehouse_id,$year,$month,$search_product),
        ]);
        // OPERACIONES DE EXISTENCIAS   
    }
    
    public function export_kardex(Request $request){
        $warehouse_id = $request->get("warehouse_id");
        $year = $request->get("year");
        $month = $request->get("month");
        $search_product = $request->get("search_product");

        $kardex_products = $this->kardex_products($warehouse_id,$year,$month,$search_product);
        return Excel::download(new ExportKardex($kardex_products),"reporte_kardex".uniqid().".xlsx");
    }

    public function config(){

        $warehouses = Warehouse::where("state",1)->get(); 
        $year = date("Y");
        $month = date("m");

        return response()->json([
            "warehouses" => $warehouses,
            "year" => $year,
            "month" => $month,
        ]);
    }
}

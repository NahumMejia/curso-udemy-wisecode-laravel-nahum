<?php

namespace App\Http\Resources\Proforma;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProformaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
public function toArray(Request $request): array
{
    return [
        "id" => $this->resource->id,
        "user_id" => $this->resource->user_id,
        "asesor" => [
            "id" => $this->resource->asesor ? $this->resource->asesor->id : null, 
            "full_name" => $this->resource->asesor ? $this->resource->asesor->name.' '.$this->resource->asesor->surname : 'N/A',
        ],
        "client_id" => $this->resource->client_id,
        "client" => [
            "id" => $this->resource->client ? $this->resource->client->id : null,
            "full_name" =>  $this->resource->client ? $this->resource->client->full_name : 'N/A', 
            "client_segment" => [
                "id" => $this->resource->client_segment ? $this->resource->client_segment->id : null,
                "name" => $this->resource->client_segment ? $this->resource->client_segment->name : 'N/A',
            ],
            "phone" => $this->resource->client ? $this->resource->client->phone : 'N/A',
            "type" => $this->resource->client ? $this->resource->client->type : 'N/A',
            "n_document" => $this->resource->client ? $this->resource->client->n_document : 'N/A',
            "is_parcial" => $this->resource->client ? $this->resource->client->is_parcial : null,
        ],
        "client_segment_id" => $this->resource->client_segment_id,
        "client_segment" => [
            "id" => $this->resource->client_segment ? $this->resource->client_segment->id : null,
            "name" => $this->resource->client_segment ? $this->resource->client_segment->name : 'N/A',
        ],
        "sucursale_id" => $this->resource->sucursale_id,
        "sucursale" => [
            "id" => $this->resource->sucursale ? $this->resource->sucursale->id : null,
            "name" => $this->resource->sucursale ? $this->resource->sucursale->name : 'N/A',
        ],
        "subtotal" => round($this->resource->subtotal,2),
        "discount" => $this->resource->discount,
        "total" => round($this->resource->total,2),
        "igv" => round($this->resource->igv,2),
        "state_proforma" => $this->resource->state_proforma,
        "state_payment" => $this->resource->state_payment,
        "state_despacho" => $this->resource->state_despacho,
        "date_entrega" => $this->resource->date_entrega ? Carbon::parse($this->resource->date_entrega)->format("Y-m-d h:i A") : NULL,
        "debt" => round($this->resource->debt,2),
        "paid_out" => round($this->resource->paid_out,2),
        "date_validation" => $this->resource->date_validation,
        "date_pay_complete" => $this->resource->date_pay_complete,
        "description" => $this->resource->description,
        "created_at" => $this->resource->created_at->format("Y-m-d h:i:A"),
        "details" => $this->resource->details->map(function($detail) {
            $units = collect([]);
            foreach ($detail->product->wallets->groupBy("unit_id") as $unit_only) {
                $units->push($unit_only[0]->unit);
            }
            return [
                "id" => $detail->id,
                "product_id" => $detail->product_id,
                "product" => [
                    "id" => $detail->product ? $detail->product->id : null,
                    "title" => $detail->product ? $detail->product->title : 'N/A',
                    "price_general" => $detail->product ? $detail->product->price_general : 0,
                    "min_discount" => $detail->product ? $detail->product->min_discount : 0,
                    "max_discount" => $detail->product ? $detail->product->max_discount : 0,
                    "importe_iva" => $detail->product ? $detail->product->importe_iva : 0,
                    "is_discount" => $detail->product ? $detail->product->is_discount : false,
                    "imagen" => $detail->product && $detail->product->imagen ? env('APP_URL').'storage/'.$detail->product->imagen : null,
                    "warehouses" => $detail->product->warehouses->map(function ($warehouse) {
                        return [
                            "id" => $warehouse->id,
                            "unit" => $warehouse->unit,
                            "warehouse" => $warehouse->warehouse,
                            "quantity" => $warehouse->stock,
                        ];
                    }),
                    "wallets" => $detail->product->wallets->map(function ($wallet) {
                        return [
                            "id" => $wallet->id,
                            "unit" => $wallet->unit,
                            "sucursale" => $wallet->sucursale ? $wallet->sucursale->name : 'N/A',
                            "client_segment" => $wallet->client_segment ? $wallet->client_segment->name : 'N/A',
                            "price_general" => $wallet->price,
                        ];
                    }),
                    "units" => $units,
                ],
                "product_categorie_id" => $detail->product_categorie_id,
                "product_categorie" => [
                    "id" => $detail->product_categorie ? $detail->product_categorie->id : null,
                    "name" => $detail->product_categorie ? $detail->product_categorie->name : 'N/A',
                ],
                "quantity" => $detail->quantity,
                "price_unit" => $detail->price_unit,
                "discount" => round($detail->discount,2),
                "subtotal" => round($detail->subtotal,2),
                "total" => round($detail->total,2),
                "description" => $detail->description,
                "unidad_product" => $detail->unit_id,
                "unit_id" => $detail->unit_id,
                "unit" => [
                    "id" => $detail->unit ? $detail->unit->id : null,
                    "name" => $detail->unit ? $detail->unit->name : 'N/A',
                ],
                "impuesto" => round($detail->impuesto,2),
                "date_entrega"  => $detail->date_entrega ? Carbon::parse($detail->date_entrega)->format("Y-m-d h:i A") : NULL,
            ];
        }),
        "proforma_deliverie" => [
            "id" => $this->resource->proforma_deliverie ? $this->resource->proforma_deliverie->id : null,
            "sucursale_deliverie_id" => $this->resource->proforma_deliverie ? $this->resource->proforma_deliverie->sucursale_deliverie_id : null,
            "sucursal_deliverie" => [
                "id" => $this->resource->proforma_deliverie && $this->resource->proforma_deliverie->sucursal_deliverie ? $this->resource->proforma_deliverie->sucursal_deliverie->id : null,
                "name" => $this->resource->proforma_deliverie && $this->resource->proforma_deliverie->sucursal_deliverie ? $this->resource->proforma_deliverie->sucursal_deliverie->name : 'N/A',
            ],
            "date_entrega" => $this->resource->proforma_deliverie ? Carbon::parse($this->resource->proforma_deliverie->date_entrega)->format("Y-m-d") : null,
            "date_envio" => $this->resource->proforma_deliverie ? Carbon::parse($this->resource->proforma_deliverie->date_envio)->format("Y/m/d") : null,
            "address" => $this->resource->proforma_deliverie ? $this->resource->proforma_deliverie->address : 'N/A',
        ],
        "pagos" => $this->resource->proforma_payments->map(function($payment) {
            return [
                "method_payment_id" => $payment->method_payment_id,
                "method_payment" => [
                    "id" =>  $payment->method_payment ? $payment->method_payment->id : null,
                    "name" => $payment->method_payment ? $payment->method_payment->name : 'N/A',
                ],
                "amount" => $payment->amount,
                "date_validation" => $payment->date_validation,
                "n_transaccion" => $payment->n_transaccion,
            ];
        })
    ];
}

}

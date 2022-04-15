<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConfirmRequest;
use App\Http\Requests\OfferRequest;
use App\Models\Confirm;
use App\Models\Offer;
use App\Models\Product;
use Illuminate\Support\Facades\Mail;


class OfferController extends Controller
{
    /**
     * Tüm teklifleri listeler
     */
    public function list()
    {
        $offer = Offer::with('getProduct')->get();
        return $offer;
    }


    /**
     * Yeni teklif oluşturur
     */
    public function store(OfferRequest $request)
    {
        {
            $offer = new Offer();
            $offer->product_id = $request->product_id;
            $offer->city = $request->city;
            $offer->product_name = Product::where('id', $offer->product_id)->value('product_name');
            $offer->offer_description = $request->offer_description;
            $offer->email = $request->email;

           $query = Product::where('id', $offer->product_id)->value('is_offerable');

           if ($query == 1) {
               $data = $offer->save();
               if (!$data) {
                   return response()->json([
                       'status' => 400,
                       'error' => 'Hata.'
                   ]);
               } else {
                   return response()->json([
                       'status' => 200,
                       'message' => 'Veri Kaydedildi'
                   ]);
               }
           }
           else { return "Teklif Verilemez"; }

        }

    }

    /**
     * Var olan teklifi onaylar
     */
    public
    function confirm(ConfirmRequest $request)
    {

        $confirm = new Confirm();
        $confirm->confirm = $request->confirm;
        $confirm->confirm_description = $request->confirm_description;
        $confirm->offer_id = $request->offer_id;
        if($confirm->confirm == 0) $confirm->price = ''; else $confirm->price = $request->price;
        $offer = Offer::where('id', $confirm->offer_id)->value('email');

        Mail::send([], [], function ($message) use ($confirm, $offer) {
            $message->from('deneme@deneme.com');
            $message->to($offer);
            $message->setBody(' Onay : ' . $confirm->confirm . ' <br />
                                Mesaj Açıklaması : ' . $confirm->confirm_description . ' <br />
                                Mesajın Fiyatı : ' . $confirm->price . ' <br />
                                Mesajın Gönderilme Tarihi : ' . now() . '', 'text/html');
            $message->subject('İletişimden gönderildi');
        });

        $data = $confirm->save();
        if (!$data) {
            return response()->json([
                'status' => 400,
                'error' => 'Hata'
            ]);
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'Veri Kaydedildi'
            ]);
        }
    }
}

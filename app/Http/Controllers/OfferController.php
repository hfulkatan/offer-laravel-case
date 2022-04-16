<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConfirmRequest;
use App\Http\Requests\OfferRequest;
use App\Models\Confirm;
use App\Models\Offer;
use App\Models\Product;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;


class OfferController extends Controller
{
    /**
     * Tüm teklifleri listeler
     */
    public function list()
    {
        return Offer::with('product')->get();
    }
    /**
     * Yeni teklif oluşturur
     */
    public function store(OfferRequest $request, Product $product)
    {
        $data = array_merge($request->validated());
        $product = Product::find($data['product_id']);
        if(!$product->is_offerable)
        {
            return response()->json([
                'status' => 400,
                'message' => 'Ürüne teklif verilemez',
            ], Response::HTTP_BAD_REQUEST);

        }
        $offer = Offer::create([
            'product_id' => $data['product_id'],
            'city' => $data['city'],
            'description' => $data['description'],
            'email' => $data['email'],
        ]);

        $offer->load('product');
        return response()->json($offer, Response::HTTP_CREATED);
    }
    /**
     * Var olan teklifi onaylar
     */
    public function confirm(ConfirmRequest $request, Offer $offer)
    {
        $data = $request->validated();
        $confirm = Confirm::create([
            'offer_id' => $data['offer_id'],
            'confirm' => $data['confirm'],
            'description' => $data['description'],
            'price' => $data['confirm'] ? number_format($data['price'], 2) : null,
        ]);
        $mail_adress = Offer::find($data['offer_id']);
        Mail::send([], [], function ($message) use ($confirm, $offer, $mail_adress) {
            $message->from(env('MAIL_FROM_ADDRESS'));
            $message->to($mail_adress->email);
            $message->setBody(' Onay : ' . $confirm->confirm . ' <br />
                                Mesaj Açıklaması : ' . $confirm->description . ' <br />
                                Fiyat : ' . $confirm->price . ' <br />
                                Mesajın Gönderilme Tarihi : ' . now(), 'text/html');
            $message->subject('İletişimden gönderildi');
        });

        return response()->json([
            'status' => 200,
            'message' => 'Veri Kaydedildi',
            'data' => $confirm,
        ], Response::HTTP_OK);
    }
}


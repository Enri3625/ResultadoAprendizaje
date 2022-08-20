<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MapsApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $apiKey = 'AIzaSyB4CbJQ4DyUU8PBQA9wtm9IqClbF7dhOuo';
        $datos_envios = $request->all();
        $addressFrom = 'Universidad Tecnológica De La Selva, Camino a Tonina, Chiapas';
        $addressTo = $datos_envios['calle'].' '.$datos_envios['numero'].', '.$datos_envios['colonia'].', '.$datos_envios['municipio'].', '.$datos_envios['estado'];
        $formattedAddrFrom    = str_replace(' ', '+', $addressFrom);
        $formattedAddrTo     = str_replace(' ', '+', $addressTo);
        $geocodeFrom = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddrFrom.'&sensor=false&key='.$apiKey);
        $outputFrom = json_decode($geocodeFrom);
        if(!empty($outputFrom->error_message)){
            return $outputFrom->error_message;
        }
        $geocodeTo = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddrTo.'&sensor=false&key='.$apiKey);
        $outputTo = json_decode($geocodeTo);
        if(!empty($outputTo->error_message)){
            return $outputTo->error_message;
        }
        $latitudeFrom    = $outputFrom->results[0]->geometry->location->lat;
        $longitudeFrom    = $outputFrom->results[0]->geometry->location->lng;
        $latitudeTo        = $outputTo->results[0]->geometry->location->lat;
        $longitudeTo    = $outputTo->results[0]->geometry->location->lng;

        $coordenadasUTS = $latitudeFrom.','.$longitudeFrom;
        $coordenadasDestino = $latitudeTo.','.$longitudeTo;
        $calcular=file_get_contents("https://maps.googleapis.com/maps/api/directions/json?key=AIzaSyB4CbJQ4DyUU8PBQA9wtm9IqClbF7dhOuo&origin=$coordenadasUTS&destination=$coordenadasDestino&mode=driving");
        $datos_api=json_decode($calcular);
        $km=$datos_api->{"routes"}[0]->{"legs"}[0]->{"distance"}->{"text"};
        $km = explode(' ', $km);
        $envio = 0;
        if($km[0] <= 100){
            $envio = 100;
        }else if($km[0] > 100 & $km[0] <= 200){
            $envio = 130;
        }else if($km[0] > 200 & $km[0] <= 400){
            $envio = 170;
        }else if($km[0] > 400 & $km[0] <= 700){
            $envio = 210;
        }else if($km[0] > 700 & $km[0] <= 1000){
            $envio = 250;
        }else if($km[0] > 1000){
            $envio = 350;
        }
        return json_encode(['envio' => $envio, 'coordenadasUTS' => $coordenadasUTS, 'coordenadasDestino' => $coordenadasDestino]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

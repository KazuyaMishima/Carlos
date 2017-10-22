<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Statickidz\GoogleTranslate;

class ProductoController extends Controller
{
    public function show($id)
    {
        $parser = new \HtmlDomParser();
        $pageHtml = $parser->fileGetHtml('https://www.wish.com/c/'.$id);
        //https://www.wish.com/c/53bfdc7ad91139696eaba77d
        $tmp =explode(";",$pageHtml->find('text')[156]);
        $jsonPage = explode("pageParams['mainContestObj'] =",$tmp[0]);
        $jsonFormatPage= json_decode($jsonPage[1]) ;
        $source = 'en';
        $target = 'es';
        $text = $jsonFormatPage->description ;
        $trans = new GoogleTranslate();
        $description = $trans->translate($source, $target, $text);
        /*
         * construyendo el json {}
         * */
        $coleccion = collect();
        $coleccion["producto"] = $jsonFormatPage->human_readable_url;
        $coleccion["product_id"] =$jsonFormatPage->rating_size_summary->product_id;
        $coleccion["fotosMiniatura"] =$jsonFormatPage->extra_photo_urls;
        $coleccion["fotosGrandes"] =str_replace("small","large",(array)$jsonFormatPage->extra_photo_urls);
        $coleccion["precio"] = $jsonFormatPage->commerce_product_info->variations[0]->original_price;
        $coleccion["fechaEstimada"] = $jsonFormatPage->commerce_product_info->variations[0]->shipping_time_string;
        $coleccion["descripcion"] = $description;
        return  response()->json($coleccion);

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
    public function store(){

    }
}

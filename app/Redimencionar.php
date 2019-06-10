<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Redimencionar extends Model
{

  public function redimencionarImgPost($ruta_imagen){

		$miniatura_ancho_maximo = 586;
		$miniatura_alto_maximo = 490;

		$info_imagen = getimagesize($ruta_imagen);
		$imagen_ancho = $info_imagen[0];
		$imagen_alto = $info_imagen[1];
		$imagen_tipo = $info_imagen['mime'];


		$proporcion_imagen = $imagen_ancho / $imagen_alto;
		$proporcion_miniatura = $miniatura_ancho_maximo / $miniatura_alto_maximo;

		if ( $proporcion_imagen > $proporcion_miniatura ){
			$miniatura_ancho = $miniatura_alto_maximo * $proporcion_imagen;
			$miniatura_alto = $miniatura_alto_maximo;
		} else if ( $proporcion_imagen < $proporcion_miniatura ){
			$miniatura_ancho = $miniatura_ancho_maximo;
			$miniatura_alto = $miniatura_ancho_maximo / $proporcion_imagen;
		} else {
			$miniatura_ancho = $miniatura_ancho_maximo;
			$miniatura_alto = $miniatura_alto_maximo;
		}

		$x = ( $miniatura_ancho - $miniatura_ancho_maximo ) / 2;
		$y = ( $miniatura_alto - $miniatura_alto_maximo ) / 2;

		switch ( $imagen_tipo ){
			case "image/jpg":
			case "image/jpeg":
				$imagen = @@imagecreatefromjpeg( $ruta_imagen );
				break;
			case "image/png":
				$imagen = @@imagecreatefrompng( $ruta_imagen );
				break;
			case "image/gif":
				$imagen = @@imagecreatefromgif( $ruta_imagen );
				break;
		}

		$lienzo = imagecreatetruecolor( $miniatura_ancho_maximo, $miniatura_alto_maximo );
		$lienzo_temporal = imagecreatetruecolor( $miniatura_ancho, $miniatura_alto );

		imagecopyresampled($lienzo_temporal, $imagen, 0, 0, 0, 0, $miniatura_ancho, $miniatura_alto, $imagen_ancho, $imagen_alto);
		imagecopy($lienzo, $lienzo_temporal, 0,0, $x, $y, $miniatura_ancho_maximo, $miniatura_alto_maximo);

		imagejpeg($lienzo, $ruta_imagen, 80);
    }

  public function redimencionarimg($imagen, $path){

    	$ruta_imagen = $path.$imagen;

		$miniatura_ancho_maximo = 480;
		$miniatura_alto_maximo = 360;

		$info_imagen = getimagesize($ruta_imagen);
		$imagen_ancho = $info_imagen[0];
		$imagen_alto = $info_imagen[1];
		$imagen_tipo = $info_imagen['mime'];


		$proporcion_imagen = $imagen_ancho / $imagen_alto;
		$proporcion_miniatura = $miniatura_ancho_maximo / $miniatura_alto_maximo;

		if ( $proporcion_imagen > $proporcion_miniatura ){
			$miniatura_ancho = $miniatura_alto_maximo * $proporcion_imagen;
			$miniatura_alto = $miniatura_alto_maximo;
		} else if ( $proporcion_imagen < $proporcion_miniatura ){
			$miniatura_ancho = $miniatura_ancho_maximo;
			$miniatura_alto = $miniatura_ancho_maximo / $proporcion_imagen;
		} else {
			$miniatura_ancho = $miniatura_ancho_maximo;
			$miniatura_alto = $miniatura_alto_maximo;
		}

		$x = ( $miniatura_ancho - $miniatura_ancho_maximo ) / 2;
		$y = ( $miniatura_alto - $miniatura_alto_maximo ) / 2;

		switch ( $imagen_tipo ){
			case "image/jpg":
			case "image/jpeg":
				$imagen = @imagecreatefromjpeg( $ruta_imagen );
				break;
			case "image/png":
				$imagen = @imagecreatefrompng( $ruta_imagen );
				break;
			case "image/gif":
				$imagen = @imagecreatefromgif( $ruta_imagen );
				break;
		}

		$lienzo = imagecreatetruecolor( $miniatura_ancho_maximo, $miniatura_alto_maximo );
		$lienzo_temporal = imagecreatetruecolor( $miniatura_ancho, $miniatura_alto );

		imagecopyresampled($lienzo_temporal, $imagen, 0, 0, 0, 0, $miniatura_ancho, $miniatura_alto, $imagen_ancho, $imagen_alto);
		imagecopy($lienzo, $lienzo_temporal, 0,0, $x, $y, $miniatura_ancho_maximo, $miniatura_alto_maximo);

		imagejpeg($lienzo, $ruta_imagen, 80);
    }

    public function redimencionarImgAvatar($ruta_imagen){

		$miniatura_ancho_maximo = 200;
		$miniatura_alto_maximo = 200;

		$info_imagen = getimagesize($ruta_imagen);
		$imagen_ancho = $info_imagen[0];
		$imagen_alto = $info_imagen[1];
		$imagen_tipo = $info_imagen['mime'];


		$proporcion_imagen = $imagen_ancho / $imagen_alto;
		$proporcion_miniatura = $miniatura_ancho_maximo / $miniatura_alto_maximo;

		if ( $proporcion_imagen > $proporcion_miniatura ){
			$miniatura_ancho = $miniatura_alto_maximo * $proporcion_imagen;
			$miniatura_alto = $miniatura_alto_maximo;
		} else if ( $proporcion_imagen < $proporcion_miniatura ){
			$miniatura_ancho = $miniatura_ancho_maximo;
			$miniatura_alto = $miniatura_ancho_maximo / $proporcion_imagen;
		} else {
			$miniatura_ancho = $miniatura_ancho_maximo;
			$miniatura_alto = $miniatura_alto_maximo;
		}

		$x = ( $miniatura_ancho - $miniatura_ancho_maximo ) / 2;
		$y = ( $miniatura_alto - $miniatura_alto_maximo ) / 2;

		switch ( $imagen_tipo ){
			case "image/jpg":
			case "image/jpeg":
				$imagen = @@@@imagecreatefromjpeg( $ruta_imagen );
				break;
			case "image/png":
				$imagen = @@@@imagecreatefrompng( $ruta_imagen );
				break;
			case "image/gif":
				$imagen = @@@@imagecreatefromgif( $ruta_imagen );
				break;
		}

		$lienzo = imagecreatetruecolor( $miniatura_ancho_maximo, $miniatura_alto_maximo );
		$lienzo_temporal = imagecreatetruecolor( $miniatura_ancho, $miniatura_alto );

		imagecopyresampled($lienzo_temporal, $imagen, 0, 0, 0, 0, $miniatura_ancho, $miniatura_alto, $imagen_ancho, $imagen_alto);
		imagecopy($lienzo, $lienzo_temporal, 0,0, $x, $y, $miniatura_ancho_maximo, $miniatura_alto_maximo);

		imagejpeg($lienzo, $ruta_imagen, 80);
    }

    public function redimencionarimgnormal($imagen, $path){

    	$ruta_imagen = $path.$imagen;


		$info_imagen = getimagesize($ruta_imagen);

		$imagen_ancho = $info_imagen[0];
		$imagen_alto = $info_imagen[1];
		$imagen_tipo = $info_imagen['mime'];


		$miniatura_ancho_maximo = $imagen_ancho;
		$miniatura_alto_maximo = $imagen_alto;

		$proporcion_imagen = $imagen_ancho / $imagen_alto;
		$proporcion_miniatura = $miniatura_ancho_maximo / $miniatura_alto_maximo;

		if ( $proporcion_imagen > $proporcion_miniatura ){
			$miniatura_ancho = $miniatura_ancho_maximo;
			$miniatura_alto = $miniatura_ancho_maximo / $proporcion_imagen;
		} else if ( $proporcion_imagen < $proporcion_miniatura ){
			$miniatura_ancho = $miniatura_ancho_maximo * $proporcion_imagen;
			$miniatura_alto = $miniatura_alto_maximo;
		} else {
			$miniatura_ancho = $miniatura_ancho_maximo;
			$miniatura_alto = $miniatura_alto_maximo;
		}


		switch ( $imagen_tipo ){
			case "image/jpg":
			case "image/jpeg":
				$imagen = @@@imagecreatefromjpeg( $ruta_imagen );
				break;
			case "image/png":
				$imagen = @@@imagecreatefrompng( $ruta_imagen );
				break;
			case "image/gif":
				$imagen = @@@imagecreatefromgif( $ruta_imagen );
				break;
		}

		$lienzo = imagecreatetruecolor( $miniatura_ancho, $miniatura_alto );

		imagecopyresampled($lienzo, $imagen, 0, 0, 0, 0, $miniatura_ancho, $miniatura_alto, $imagen_ancho, $imagen_alto);


		imagejpeg($lienzo, $ruta_imagen, 80);
    }

}

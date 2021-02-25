<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WikiFile extends Model
{
    protected $fillable = [
        'id_wiki', 'type', 'path', 'name',
    ];
    
    public static function getTypeFile($type) {
        switch ($type) {
            case "text/plain":
                $t = "/img/formats/txt.png";
                return $t;
                break;
            case "application/rtf":
                $t = "/img/formats/rtf.png";
                return $t;
                break;
            case "application/msword":
                $t = "/img/formats/doc.png";
                return $t;
                break;
            case "application/vnd.openxmlformats-officedocument.wordprocessingml.document":
                $t = "/img/formats/docx.png";
                return $t;
                break;
            case "vnd.ms-excel":
                $t = "/img/formats/xls.png";
                return $t;
                break;
            case "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet":
                $t = "/img/formats/xlsx.png";
                return $t;
                break;
            case "application/vnd.ms-powerpoint":
                $t = "/img/formats/ppt.png";
                return $t;
                break;
            case "application/vnd.openxmlformats-officedocument.presentationml.presentation":
                $t = "/img/formats/pptx.png";
                return $t;
                break;
            case "application/pdf":
                $t = "/img/formats/pdf.png";
                return $t;
                break;
            case "application/zip":
                $t = "/img/formats/zip.png";
                return $t;
                break;
            case "application/x-7z-compressed":
                $t = "/img/formats/7z.png";
                return $t;
                break;
            case "application/x-rar-compressed":
                $t = "/img/formats/rar.png";
                return $t;
                break;
            case "application/vnd.oasis.opendocument.text":
                $t = "/img/formats/odt.png";
                return $t;
                break;
            case "image/gif":
                $t = "/img/formats/gif.png";
                return $t;
                break;
            case "image/bmp":
                $t = "/img/formats/bmp.png";
                return $t;
                break;
            case "image/jpeg":
            case "image/pjpeg":
                $t = "/img/formats/jpg.png";
                return $t;
                break;
            case "image/png":
                $t = "/img/formats/png.png";
                return $t;
                break;
            case "image/tiff":
                $t = "/img/formats/tif.png";
                return $t;
                break;
            case "image/x-icon":
                $t = "/img/formats/ico.png";
                return $t;
                break;
            case "video/x-msvideo":
                $t = "/img/formats/avi.png";
                return $t;
                break;
            case "video/mpeg":
                $t = "/img/formats/mpeg.png";
                return $t;
                break;
            case "video/mp4":
                $t = "/img/formats/mp4.png";
                return $t;
                break;
            case "video/quicktime":
                $t = "/img/formats/mov.png";
                return $t;
                break;
            case "video/3gpp":
            case "video/3gpp2":
                $t = "/img/formats/3g.png";
                return $t;
                break;
            case "audio/mpeg":
                $t = "/img/formats/mp3.png";
                return $t;
                break;
            case "text/vnd.wap.wml":
                $t = "/img/formats/xml.png";
                return $t;
                break;
            case "application/x-msdownload":
                $t = "/img/formats/exe.png";
                return $t;
                break;
            case "application/octet-stream":
                //$t = "/img/formats/dll.png";
                $t = "/img/formats/def.png";
                return $t;
                break;
            default:
                $t = "/img/formats/def.png";
                return $t;
        }
    }
}
/*
audio/x-ms-wma
audio/x-ms-wax
audio/vnd.wave

video/ogg
video/x-ms-wmv
video/x-flv
 * 
 */

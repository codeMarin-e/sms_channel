<?php
namespace App\Models;

    use Illuminate\Support\Facades\Log;

    class FrontSms {

        private $sms_url;
        private $sms_id;
        private $sms_pass;

        // @HOOK_TRAITS

        public function __construct() {
            $this->sms_url = config('marinar_sms_channel.sms_url');
            $this->sms_id = config('marinar_sms_channel.sms_id');
            $this->sms_pass = config('marinar_sms_channel.sms_pass');
        }

        public function send($msg, $phone, $price = 0, $force = false) {
            if(!$force)
                $phone = strlen((string)$phone) > 8? '00'.$phone : '0047'.$phone;
            if(!$phone) {
                return false;
            }
            //$msg = iconv('utf-8', 'iso-8859-1', $msg);
            $str = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
            $str .= "<request>";
            $str .= "<from>".$this->sms_id."</from>";
            $str .= "<receivers>";
            $str .= "<receiver price=\"{$price}\">{$phone}</receiver>";
            $str .= "</receivers>";
            $str .= "<message><![CDATA[{$msg}]]></message>";
            $str .= "</request>";
//            $iv = substr(md5($this->sms_pass), 0, \mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_CBC));
            $iv = sprintf('%u', crc32($this->sms_pass));
            $uname = rawurlencode($this->sms_id);
//            $msg = \mcrypt_encrypt(MCRYPT_BLOWFISH, $this->sms_pass, $str, MCRYPT_MODE_CBC, $iv);
            $msg = $str;
            $flds = "username={$uname}&request=".rawurlencode(base64_encode($msg)).'&k='.$iv;

            $cs = curl_init();
            curl_setopt($cs, CURLOPT_POST, true);
            curl_setopt($cs, CURLOPT_URL, $this->sms_url);
            curl_setopt($cs, CURLOPT_POSTFIELDS, $flds);
            curl_setopt($cs, CURLOPT_RETURNTRANSFER, true);
            $resp = curl_exec($cs);

            if(strpos($resp, 'success')) {
                return true;
            }
            Log::error("Sms error: ".$resp);
            return false;
        }
    }

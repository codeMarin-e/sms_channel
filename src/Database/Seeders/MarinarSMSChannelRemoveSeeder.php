<?php
    namespace Marinar\SMSChannel\Database\Seeders;

    use Illuminate\Database\Seeder;
    use App\Models\Address;
    use Marinar\SMSChannel\MarinarSMSChannel;

    class MarinarSMSChannelRemoveSeeder extends Seeder {

        use \Marinar\Marinar\Traits\MarinarSeedersTrait;

        public static function configure() {
            static::$packageName = 'marinar_sms_channel';
            static::$packageDir = MarinarSMSChannel::getPackageMainDir();
        }

        public function run() {
            if(!in_array(env('APP_ENV'), ['dev', 'local'])) return;

            $this->autoRemove();

            $this->refComponents->info("Done!");
        }

//        public function clearDB() {
//            $this->refComponents->task("Clear DB rows", function() {
//                $addresses = Address::get();
//                foreach ($addresses as $address) {
//                    $address->delete();
//                }
//                return true;
//            });
//        }
    }

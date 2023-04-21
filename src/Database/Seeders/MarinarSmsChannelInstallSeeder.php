<?php
    namespace Marinar\SMSChannel\Database\Seeders;

    use Illuminate\Database\Seeder;
    use Marinar\SMSChannel\MarinarSMSChannel;

    class MarinarSMSChannelInstallSeeder extends Seeder {

        use \Marinar\Marinar\Traits\MarinarSeedersTrait;

        public static function configure() {
            static::$packageName = 'marinar_sms_channel';
            static::$packageDir = MarinarSMSChannel::getPackageMainDir();
        }

        public function run() {
            if(!in_array(env('APP_ENV'), ['dev', 'local'])) return;

            $this->autoInstall();

            $this->refComponents->info("Done!");
        }

    }

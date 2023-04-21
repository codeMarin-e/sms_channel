<?php
\Illuminate\Support\Facades\App::singleton('FrontSms', function() {
    return (new \App\Models\FrontSms);
});

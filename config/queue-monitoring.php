<?php

return [
    'disable-default-alerts' => false,
    'alert-email-addresses'  => explode(',', env('QUEUE_MONITORING_EMAILS'))
];

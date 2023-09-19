<?php

return [
    'disable-default-alerts' => false,
    'alert-email-addresses'  => array_filter(explode(',', trim(env('QUEUE_MONITORING_EMAILS'))))
];

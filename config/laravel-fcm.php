<?php

return [

    /**
     * Set your FCM Server Key
     * Change to yours
     */

    'server_key' => env('FCM_SERVER_KEY', ''),
    'project_id' => env('FCM_PROJECT_ID'),
    'credentials_file' => base_path(env('FCM_CREDENTIALS_PATH')),

];

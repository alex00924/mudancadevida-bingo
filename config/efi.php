<?php
return [
  'clientId'       => env('EFI_CLIENT_ID'),
  'clientSecret'   => env('EFI_CLIENT_SECRET'),
  'certificate'    => base_path(env('EFI_CERT_PATH')),
  'pwdCertificate' => env('EFI_CERT_PWD', ''),
  'sandbox'        => (bool) env('EFI_SANDBOX', false),
  'debug'          => false,
  'cache'          => true,
  'timeout'        => 30,
  'responseHeaders'=> false,
];

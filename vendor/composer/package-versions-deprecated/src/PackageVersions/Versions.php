<?php

declare(strict_types=1);

namespace PackageVersions;

use Composer\InstalledVersions;
use OutOfBoundsException;

class_exists(InstalledVersions::class);

/**
 * This class is generated by composer/package-versions-deprecated, specifically by
 * @see \PackageVersions\Installer
 *
 * This file is overwritten at every run of `composer install` or `composer update`.
 *
 * @deprecated in favor of the Composer\InstalledVersions class provided by Composer 2. Require composer-runtime-api:^2 to ensure it is present.
 */
final class Versions
{
    /**
     * @deprecated please use {@see self::rootPackageName()} instead.
     *             This constant will be removed in version 2.0.0.
     */
    const ROOT_PACKAGE_NAME = 'laravel/laravel';

    /**
     * Array of all available composer packages.
     * Dont read this array from your calling code, but use the \PackageVersions\Versions::getVersion() method instead.
     *
     * @var array<string, string>
     * @internal
     */
    const VERSIONS          = array (
  'anandsiddharth/laravel-paytm-wallet' => 'v2.0.0@5342add0719e9c5ca94fdd13f766e6a810f2ef45',
  'apimatic/jsonmapper' => 'v2.0.3@f7588f1ab692c402a9118e65cb9fd42b74e5e0db',
  'apimatic/unirest-php' => '2.1.0@e07351d5f70b445664e2dc4042bbc237ec7d4c93',
  'arcanedev/no-captcha' => '12.2.0@b2df8b5eaf17510d4d18099302763049345c4f9d',
  'arcanedev/php-html' => '5.0.1@51e851c5029dffebcc012238056b172779428828',
  'arcanedev/support' => '8.1.0@b161c3c080b314e832410295011625721fbd3a2f',
  'asm89/stack-cors' => 'v2.0.3@9cb795bf30988e8c96dd3c40623c48a877bc6714',
  'bacon/bacon-qr-code' => '2.0.4@f73543ac4e1def05f1a70bcd1525c8a157a1ad09',
  'balping/json-raw-encoder' => 'v1.0.1@e2b0ab888342b0716f1f0628e2fa13b345c5f276',
  'barryvdh/laravel-dompdf' => 'v0.8.7@30310e0a675462bf2aa9d448c8dcbf57fbcc517d',
  'berkayk/onesignal-laravel' => 'v1.0.7@11a3015f33a2cd0c98f2fe1c1ea47cf67cc3e5e6',
  'box/spout' => 'v2.7.3@3681a3421a868ab9a65da156c554f756541f452b',
  'braintree/braintree_php' => '5.5.0@8902a072ac04c9eea2996f2683cb56259cbe46fa',
  'brick/math' => '0.9.3@ca57d18f028f84f777b2168cd1911b0dee2343ae',
  'cartalyst/stripe' => 'v2.4.6@e75b4d714fec5f034d533e55f5365f0229b5686d',
  'cartalyst/stripe-laravel' => 'v13.0.0@27200881ed286ce975cd03b80dbc9528f7e62047',
  'composer/ca-bundle' => '1.3.1@4c679186f2aca4ab6a0f1b0b9cf9252decb44d0b',
  'composer/package-versions-deprecated' => '1.11.99.4@b174585d1fe49ceed21928a945138948cb394600',
  'consoletvs/charts' => '6.5.5@0005d14e4fe6715f4146a4dc3b56add768233001',
  'craftsys/msg91-laravel' => 'v0.12.1@e630c4487a85eb0653b0861939848aa60b812500',
  'craftsys/msg91-laravel-notification-channel' => 'v0.5.1@f89e7aabe8b566280146f7d9b6d1817bd40b5e9f',
  'craftsys/msg91-php' => 'v0.15.2@85e52b30078ef5eccffbe4c8577fc762e3b2878b',
  'cyrildewit/eloquent-viewable' => 'v5.2.1@77520490ff2c2a6d26e18f7d367c68ddb427aadb',
  'dasprid/enum' => '1.0.3@5abf82f213618696dda8e3bf6f64dd042d8542b2',
  'defuse/php-encryption' => 'v2.3.1@77880488b9954b7884c25555c2a0ea9e7053f9d2',
  'devmarketer/easynav' => 'v1.0.4@517a7d5a35f443574c0ce883d458849cae7b3330',
  'dflydev/dot-access-data' => 'v3.0.1@0992cc19268b259a39e86f296da5f0677841f42c',
  'doctrine/cache' => '2.1.1@331b4d5dbaeab3827976273e9356b3b453c300ce',
  'doctrine/dbal' => '3.2.0@5d54f63541d7bed1156cb5c9b79274ced61890e4',
  'doctrine/deprecations' => 'v0.5.3@9504165960a1f83cc1480e2be1dd0a0478561314',
  'doctrine/event-manager' => '1.1.1@41370af6a30faa9dc0368c4a6814d596e81aba7f',
  'doctrine/inflector' => '2.0.4@8b7ff3e4b7de6b2c84da85637b59fd2880ecaa89',
  'doctrine/lexer' => '1.2.1@e864bbf5904cb8f5bb334f99209b48018522f042',
  'dompdf/dompdf' => 'v0.8.6@db91d81866c69a42dad1d2926f61515a1e3f42c5',
  'dragonmantank/cron-expression' => 'v3.1.0@7a8c6e56ab3ffcc538d05e8155bb42269abf1a0c',
  'drewm/mailchimp-api' => 'v2.5.4@c6cdfab4ca6ddbc3b260913470bd0a4a5cb84c7a',
  'egulias/email-validator' => '2.1.25@0dbf5d78455d4d6a41d186da50adc1122ec066f4',
  'elementaryframework/fire-fs' => 'v1.0.0@dc804ad697fb2b98af1735f3742dccd41ffe4598',
  'ezyang/htmlpurifier' => 'v4.13.0@08e27c97e4c6ed02f37c5b2b20488046c8d90d75',
  'fideloper/proxy' => '4.4.1@c073b2bd04d1c90e04dc1b787662b558dd65ade0',
  'firebase/php-jwt' => 'v5.5.1@83b609028194aa042ea33b5af2d41a7427de80e6',
  'fruitcake/laravel-cors' => 'v2.0.4@a8ccedc7ca95189ead0e407c43b530dc17791d6a',
  'google/apiclient' => 'v2.12.1@1530583a711f4414407112c4068464bcbace1c71',
  'google/apiclient-services' => 'v0.227.0@ec64bbf1d6af9475bee7b1ce4fc0ed8a0a8d8889',
  'google/auth' => 'v1.18.0@21dd478e77b0634ed9e3a68613f74ed250ca9347',
  'graham-campbell/result-type' => 'v1.0.4@0690bde05318336c7221785f2a932467f98b64ca',
  'guzzlehttp/guzzle' => '7.4.1@ee0a041b1760e6a53d2a39c8c34115adc2af2c79',
  'guzzlehttp/promises' => '1.5.1@fe752aedc9fd8fcca3fe7ad05d419d32998a06da',
  'guzzlehttp/psr7' => '1.8.3@1afdd860a2566ed3c2b0b4a3de6e23434a79ec85',
  'h2akim/senangpay-php' => 'dev-master@0cc9cb68b84d382c28be28af2b9e50bf8edb402c',
  'htmlmin/htmlmin' => 'v8.0.0@e67fe976e3fd1e92568341ce84f338fa4c0ffc47',
  'instamojo/instamojo-php' => '0.4@99dc50bf008be77be84f447607e416f73f319904',
  'intervention/image' => '2.7.1@744ebba495319501b873a4e48787759c72e3fb8c',
  'intervention/imagecache' => '2.5.1@e714f13298ecaf9b2d11cb7106a0415d5615cbe5',
  'itskodinger/midia' => 'v1.4.1@c226b87a647f3921f2484a566627345d077f3258',
  'iyzico/iyzipay-php' => 'v2.0.51@fa2a07634cfc099ca47d5397ef6591d06b31cbb4',
  'jackiedo/dotenv-editor' => '1.2.0@f93690a80915d51552931d9406d79b312da226b9',
  'jackiedo/timezonelist' => '5.0.2@2c56729b13ff5b21db8203a6234f661f80614f94',
  'jaybizzle/crawler-detect' => 'v1.2.110@f9d63a3581428fd8a3858e161d072f0b9debc26f',
  'jenssegers/agent' => 'v2.6.4@daa11c43729510b3700bc34d414664966b03bffe',
  'joedixon/laravel-translation' => 'v1.1.2@4a467398bae73cd16522d523b557e96f3455b9d2',
  'jorenvanhocht/laravel-share' => '3.3.1@1991e056fedd60a9e48e323b84a468a6335a7a2f',
  'kingflamez/laravelrave' => '3.0.0@e2b7fb0c9ce753b3bc5e2b28e1b86efc62fa1567',
  'laravel-notification-channels/onesignal' => 'v2.3.0@882d842962c92e33692a43995ddd7c679dc684d2',
  'laravel/framework' => 'v8.77.1@994dbac5c6da856c77c81a411cff5b7d31519ca8',
  'laravel/helpers' => 'v1.4.1@febb10d8daaf86123825de2cb87f789a3371f0ac',
  'laravel/legacy-factories' => 'v1.1.1@8091d6d64e0e6ea22fb3326ef0b21936d0a0217c',
  'laravel/passport' => 'v10.2.2@7981abed1a0979afd4a5a8bec81624b8127a287f',
  'laravel/serializable-closure' => 'v1.0.5@25de3be1bca1b17d52ff0dc02b646c667ac7266c',
  'laravel/socialite' => 'v5.2.6@b5c67f187ddcf15529ff7217fa735b132620dfac',
  'laravel/tinker' => 'v2.6.3@a9ddee4761ec8453c584e393b393caff189a3e42',
  'laravel/ui' => 'v3.4.1@9a1e52442dd238647905b98d773d59e438eb9f9d',
  'laravolt/avatar' => '4.1.5@9207253a1e76d6c8441325d6895b57f244aa3580',
  'lcobucci/clock' => '2.0.0@353d83fe2e6ae95745b16b3d911813df6a05bfb3',
  'lcobucci/jwt' => '4.1.5@fe2d89f2eaa7087af4aa166c6f480ef04e000582',
  'league/commonmark' => '2.1.0@819276bc54e83c160617d3ac0a436c239e479928',
  'league/config' => 'v1.1.1@a9d39eeeb6cc49d10a6e6c36f22c4c1f4a767f3e',
  'league/event' => '2.2.0@d2cc124cf9a3fab2bb4ff963307f60361ce4d119',
  'league/flysystem' => '1.1.9@094defdb4a7001845300334e7c1ee2335925ef99',
  'league/glide' => '2.0.x-dev@e84ef237030817ab6034b2c17173dd3352a971e1',
  'league/mime-type-detection' => '1.9.0@aa70e813a6ad3d1558fc927863d47309b4c23e69',
  'league/oauth1-client' => 'v1.10.0@88dd16b0cff68eb9167bfc849707d2c40ad91ddc',
  'league/oauth2-server' => '8.3.3@f5698a3893eda9a17bcd48636990281e7ca77b2a',
  'mashape/unirest-php' => 'v3.0.4@842c0f242dfaaf85f16b72e217bf7f7c19ab12cb',
  'mews/purifier' => '3.3.6@1d033fc32b98036226002c38747d4a45424d5f28',
  'midtrans/midtrans-php' => '2.5.2@a1ad0c824449ca8c68c4cf11b3417ad518311d2b',
  'mobiledetect/mobiledetectlib' => '2.8.37@9841e3c46f5bd0739b53aed8ac677fa712943df7',
  'mollie/laravel-mollie' => 'v2.16.0@61d7298ef57b5221142f5be61a5d4d3841a21c97',
  'mollie/mollie-api-php' => 'v2.39.0@a47d4449973c83e918db39f860b5e9076aeb367d',
  'monolog/monolog' => '2.3.5@fd4380d6fc37626e2f799f29d91195040137eba9',
  'mrclay/minify' => '2.3.3@1928e89208d28e91427b2f13b67acdbd8cd01ac9',
  'mtownsend/read-time' => '1.1.2@ecf7bf7cd989aeea459e988d1cdf9f9e9c85f77d',
  'nesbot/carbon' => '2.55.2@8c2a18ce3e67c34efc1b29f64fe61304368259a2',
  'nette/schema' => 'v1.2.2@9a39cef03a5b34c7de64f551538cbba05c2be5df',
  'nette/utils' => 'v3.2.6@2f261e55bd6a12057442045bf2c249806abc1d02',
  'nicmart/tree' => '0.3.1@c55ba47c64a3cb7454c22e6d630729fc2aab23ff',
  'nikic/php-parser' => 'v4.13.2@210577fe3cf7badcc5814d99455df46564f3c077',
  'nwidart/laravel-modules' => '8.2.0@6ade5ec19e81a0e4807834886a2c47509d069cb7',
  'nyholm/psr7' => '1.4.1@2212385b47153ea71b1c1b1374f8cb5e4f7892ec',
  'obydul/laraskrill' => '1.1.0@08327448ffb48b802682868dfbafea968830dc77',
  'omise/omise-php' => 'v2.13.0@3dc0da231d136136288160d666fa5ef0bfe77e2d',
  'opis/closure' => '3.6.2@06e2ebd25f2869e54a306dda991f7db58066f7f6',
  'orangehill/iseed' => 'v3.0.1@874f77a20d49aa4c6c5fec2daf0daa070514e013',
  'paragonie/constant_time_encoding' => 'v2.4.0@f34c2b11eb9d2c9318e13540a1dbc2a3afbd939c',
  'paragonie/random_compat' => 'v2.0.20@0f1f60250fccffeaf5dda91eea1c018aed1adc2a',
  'paragonie/sodium_compat' => 'v1.17.0@c59cac21abbcc0df06a3dd18076450ea4797b321',
  'paypal/rest-api-sdk-php' => '1.14.0@72e2f2466975bf128a31e02b15110180f059fc04',
  'paytm/paytmchecksum' => 'v1.1.0@a032d3cbeb3846720c2c606b9f3c8057c355042e',
  'phenx/php-font-lib' => '0.5.4@dd448ad1ce34c63d09baccd05415e361300c35b4',
  'phenx/php-svg-lib' => '0.3.4@f627771eb854aa7f45f80add0f23c6c4d67ea0f2',
  'php-http/message-factory' => 'v1.0.2@a478cb11f66a6ac48d8954216cfed9aa06a501a1',
  'phpoption/phpoption' => '1.8.1@eab7a0df01fe2344d172bff4cd6dbd3f8b84ad15',
  'phpseclib/phpseclib' => '3.0.12@89bfb45bd8b1abc3b37e910d57f5dbd3174f40fb',
  'pragmarx/google2fa' => '8.0.0@26c4c5cf30a2844ba121760fd7301f8ad240100b',
  'pragmarx/google2fa-laravel' => 'v1.4.1@f9014fd7ea36a1f7fffa233109cf59b209469647',
  'pragmarx/google2fa-qrcode' => 'v1.0.3@fd5ff0531a48b193a659309cc5fb882c14dbd03f',
  'psr/cache' => '1.0.1@d11b50ad223250cf17b86e38383413f5a6764bf8',
  'psr/container' => '1.1.2@513e0666f7216c7459170d56df27dfcefe1689ea',
  'psr/event-dispatcher' => '1.0.0@dbefd12671e8a14ec7f180cab83036ed26714bb0',
  'psr/http-client' => '1.0.1@2dfb5f6c5eff0e91e20e913f8c5452ed95b86621',
  'psr/http-factory' => '1.0.1@12ac7fcd07e5b077433f5f2bee95b3a771bf61be',
  'psr/http-message' => '1.0.1@f6561bf28d520154e4b0ec72be95418abe6d9363',
  'psr/log' => '1.1.4@d49695b909c3b7628b6289db5479a1c204601f11',
  'psr/simple-cache' => '1.0.1@408d5eafb83c57f6365a3ca330ff23aa4a5fa39b',
  'psy/psysh' => 'v0.10.12@a0d9981aa07ecfcbea28e4bfa868031cca121e7d',
  'pusher/pusher-php-server' => '7.0.2@af3eeaefc0c7959f5b3852f0a4dd5547245d33df',
  'qoraiche/laravel-mail-editor' => 'v3.5.1@5871e9ebdf2ab690586dba81a040caa115287bab',
  'ralouphie/getallheaders' => '3.0.3@120b605dfeb996808c31b6477290a714d356e822',
  'ramsey/collection' => '1.2.2@cccc74ee5e328031b15640b51056ee8d3bb66c0a',
  'ramsey/uuid' => '4.2.3@fc9bb7fb5388691fd7373cd44dcb4d63bbcf24df',
  'rap2hpoutre/fast-excel' => 'v2.5.0@c8032e9146765e01a025f7f98d38b13f32f63e32',
  'razorpay/razorpay' => '2.8.1@4ad7b6a5bd9896305858ec0a861f66020e39f628',
  'reecem/mocker' => 'v1.1.5@7cf5c04e87933629a5a3160f7064ef27f119452f',
  'revolution/socialite-amazon' => '1.1.3@8bdced3ee0a128111d09258492df5da1fa3f8b22',
  'rmccue/requests' => 'v1.8.0@afbe4790e4def03581c4a0963a1e8aa01f6030f1',
  'sabberworm/php-css-parser' => '8.4.0@e41d2140031d533348b2192a83f02d8dd8a71d30',
  'samuelnitsche/laravel-auth-log' => '1.1.0@9725a53c621f841c661f1e4e4665a1ff59d30699',
  'shipu/php-aamarpay-payment' => 'v2.0.0@814ae012f22b7c7c74f4a413f0a78377842a2d66',
  'silviolleite/laravelpwa' => '2.0.3@5f7135d2ee870af01793c9fdf6b1b932b546e20e',
  'simplesoftwareio/simple-qrcode' => '4.2.0@916db7948ca6772d54bb617259c768c9cdc8d537',
  'spatie/browsershot' => '3.52.3@4f8584e835035a4696a496c4508c3c35edaef28a',
  'spatie/crawler' => '6.0.2@276ecb429a770474695a1278a9ad3e719fbef259',
  'spatie/db-dumper' => '2.21.1@05e5955fb882008a8947c5a45146d86cfafa10d1',
  'spatie/image' => '2.0.0@1ffb276dd6528c6b308d5feb1573299c24fd9613',
  'spatie/image-optimizer' => '1.6.2@6db75529cbf8fa84117046a9d513f277aead90a0',
  'spatie/laravel-analytics' => '3.11.0@6ce4610eea86e59446866504f71dcb17ddc8c496',
  'spatie/laravel-backup' => '6.16.5@332fae80b12cacb9e4161824ba195d984b28c8fb',
  'spatie/laravel-cookie-consent' => '2.12.13@8e93b9efee3a68960e5c832f937170c2fc0b2f37',
  'spatie/laravel-googletagmanager' => '2.6.6@19f257e203c0a3547328f142acf31a99ad895378',
  'spatie/laravel-image-optimizer' => '1.6.4@c39e9ea77dee6b6eddfc26800adb1aa06a624294',
  'spatie/laravel-newsletter' => '4.10.0@c3b9061a8410650aeab1416ed76e1afb57adc685',
  'spatie/laravel-permission' => '4.4.3@779797a47689d0bc1666e26f566cca44603e56fa',
  'spatie/laravel-sitemap' => '5.9.2@df5c3db511e08a8e64a3d7e28613ab018a99e95d',
  'spatie/laravel-translatable' => '4.6.0@5900d6002a5795712058a04c7ca7c2c44b3e0850',
  'spatie/robots-txt' => '1.0.10@8802a2bee670b3c13cfd21ede0322f72b3efb711',
  'spatie/temporary-directory' => '1.3.0@f517729b3793bca58f847c5fd383ec16f03ffec6',
  'square/square' => '13.1.0.20210818@d9ad3e28cf823ca158969914c66efa8ae4df7e02',
  'stichoza/google-translate-php' => 'v4.1.5@85039e0af473e58cc9f42d58e36d9d534a6a6431',
  'swiftmailer/swiftmailer' => 'v6.3.0@8a5d5072dca8f48460fce2f4131fcc495eec654c',
  'symfony/cache' => 'v5.4.0@d97d6d7f46cb69968f094e329abd987d5ee17c79',
  'symfony/cache-contracts' => 'v2.5.0@ac2e168102a2e06a2624f0379bde94cd5854ced2',
  'symfony/console' => 'v5.4.1@9130e1a0fc93cb0faadca4ee917171bd2ca9e5f4',
  'symfony/css-selector' => 'v5.4.0@44b933f98bb4b5220d10bed9ce5662f8c2d13dcc',
  'symfony/deprecation-contracts' => 'v2.5.0@6f981ee24cf69ee7ce9736146d1c57c2780598a8',
  'symfony/dom-crawler' => 'v5.4.0@5b06626e940a3ad54e573511d64d4e00dc8d0fd8',
  'symfony/error-handler' => 'v5.4.1@1e3cb3565af49cd5f93e5787500134500a29f0d9',
  'symfony/event-dispatcher' => 'v5.4.0@27d39ae126352b9fa3be5e196ccf4617897be3eb',
  'symfony/event-dispatcher-contracts' => 'v2.5.0@66bea3b09be61613cd3b4043a65a8ec48cfa6d2a',
  'symfony/finder' => 'v5.4.0@d2f29dac98e96a98be467627bd49c2efb1bc2590',
  'symfony/http-foundation' => 'v5.4.1@5dad3780023a707f4c24beac7d57aead85c1ce3c',
  'symfony/http-kernel' => 'v5.4.1@2bdace75c9d6a6eec7e318801b7dc87a72375052',
  'symfony/mime' => 'v5.4.0@d4365000217b67c01acff407573906ff91bcfb34',
  'symfony/polyfill-ctype' => 'v1.23.0@46cd95797e9df938fdd2b03693b5fca5e64b01ce',
  'symfony/polyfill-iconv' => 'v1.23.0@63b5bb7db83e5673936d6e3b8b3e022ff6474933',
  'symfony/polyfill-intl-grapheme' => 'v1.23.1@16880ba9c5ebe3642d1995ab866db29270b36535',
  'symfony/polyfill-intl-idn' => 'v1.23.0@65bd267525e82759e7d8c4e8ceea44f398838e65',
  'symfony/polyfill-intl-normalizer' => 'v1.23.0@8590a5f561694770bdcd3f9b5c69dde6945028e8',
  'symfony/polyfill-mbstring' => 'v1.23.1@9174a3d80210dca8daa7f31fec659150bbeabfc6',
  'symfony/polyfill-php72' => 'v1.23.0@9a142215a36a3888e30d0a9eeea9766764e96976',
  'symfony/polyfill-php73' => 'v1.23.0@fba8933c384d6476ab14fb7b8526e5287ca7e010',
  'symfony/polyfill-php80' => 'v1.23.1@1100343ed1a92e3a38f9ae122fc0eb21602547be',
  'symfony/polyfill-php81' => 'v1.23.0@e66119f3de95efc359483f810c4c3e6436279436',
  'symfony/process' => 'v5.4.0@5be20b3830f726e019162b26223110c8f47cf274',
  'symfony/psr-http-message-bridge' => 'v2.1.2@22b37c8a3f6b5d94e9cdbd88e1270d96e2f97b34',
  'symfony/routing' => 'v5.4.0@9eeae93c32ca86746e5d38f3679e9569981038b1',
  'symfony/service-contracts' => 'v2.5.0@1ab11b933cd6bc5464b08e81e2c5b07dec58b0fc',
  'symfony/string' => 'v5.4.0@9ffaaba53c61ba75a3c7a3a779051d1e9ec4fd2d',
  'symfony/translation' => 'v5.4.1@8c82cd35ed861236138d5ae1c78c0c7ebcd62107',
  'symfony/translation-contracts' => 'v2.5.0@d28150f0f44ce854e942b671fc2620a98aae1b1e',
  'symfony/var-dumper' => 'v5.4.1@2366ac8d8abe0c077844613c1a4f0c0a9f522dcc',
  'symfony/var-exporter' => 'v5.4.0@d59446d6166b1643a8a3c30c2fa8e16e51cdbde7',
  'tijsverkoyen/css-to-inline-styles' => '2.2.4@da444caae6aca7a19c0c140f68c6182e337d5b1c',
  'tohidplus/laravel-vue-translation' => '2.2.0@559e3f97f6dbf24f547e64c452365b3d5b2d0fec',
  'torann/currency' => '1.1.1@0bbe437a9d7db7290fb81aabf9a5a3aa89c7e742',
  'torann/geoip' => '3.0.2@f16d5df66ecb6ba4ffaef52abef519fbc19596d3',
  'twilio/sdk' => '6.32.0@d4a5ad22e761a14c5e355debb88a6f17640b247c',
  'tzsk/payu' => '5.2.0@d3a9007875e35e2355007db29b0b089dc12358b8',
  'unicodeveloper/laravel-paystack' => '1.0.7@bfcb92255c29d92b0c4e80355a65de14e2e156f3',
  'uxweb/sweet-alert' => '2.0.5@e9eb83d7d991de0fcb74398a698e0cdfef6d189d',
  'vlucas/phpdotenv' => 'v5.4.1@264dce589e7ce37a7ba99cb901eed8249fbec92f',
  'voku/portable-ascii' => '1.5.6@80953678b19901e5165c56752d087fc11526017c',
  'weblagence/laravel-facebook-pixel' => 'v1.1@5c1a614c00135c8237dd25d09a422cf39f388b9f',
  'webmozart/assert' => '1.10.0@6964c76c7804814a842473e0c8fd15bab0f18e25',
  'worldpay/worldpay-lib-php' => '2.1.2@19995ee5a685b83986ac64e1e44561ea8b1a1c86',
  'yajra/laravel-datatables-oracle' => 'v9.18.2@f4eebc1dc2b067058dfb91e7c067de862353c40f',
  'yoeunes/notify' => 'v1.0.7@fcc998a5d71295352d859930b5bc6680e65bb3a5',
  'authorizenet/authorizenet' => '2.0.2@a3e76f96f674d16e892f87c58bedb99dada4b067',
  'barryvdh/laravel-debugbar' => 'v3.6.5@ccf109f8755dcc7e58779d1aeb1051b04e0b4bef',
  'beyondcode/laravel-dump-server' => '1.7.0@e27c7b942ab62f6ac7168359393d328ec5215b89',
  'doctrine/instantiator' => '1.4.0@d56bf6102915de5702778fe20f2de3b2fe570b5b',
  'facade/ignition-contracts' => '1.0.2@3c921a1cdba35b68a7f0ccffc6dffc1995b18267',
  'fakerphp/faker' => 'v1.9.2@84220cf137a9344acffb10374e781fed785ff307',
  'filp/whoops' => '2.14.4@f056f1fe935d9ed86e698905a957334029899895',
  'google/cloud-core' => 'v1.43.1@60b47793e0c83f0e02a8197ef11ab1f599c348da',
  'google/cloud-translate' => 'v1.12.2@58b3d2b0abc586035c9272eb8d45dfee0a39562a',
  'google/common-protos' => '1.4.0@b1ee63636d94fe88f6cff600a0f23fae06b6fa2e',
  'google/gax' => 'v1.10.0@5222f7712e73d266490c742dc9bc602602ae00a5',
  'google/grpc-gcp' => 'v0.2.0@2465c2273e11ada1e95155aa1e209f3b8f03c314',
  'google/protobuf' => 'v3.19.1@83fe8edf7469ffdd83cb4b4e62249c154f961b9b',
  'grpc/grpc' => '1.42.0@9fa44f104cb92e924d4da547323a97f3d8aca6d4',
  'hamcrest/hamcrest-php' => 'v2.0.1@8c3d0a3f6af734494ad8f6fbbee0ba92422859f3',
  'imanghafoori/laravel-microscope' => 'v1.0.199@53a2cdf01cbe90328b4965fcba39f4191aec1523',
  'imanghafoori/php-search-replace' => 'v1.1.6@fc9c98d673283d8a78c061f33f510d0c78fe653c',
  'imanghafoori/php-token-analyzer' => '0.1.2@758d0c4667f5c49ce58ce288c7f3b67aa5669fc4',
  'maximebf/debugbar' => 'v1.17.3@e8ac3499af0ea5b440908e06cc0abe5898008b3c',
  'mockery/mockery' => '1.4.4@e01123a0e847d52d186c5eb4b9bf58b0c6d00346',
  'myclabs/deep-copy' => '1.10.2@776f831124e9c62e1a2c601ecc52e776d8bb7220',
  'nunomaduro/collision' => 'v5.10.0@3004cfa49c022183395eabc6d0e5207dfe498d00',
  'phar-io/manifest' => '2.0.3@97803eca37d319dfa7826cc2437fc020857acb53',
  'phar-io/version' => '3.1.0@bae7c545bef187884426f042434e561ab1ddb182',
  'phpdocumentor/reflection-common' => '2.2.0@1d01c49d4ed62f25aa84a747ad35d5a16924662b',
  'phpdocumentor/reflection-docblock' => '5.3.0@622548b623e81ca6d78b721c5e029f4ce664f170',
  'phpdocumentor/type-resolver' => '1.5.1@a12f7e301eb7258bb68acd89d4aefa05c2906cae',
  'phpspec/prophecy' => 'v1.15.0@bbcd7380b0ebf3961ee21409db7b38bc31d69a13',
  'phpunit/php-code-coverage' => '9.2.10@d5850aaf931743067f4bfc1ae4cbd06468400687',
  'phpunit/php-file-iterator' => '3.0.6@cf1c2e7c203ac650e352f4cc675a7021e7d1b3cf',
  'phpunit/php-invoker' => '3.1.1@5a10147d0aaf65b58940a0b72f71c9ac0423cc67',
  'phpunit/php-text-template' => '2.0.4@5da5f67fc95621df9ff4c4e5a84d6a8a2acf7c28',
  'phpunit/php-timer' => '5.0.3@5a63ce20ed1b5bf577850e2c4e87f4aa902afbd2',
  'phpunit/phpunit' => '9.5.11@2406855036db1102126125537adb1406f7242fdd',
  'rize/uri-template' => '0.3.4@2a874863c48d643b9e2e254ab288ec203060a0b8',
  'sebastian/cli-parser' => '1.0.1@442e7c7e687e42adc03470c7b668bc4b2402c0b2',
  'sebastian/code-unit' => '1.0.8@1fc9f64c0927627ef78ba436c9b17d967e68e120',
  'sebastian/code-unit-reverse-lookup' => '2.0.3@ac91f01ccec49fb77bdc6fd1e548bc70f7faa3e5',
  'sebastian/comparator' => '4.0.6@55f4261989e546dc112258c7a75935a81a7ce382',
  'sebastian/complexity' => '2.0.2@739b35e53379900cc9ac327b2147867b8b6efd88',
  'sebastian/diff' => '4.0.4@3461e3fccc7cfdfc2720be910d3bd73c69be590d',
  'sebastian/environment' => '5.1.3@388b6ced16caa751030f6a69e588299fa09200ac',
  'sebastian/exporter' => '4.0.4@65e8b7db476c5dd267e65eea9cab77584d3cfff9',
  'sebastian/global-state' => '5.0.3@23bd5951f7ff26f12d4e3242864df3e08dec4e49',
  'sebastian/lines-of-code' => '1.0.3@c1c2e997aa3146983ed888ad08b15470a2e22ecc',
  'sebastian/object-enumerator' => '4.0.4@5c9eeac41b290a3712d88851518825ad78f45c71',
  'sebastian/object-reflector' => '2.0.4@b4f479ebdbf63ac605d183ece17d8d7fe49c15c7',
  'sebastian/recursion-context' => '4.0.4@cd9d8cf3c5804de4341c283ed787f099f5506172',
  'sebastian/resource-operations' => '3.0.3@0f4443cb3a1d92ce809899753bc0d5d5a8dd19a8',
  'sebastian/type' => '2.3.4@b8cd8a1c753c90bc1a0f5372170e3e489136f914',
  'sebastian/version' => '3.0.2@c6c1022351a901512170118436c764e473f6de8c',
  'symfony/debug' => 'v4.4.31@43ede438d4cb52cd589ae5dc070e9323866ba8e0',
  'tanmuhittin/laravel-google-translate' => '2.0.4@2f2d97b7cf0a1296b92a1aeb8cb965bac683c118',
  'theseer/tokenizer' => '1.2.1@34a41e998c2183e22995f158c581e7b5e755ab9e',
  'yandex/translate-api' => '1.5.2@c99e69cde3e688fc0f99c4d8a21585226a8e1938',
  'laravel/laravel' => '1.0.0+no-version-set@',
);

    private function __construct()
    {
    }

    /**
     * @psalm-pure
     *
     * @psalm-suppress ImpureMethodCall we know that {@see InstalledVersions} interaction does not
     *                                  cause any side effects here.
     */
    public static function rootPackageName() : string
    {
        if (!self::composer2ApiUsable()) {
            return self::ROOT_PACKAGE_NAME;
        }

        return InstalledVersions::getRootPackage()['name'];
    }

    /**
     * @throws OutOfBoundsException If a version cannot be located.
     *
     * @psalm-param key-of<self::VERSIONS> $packageName
     * @psalm-pure
     *
     * @psalm-suppress ImpureMethodCall we know that {@see InstalledVersions} interaction does not
     *                                  cause any side effects here.
     */
    public static function getVersion(string $packageName): string
    {
        if (self::composer2ApiUsable()) {
            return InstalledVersions::getPrettyVersion($packageName)
                . '@' . InstalledVersions::getReference($packageName);
        }

        if (isset(self::VERSIONS[$packageName])) {
            return self::VERSIONS[$packageName];
        }

        throw new OutOfBoundsException(
            'Required package "' . $packageName . '" is not installed: check your ./vendor/composer/installed.json and/or ./composer.lock files'
        );
    }

    private static function composer2ApiUsable(): bool
    {
        if (!class_exists(InstalledVersions::class, false)) {
            return false;
        }

        if (method_exists(InstalledVersions::class, 'getAllRawData')) {
            $rawData = InstalledVersions::getAllRawData();
            if (count($rawData) === 1 && count($rawData[0]) === 0) {
                return false;
            }
        } else {
            $rawData = InstalledVersions::getRawData();
            if ($rawData === null || $rawData === []) {
                return false;
            }
        }

        return true;
    }
}
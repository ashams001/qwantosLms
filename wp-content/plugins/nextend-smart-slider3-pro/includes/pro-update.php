<?php
class N2_SMARTSLIDER_3_PRO_UPDATE {

    public static function init() {

        add_filter('plugins_api', 'N2_SMARTSLIDER_3_PRO_UPDATE::plugins_api', 20, 3); // WooCommerce use priority 20, so better to follow

        add_filter('pre_set_site_transient_update_plugins', 'N2_SMARTSLIDER_3_PRO_UPDATE::injectUpdate');

        add_filter('upgrader_pre_download', 'N2_SMARTSLIDER_3_PRO_UPDATE::upgrader_pre_download', 10, 3);
    }

    public static function plugins_api($res, $action, $args) {
        if ($action === 'plugin_information' && $args->slug === 'nextend-smart-slider3-pro') {
            try {
                N2Base::getApplication('smartslider')
                      ->getApplicationType('backend');
                N2Loader::import(array(
                    'models.License'
                ), 'smartslider');
                $a           = (array)$args;
                $a['action'] = $action;
                $response    = N2SS3::api($a);

                $res = (object)$response['data'];
            } catch (Exception $e) {
                $res = new WP_Error('error', $e->getMessage());
            }
        }

        return $res;
    }

    public static function injectUpdate($transient) {
        global $wp_version;

        $filename = "nextend-smart-slider3-pro/nextend-smart-slider3-pro.php";

        if (!isset($transient->response[$filename])) {

            N2Base::getApplication("smartslider")
                  ->getApplicationType('backend');

            N2Loader::import(array(
                'models.License',
                'models.Update'
            ), 'smartslider');


            try {
                $response = N2SS3::api(array(
                    'action' => 'plugin_information',
                    'slug'   => 'nextend-smart-slider3-pro'
                ));
                if ($response['status'] == 'OK') {
                    $item = (object)$response['data'];
                } else {
                    throw new Exception();
                }
            } catch (Exception $e) {
                $item = new WP_Error('error', $e->getMessage());
            }

            if (!is_wp_error($item)) {

                $updateLink = N2SS3::api(array(
                    'action' => 'update'
                ), true);

                $item->package                  = $updateLink;
                $item->download_link            = $updateLink;
                $item->versions                 = array();
                $item->versions[$item->version] = $updateLink;

                if (version_compare(N2SS3::$version, $item->version, '<')) {
                    $transient->response[$filename] = (object)$item;
                    unset($transient->no_update[$filename]);
                } else {
                    $transient->no_update[$filename] = (object)$item;
                    unset($transient->response[$filename]);
                }


            }
        }

        return $transient;
    }

    public static function upgrader_pre_download($reply, $package, $upgrader) {
        if (strpos($package, 'product=smartslider3') === false) {
            return $reply;
        }

        N2Base::getApplication("smartslider")
              ->getApplicationType('backend');
        N2Loader::import(array(
            'models.License'
        ), 'smartslider');

        $status = N2SmartsliderLicenseModel::getInstance()
                                           ->isActive(false);

        $message = '';
        switch ($status) {
            case 'OK':
                return $reply;
            case 'ASSET_PREMIUM':
            case 'LICENSE_EXPIRED':
                $message = 'Your <a href="https://smartslider3.helpscoutdocs.com/article/1101-activation" target="_blank">license</a> has expired! Get new one: <a href="https://smartslider3.com/pricing" target="_blank">smartslider3.com</a>.';
                break;
            case 'DOMAIN_REGISTER_FAILED':
                $message = 'Smart Slider 3 PRO license is not registered on the current domain. Please activate this domain by following <a href="https://smartslider3.helpscoutdocs.com/article/1101-activation" target="_blank">the license activation documentation</a>.';
                break;
            case 'LICENSE_INVALID':
                $message = 'Smart Slider 3 PRO license is not registered on the current domain. Please activate this domain by following <a href="https://smartslider3.helpscoutdocs.com/article/1101-activation" target="_blank">the license activation documentation</a>.';
                N2SmartsliderLicenseModel::getInstance()
                                         ->setKey('');
                break;
            case 'PLATFORM_NOT_ALLOWED':
                $message = 'Your <a href="https://smartslider3.helpscoutdocs.com/article/1101-activation" target="_blank">license</a> is not valid for WordPress! Get a license for WordPress: <a href="https://smartslider3.com/pricing" target="_blank">smartslider3.com</a>';
                break;
            case '503':
                $message = 'Licensing server is down, try again later!';
                break;
            case null:
                $message = 'Licensing server not reachable, try again later!';
                break;
            default:
                $message = 'Unknown error, please write an email to support@nextendweb.com with the following status: ' . $status;
                break;
        }

        $reply                  = new WP_Error('SS3_ERROR', $message);
        $upgrader->result       = null;
        $upgrader->skin->result = $reply;

        return $reply;
    }
}

N2_SMARTSLIDER_3_PRO_UPDATE::init();

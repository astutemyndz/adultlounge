<?php
class Sitesettings {

    const TABLE = 'site_settings';

    public static function get($key)
    {
        $CI = & get_instance();

        $data = $CI->db->from(self::TABLE)->limit(1)->get()->row();

        return isset($data->$key) ? $data->$key : null;
    }
}
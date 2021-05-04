<?php

class PayFreeKassa
{
    private $url = 'https://www.free-kassa.ru/merchant/cash.php?';
    public function __construct()
    {
    }

    public function linkPay($amount, $user_id)
    {
        $params = array(
            'm' => FK_ID,
            'oa' => $amount,
            'o' => $user_id,
            's' => $this->sign($amount, $user_id)
        );
        $params = http_build_query($params);
        return $this->url . $params;
    }

    public function sign($amount, $user_id)
    {
        $sign = md5(FK_ID . ':' . $amount . ':' . FK_KEY . ':' . $user_id);
        return $sign;
    }

    public function isPay($amount)
    {
        $user_id = $_POST['MERCHANT_ORDER_ID'];
        $amounted = $_POST['AMOUNT'];
        if ($amount == $amounted) {
            return $user_id;
        } else {
            return false;
        }
    }

}
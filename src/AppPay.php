<?php
/**
 * Created by PhpStorm.
 * User: zyj
 * Date: 2019/4/17
 * Time: 13:24
 */

namespace zyj\alipay;


use zyj\alipay\core\AopClient;
use zyj\alipay\request\AlipayTradeAppPayRequest;


class AppPay
{
    public $isDev = true;

    private $nowGetwayUrl;

    private $normalUrl = 'https://openapi.alipay.com/gateway.do';

    private $sandBoxUrl = 'https://openapi.alipaydev.com/gateway.do';

    private $format = 'json';

    private $charset = 'UTF-8';
    /*
     * 建议不修改
     * 加密方式：RSA 或者 RSA2
     */
    private $signType = 'RSA2';
    /*
     * 应用id
     */
    private $appId;
    /*
     * 开发者私钥
     */
    private $rsaPrivateKey;
    /*
     * 支付宝公钥
     */
    private $alipayRsaPublicKey;

    /*
     * 支付结果回调地址
     */
    public $notify_url;

    /**
     * AppPay constructor.
     * @param string $appId
     * @param string $rsaPrivateKey
     * @param string $alipayRsaPublicKey
     * @param bool $is_dev
     */
    public function __construct($appId, $rsaPrivateKey, $alipayRsaPublicKey, $notify_url, $isDev = true)
    {
        $this->isDev = $isDev;
        $this->nowGetwayUrl = $this->isDev === true ? $this->sandBoxUrl : $this->normalUrl;

        if (!empty($appId)) {
            $this->appId = $appId;
        }
        if (!empty($rsaPrivateKey)) {
            $this->rsaPrivateKey = $rsaPrivateKey;
        }
        if (!empty($alipayRsaPublicKey)) {
            $this->alipayRsaPublicKey = $alipayRsaPublicKey;
        }
        if (!empty($notify_url)) {
            $this->notify_url = $notify_url;
        }
    }

    public function request(array $body)
    {
        $aop = new AopClient();
        $aop->gatewayUrl = $this->nowGetwayUrl;
        $aop->appId = $this->appId;
        $aop->rsaPrivateKey = $this->rsaPrivateKey;
        $aop->format = $this->format;
        $aop->charset = $this->charset;
        $aop->signType = $this->signType;
        $aop->alipayrsaPublicKey = $this->alipayRsaPublicKey;
        //实例化具体API对应的request类,类名称和接口名称对应,当前调用接口名称：alipay.trade.app.pay
        $request = new AlipayTradeAppPayRequest();
        //SDK已经封装掉了公共参数，这里只需要传入业务参数
        $body['product_code'] = 'QUICK_MSECURITY_PAY';
        $bizcontent = json_encode($body, JSON_UNESCAPED_UNICODE);
        $request->setNotifyUrl($this->notify_url);
        $request->setBizContent($bizcontent);
        //这里和普通的接口调用不同，使用的是sdkExecute
        $response = $aop->sdkExecute($request);
        //htmlspecialchars是为了输出到页面时防止被浏览器将关键参数html转义，实际打印到日志以及http传输不会有这个问题
        return htmlspecialchars($response);//就是orderString 可以直接给客户端请求，无需再做处理。
    }

    /**
     * 异步通知验签
     * @return bool
     */
    public function notify()
    {
        $aop = new AopClient();
        $aop->alipayrsaPublicKey = $this->alipayRsaPublicKey;
        $flag = $aop->rsaCheckV1($_POST, null, "RSA2");
        return $flag;
    }

    /**
     * @param string $appId
     */
    public function setAppId($appId)
    {
        $this->appId = $appId;
    }

    /**
     * @param string $rsaPrivateKey
     */
    public function setRsaPrivateKey($rsaPrivateKey)
    {
        $this->rsaPrivateKey = $rsaPrivateKey;
    }

    /**
     * @param string $alipayRsaPublicKey
     */
    public function setAlipayRsaPublicKey($alipayRsaPublicKey)
    {
        $this->alipayRsaPublicKey = $alipayRsaPublicKey;
    }

}
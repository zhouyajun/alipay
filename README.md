# alipay
基于官方sdk3.3.2版本修改的composer版本

### 环境要求
1. php5.5+
2. composer

### 安装方法
`composer require zyj/alipay`

### 使用方法
#### app支付

##### 官方文档
[参数](https://docs.open.alipay.com/204/105301/)

[demo](https://docs.open.alipay.com/54/106370/)

##### 1. 发起支付
```php
$appId = '蚂蚁金服开发平台应用id';
$priKey = '商户私钥';
$pubKey = '支付宝公钥';
$notify_url = '异步回调地址';

$appPayModel = new \zyj\alipay\AppPay([
    'appId' => $appId,
    'rsaPrivateKey' => $priKey,
    'alipayRsaPublicKey' => $pubKey,
    'notifyUrl' => $notify_url,
    'isDev' => false //true 沙箱 false 正式
]);
//发起app支付
$result = $appPayModel->request([
    //对一笔交易的具体描述信息 非必填
    'body' => '测试订单',
    //商品的标题/交易标题/订单标题/订单关键字等。 必填
    'subject' => '测试',
    // 商户平台唯一订单号 必填
    'out_trade_no' => date('YmdHis') . mt_rand(1, 999999),
    // 该笔订单允许的最晚付款时间，逾期将关闭交易。取值范围：1m～15d。m-分钟，h-小时，d-天，1c-当天（1c-当天的情况下，无论交易何时创建，都在0点关闭）。 该参数数值不接受小数点， 如 1.5h，可转换为 90m。注：若为空，则默认为15d。
    'timeout_express' => '30m',
    'total_amount' => 0.01
]);
echo $result;
exit;
```
###### 2. 处理回调
```php
$appPayModel = new \zyj\alipay\AppPay([
    'rsaPrivateKey' => $priKey
]);
if ($appPayModel->notify()) {
    //验签成功
    $trade_status = $_POST['trade_status'];
    // trade_status:
    //WAIT_BUYER_PAY	交易创建，等待买家付款
    //TRADE_CLOSED	未付款交易超时关闭，或支付完成后全额退款
    //TRADE_SUCCESS	交易支付成功
    //TRADE_FINISHED	交易结束，不可退款

    /*
     * 注意：状态TRADE_SUCCESS的通知触发条件是商户签约的产品支持退款功能的前提下，买家付款成功；
     * 交易状态TRADE_FINISHED的通知触发条件是商户签约的产品不支持退款功能的前提下，买家付款成功；或者，商户签约的产品支持退款功能的前提下，交易已经成功并且已经超过可退款期限。
     */
    if ($trade_status == 'TRADE_SUCCESS') {

    }
    echo 'success';
    exit;
} else {
    //  验证签名失败,做相应业务处理
}
```




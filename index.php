<?php
/**
 * Created by PhpStorm.
 * User: zyj
 * Date: 2019/4/17
 * Time: 14:02
 */
require_once './vendor/autoload.php';
//支付回调


$appId = '2016092800616183';
$priKey = 'MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQCD/dzAMSQQgCrab85HvRJbalq1T0Ju7hQ1YIIYPEnZWAn6boUw1Zde6uSuLAyeVnAmdw7hsbAAbBS5KvFSI/nYVf4Y3+aU1fiyM7D5w9Zi8aiq+Z4QzlJ8jZPjQut4FSCfCx/k7khqvDF7kar+el2O+f3dRFeu3zA0NbYoD6aY7otAi1XPZkbv8R+Wi6gGEzCCuTGYTsRVKGpB8XwdJWZ1AVY4+lF8MgB39Luh2RqvX9VO3m1a/0E9Y47DJS1ve9yZHZvL+qJ/JXVWOZwH3n2n/c/tEQU5X6SLau5wC8qgU4kRjs8fFIY/ociIhs541FJCQPZR5zEACp7qYPHWJxY3AgMBAAECggEAUbfXd0o1WN3xKiI0pWeiuORE2qICsGlIK6/fe5+/3QdLzjek0JI80HA/OrJc8Z70emwV05fOLsS7o9S5abCKW+0Jj174BEfhXHryZABieAnD8m7u9Nq4aRLCb96bqFH0S2N40KTSQvrW6/lI05rw17dg/B/25XabAogKigz+iQmreRXvyhRHwcwoWz6pW2IMI95xt4wFGJZCUfvsAzdOYhiNz2fFSmEZ8WZJPTnQAToPFVQVoWAEwJz02syXGdgFr0lFlqpbvzU9BvN3wOkm8Xtya6q9gz2gbJtLFGLl1o2e/1Ke798fF5oT9ZHtMqACKfNejIyLFOV6qlVtlcVEkQKBgQC+z7Iy/4f+Fr2VC9BBNZSt08ALyW/WHxP6IWpDXIlnTDsfMaNgmyPpcTwJNKhwQkb8ceCWWfMtsx/Ba8/4/I1e2wdW0ZvEYVfsVDzKNbOkXFhW76PTYPCkMdCLwdMRjaVSGPzpEEkrosZzwJnG4deHfBnFah7z4oHKMVxV8pCyfwKBgQCxFdChv687Fl1AQowT+rNsXjXgmfTTd/WXpz/Og/S9Vox1znbBHeMKHt2gqz3lFv5b1E8UJqWC8IJK9f8Tw5bGociiXmRuCmoa+obgFxjcpeYEdNXda7eUU7MIFlgan+R4pRZuJXg5CU5qZ7jsLb86K95KScpSuNJk1a/YDaPQSQKBgQCDfsajdo3VgP5tdJK0HaS0ljTG6q7ztL8jpVuByIe4dERaHu8kaEW7XpmtDmj10/bvidroQlzfpY3A0fek8wbJ08+e+RyLnTnmV7b88z01i54la0hPJ4Mu5FV/urcmZaMEjMveIacLN0XkB1ryQDkz2UY5UgS6teIT4Shs4pjtKQKBgAKw9i6/Hwai3F/xovdaxAdNlzwGmvXryMu5OvsEfl+yRQg1TxC4R48L0Qp0D8i/hLYYj+sae0F2LkS9YFcIje4O32G4VYZmmh422H3nW/VegBRpQibPUEbszre8vzIIZAyBVcnuv9j+DzcGxISyXUmhCQvP+0cuj+QAa1+5NVghAoGAGOBIHDsH/PiM/5WfWA6fSM4b2eBTvelBVYcF05x6jUd8O8X258GwEqvYPdI/yFVI4Znm9utZfWC+Vh3qkCU/Mdja4PWMRwfmqiNv+WFSA7Bxmw2Hj+uf59axwUQwSo+rKuG2wPt0+1Yz6NGDu5uwSoV9BXkKHV+CVNKvrnjpALs=';
$pubKey = 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAtvLr/QnivAtyBAciFafKmvAA6nLkDiAWTJdNBF6smbtvyWK+Oy2y08Oa2IkOoYw2JDEwqcelHLAEvwywljcJeVlKlOdzmMdp3siVT8YAVpX60yyLO7/eL13x/cTgn3klvyDIefEDn6wAKk/10XZAMWI0Ep3fy6/njihUQrzL2YM58DY+gqDF/d8oM1iK++PbIIuafvGoFrJXd01AfMjJFeZt0U3yA4lzlNZHjm3VpKStl4j+TbtNwNXXQT/jwO34Fy7ilazmzhjLiDwzjhRI/zUAW2KVgafZXe0R+B6CJEllhbqIJHpyfsqn9NsEJrBC4R2GHSyBJVqv0OxSNv6TSQIDAQAB';
$notify_url = 'http://cs.itsurfing.cn';

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
//exit;
//回调写法
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


<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <script type="text/javascript" src="<?php echo ($domain); ?>/Static/Js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo ($domain); ?>/Static/Js/qrcode.js"></script>
    <title>支付页面</title>
</head>
<body>

<div id="js_qrcode"></div>

</body>
<script type="text/javascript">

    var _qrCodeUrl = "<?php echo ($codeUrl); ?>";

    function getQrCode( qrCodeUrl ){
        var qrcode = new QRCode(document.getElementById("js_qrcode"), {
            width : 150,//设置宽高
            height : 150
        });
        qrcode.makeCode( qrCodeUrl );
    }

    getQrCode(_qrCodeUrl);

</script>
</html>
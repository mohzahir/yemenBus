

<?php
session_start();

$errors = array();
$status = 400;
if (!empty($_POST)) {
    foreach ($_POST as $key => $value) {
        $_GET[$key] = @strip_tags($value);
    }
}
if(isset($_POST['send_email']) && !isset($_SESSION['email_sent'])){
    if(empty($_POST['name']) || empty($_POST['phone']) || empty($_POST['address']) || empty($_POST['city']) || empty($_POST['price']) || empty($_POST['phone_code'])){
        $errors[] = 'جميع الحقول مطلوبة';
    }else{
        if(strlen($_POST['name']) < 3){
            $errors[] = 'يجب أن يحتوي الإسم على 3 حروف أو أكثر';
        }
        if(strlen($_POST['address']) < 3){
            $errors[] = 'يجب أن يحتوي العنوان على 3 حروف أو أكثر';
        }
        if(strlen($_POST['city']) < 3){
            $errors[] = 'يجب أن تحتوي المدينة على 3 حروف أو أكثر';
        }
        if(!in_array($_POST['phone_code'], array('966','967'))){
            $errors[] = 'رقم الدولة خاطئ';
        }
        if(!is_numeric($_POST['phone'])){
            $errors[] = 'رقم هاتف غير صحيح';
        }elseif($_POST['phone_code'] == '966' && strlen($_POST['phone']) != 10){
            $errors[] = ' يجب أن يكون طول رقم الهاتف السعودي 10';
        }elseif($_POST['phone_code'] == '967' && strlen($_POST['phone']) != 9){
            $errors[] = ' يجب أن يكون طول رقم الهاتف اليمني 9';
        }

        if(!is_numeric($_POST['price']) || $_POST['price'] < 50){
            $errors[] = 'تأكد من مبلغ الرصيد المدخل';
        }
        
    }
    if(empty($errors)){
        $data['subject'] = "طلب جديد من : ".$_POST['name'];

        $data['message_body'] = '
        الإسم : '.$_POST['name'].' <br>
        رقم الجوال : +'.$_POST['phone_code'].$_POST['phone'].' <br>
        العنوان : '.$_POST['address'].' <br>
        المدينة : '.$_POST['city'].' <br>
        مبلغ الرصيد : '.$_POST['price'].'
        ';

        $data['from_name'] =  $data['from_name'] . ' : '. $_POST['name'];
        $send_email = NewMail($data);
        if($send_email){
            $status = 200;
            $_SESSION['email_sent'] = true;
        }else{
            $errors[] = "فشل إرسال البريد الإلكتروني , الرجاء التواصل مع مدير الموقع";
        }
        
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="يمن باص - فرصتك للكسب من 80 ريال سعودي الى 150 ريال سعودي يوميا.">
    <meta name="description" content="للحجز تذاكر الباصات والطيران وحجز موعد فحص بالمختبر(P C R للكرونا ) للمسافرين الى اليمن. من خلال -منصة يمن باص- للحجوزات الذكية للمغتربين">
    <meta name="keywords" content="yemenbus , يمن باص , yaman bus, yemen bus, bus, saudia,منصة يمن باص">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/style.css">

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <title>يمن باص - فرصتك للكسب من 80 ريال سعودي الى 150 ريال سعودي يوميا.</title>
    <!-- SEO / Google -->
    <meta name="author" content="يمن باص YemenBus">
    <meta name="description" content="للحجز تذاكر الباصات والطيران وحجز موعد فحص بالمختبر(P C R للكرونا ) للمسافرين الى اليمن. من خلال -منصة يمن باص- للحجوزات الذكية للمغتربين">
    <link rel="canonical" href="https://www.yemenbus.com/"> 

    <!-- Social: Twitter -->
    <!-- After inserting META need to validate at https://dev.twitter.com/docs/cards/validation/validator -->
    <meta name="twitter:card" content="images/global.jpg">
    <meta name="twitter:site" content="يمن باص YemenBus">
    <meta name="twitter:creator" content="">
    <meta name="twitter:title" content="يمن باص - فرصتك للكسب من 80 ريال سعودي الى 150 ريال سعودي يوميا.">
    <meta name="twitter:description" content="للحجز تذاكر الباصات والطيران وحجز موعد فحص بالمختبر(P C R للكرونا ) للمسافرين الى اليمن. من خلال -منصة يمن باص- للحجوزات الذكية للمغتربين">
    <meta name="twitter:image:src" content="images/global.jpg">

    <!-- Social: Facebook / Open Graph -->
    <meta property="fb:admins" content="ID here...">
    <meta property="fb:app_id" content="ID here...">
    <meta property="og:url" content="https://www.yemenbus.com/">
    <meta property="og:type" content="">
    <meta property="og:title" content="يمن باص - فرصتك للكسب من 80 ريال سعودي الى 150 ريال سعودي يوميا.">
    <meta property="og:image" content="images/global.jpg"/>
    <meta property="og:description" content="للحجز تذاكر الباصات والطيران وحجز موعد فحص بالمختبر(P C R للكرونا ) للمسافرين الى اليمن. من خلال -منصة يمن باص- للحجوزات الذكية للمغتربين">
    <meta property="og:site_name" content="يمن باص YemenBus">
    <meta property="article:author" content="https://www.facebook.com/OussamaTuber">
    <meta property="article:publisher" content="https://www.facebook.com/OussamaTuber">

    <!-- Social: Google+ / Schema.org  -->
    <meta itemprop="name" content="يمن باص YemenBus">
    <meta itemprop="description" content="للحجز تذاكر الباصات والطيران وحجز موعد فحص بالمختبر(P C R للكرونا ) للمسافرين الى اليمن. من خلال -منصة يمن باص- للحجوزات الذكية للمغتربين">
    <meta itemprop="image" content="images/global.jpg">

    <style>
        
a:hover{
    text-decoration:none;
}
body,form{
    direction: rtl!important;
}
.header{
    background: #4b4b4be0 url(../images/bg.png);
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
    padding: 3.7rem 0;
    text-align: center;
    background-blend-mode: multiply;
    color: #fff;
}
.header h1{
    color: #00b8ff;
    text-shadow: 1px 2px 4px #2e2e2e;
    margin-bottom: .7rem;
}
.header h4{
    margin-bottom: 1rem;
}

.header a{
    display: block;
    padding: 10px 1.7rem;
    background-color: #00b8ff;
    color: #fff;
    width: max-content;
    margin:0 auto;
    border-radius: 7px;
    margin-top: 2rem;
    box-shadow:2px 2px 7px 0px #16161652;
    white-space: nowrap;
}
.header a{
    transition: all .2s ease-in-out;
}
.header a:hover{
    text-decoration: none;
    opacity: .9;
    box-shadow: inset -2px 5px 9px 0px #16161652;
    padding: 10px 2.1rem;
} 

.form_sec{
    padding: 2rem 1rem;
    box-shadow: 3px 3px 7px 0 #0000004a;
    margin: 2rem;
}

button.btn.my_btn_ {
    margin: 0 auto;
    text-align: center;
    display: block;
    color: #07d717;
    font-size: 18px;
    font-weight: 900;
    background-color: transparent;
    border: solid 2px;
    padding: 6px 2rem;
    box-shadow: 0 0 7px 0 #16161652;
    margin-top: 1rem;
    transition: all .2s ease-in-out;
}
.my_btn_:hover{
    box-shadow: 0 0 9px 0 #16161652;
    opacity: .9;
    padding: 6px 2.2rem!important;
}
.main_header{
    padding: 0.6rem 1rem;
    background-color: #e0e0e0;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.main_header ul{
    list-style: none;
    margin: 0;
}
.main_header ul a{
    color: #33b5e5;
}
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
        }

        /* Firefox */
        input[type=number] {
        -moz-appearance: textfield;
        }
    </style>
</head>
<body>
    <header class="main_header">
        <h4 class="logo">
            <a href="https://www.yemenbus.com/"> يمن باص YemenBus</a>
        </h4>
        <ul>
            <li>
                <a href="https://www.yemenbus.com/contact">تواصل معنا</a>
            </li>
        </ul>
    </header>
    <section class="header">
        <h1>عزيزي المقيم اليمني بالسعودية</h1>
        <h4>فرصتك للكسب من <b class="text-danger">80</b> ريال سعودي الى <b class="text-danger">150</b> ريال سعودي يوميا.</h4>
        <p>للحجز تذاكر الباصات والطيران وحجز موعد فحص بالمختبر(P C R للكرونا ) للمسافرين الى اليمن. من خلال -منصة يمن باص- للحجوزات الذكية للمغتربين</p>
        <a href="https://www.yemenbus.net/" target="_blank">كيف تكون وكيلا ومسوقا</a>
    </section>
    <section class="form_sec col-12 col-md-8 mx-auto">
        <?php if($status == 400 && !isset($_SESSION['email_sent'])){ ?>
        <h4 class="text-center mb-3">قم بملأ الاستمارة التالية</h4>
        <hr>
        <?php } ?>
            <form class="form_" method="POST">
                <?php if(!empty($errors)){ ?>
                    <ul class="alert alert-danger">
                    <?php foreach($errors as $error){ ?>
                        <li><?= $error; ?> .</li>
                    <?php } ?>
                    </ul>
                <?php }elseif($status == 200 || isset($_SESSION['email_sent'])){ ?>
                    <div class="alert alert-success text-center">لقد تلقينا رسالة البريد الإلكتروني الخاصة بك , شكرا لك .</div>
                <?php } ?>
                <?php if($status == 400 && !isset($_SESSION['email_sent'])){ ?>
                <div class="form-row">
                    <div class="form-group col-md-6">
                    <label for="name">الإسم</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="الإسم" value="<?= @$_POST['name'] ?>">
                    </div>
                    <div class="form-group col-9 col-md-4">
                    <label for="phone">رقم الجوال</label>
                    <input type="text" class="form-control" name="phone" id="phone"  value="<?= @$_POST['phone'] ?>" placeholder="05xxxxxxxx">
                    </div>
                    <div class="form-group col-3 col-md-2">
                    <label for="phone_code">الدولة</label>
                    <select id="phone_code" name="phone_code" class="form-control">
                        <option value="966" selected>966+</option>
                        <option value="967">967+</option>
                    </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="address">العنوان</label>
                    <input type="text" class="form-control" name="address" id="address"  value="<?= @$_POST['address'] ?>" placeholder="العنوان">
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="city">المدينة</label>
                        <input type="text" class="form-control"  value="<?= @$_POST['city'] ?>" placeholder="المدينة" name="city" id="city">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="price">مبلغ الرصيد (يبدأ ب 50 ريال سعودي)</label>
                        <input type="text" class="form-control" name="price" id="price" value="<?= @$_POST['price'] ?>" placeholder="مبلغ الرصيد">
                    </div>
                </div>
                <input type="hidden" name="send_email">
                <a href="https://www.yemenbus.com/trips/order">رابط حجز التذاكر</a>
                <button type="submit" class="btn my_btn_">أرسل</button>
                <?php } ?>
            </form>
    </section>
    <section class="whatsapp form_sec col-12 col-md-8 mx-auto text-center">
        <h4>للحجز <span style="color:#25D366;">واتس اب</span></h4>
        <h5>966507276370+</h5>
    </section>
    <script>
        $(function(){
            $('.form_').on('submit',function(){
                $('.my_btn_').text('جاري الإرسال ...').attr('disabled','disabled');
            })
            $('select[name="phone_code"]').on('change',function(){
                if($(this).val() == '966'){
                    $('input[name="phone"]').attr('placeholder','05xxxxxxxx');
                }else{
                    $('input[name="phone"]').attr('placeholder','7xxxxxxxx');
                }
            })
            $('input[name="phone"],select[name="phone_code"]').on('input change',function(){
                $('input[name="phone"]').attr('type','number');
                var phone = $('input[name="phone"]').val();
                var phone_code = $('select[name="phone_code"]').val();
                if(phone_code == 966 && phone.length>10){
                    phone = phone.substring(0,10);
                }else if(phone_code == 967 && phone.length>9){
                    phone = phone.substring(0,9);
                }
                $('input[name="phone"]').val(phone);
            })
        })
    </script>
</body>
</html>


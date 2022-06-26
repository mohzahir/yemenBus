<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="{{url('assets/css/style.css')}}">
    <title>حجز تذكرة - يمن باص</title>
</head>

<body>
    <div class="container">
        <div class="row mt-5">
            <hr>
            <div class="col-12 text-center mb-4">
                <h2>حجز تذكرة يمن باص</h2>
            </div>

            <hr>

            {!! alert("danger",session("error"),false) !!}
            {!!  alert("success",session("success"),false) !!}
            {!!  validationErrors() !!}

            <div class="col-12 text-right">
                <form action="" method="POST">
                    @csrf
                    {!! Form::input("mob",["placeholder" => "967 أو 9665"]) !!}
                    {!! Form::select("daynumber",range(1, 31)) !!}
                    {!! Form::select("monthnumber",range(1, 12)) !!}
                    {!! Form::select("day",getJsonFromLocal("days")) !!}
                    {!! Form::input("fromcity") !!}
                    {!! Form::input("tocity") !!}
                    {!! Form::input("tickets",["type" => "number"]) !!}
                    <hr class='mt-4 mb-4'>
                    {!! Form::input("tname",["required" => false,"extra" => "maxlength=40"]) !!}
                    {!! Form::input("company",["required" => false]) !!}
                    {!! Form::input("totalprice",["required" => false,"type" => "number"]) !!}
                    {!! Form::input("recamount",["required" => false,"type" => "number","value" => "0"]) !!}
                    {!! Form::select("currency",getJsonFromLocal("currencies"),["required" => false]) !!}
                    {!! Form::input("remamount",["required" => false,"type" => "number","value" => "0"]) !!}

                    {!! Form::textarea("notes",["required" => false]) !!}
                    {!! Form::input("mname",["required" => false]) !!}
                    {!! Form::input("mmob",["required" => false]) !!}
                    {!! Form::input("ncode",["required" => false]) !!}
                    {!! Form::input("thecity",["required" => false]) !!}





                    {!! Form::submit() !!}

                </form>
            </div>
        </div>
    </div>


    <footer class="bg-dark text-center text-lg-start">
        <div class="container p-4">
            <div class="row">
                <div class="col-lg-6 col-md-12 mb-4 mb-md-0 text-white">
                    <p>
                        الشخص الذي يعمل حجز للغيره سوف يحصل علىى عمولة مقدارها 5٪ من قيمة التذكرة.
                    </p>
                    <p>
                        اتصل على الرقم أو أرسل رسالة واتساب : <a href="tel:00966507276370">
                            00966507276370
                        </a>
                    </p>
                </div>

                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <ul class="list-unstyled mb-0">
                        <li>
                            <a href="https://khamsat.com/redirect?url=aHR0cHM6Ly93d3cueWVtZW5idXMuY29tLw==" class="text-white">أسعار التذاكر اليوم</a>
                        </li>
                        <li>
                            <a href="https://api.whatsapp.com/send?phone=+966507276370" class="text-white">محادثة فورية واتس اب مع مسؤل الحجز</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
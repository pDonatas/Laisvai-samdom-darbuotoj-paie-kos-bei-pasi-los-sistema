<head>
    <title>PHP Contact Form - Email Method - Hyvor Developer</title>
    <style type="text/css">

        body {
            background-color:#fafafa;
        }
        form {
            width:50%;
            margin:auto;
        }
        .input-wrap {
            padding:20px 0;
        }
        .label {
            display:block;
            margin-bottom:2px;
        }
        input, textarea {
            border:1px solid #eee;
            padding:6px;
            border-radius:3px;
            width:100%;
        }
        textarea {
            height:200px;
            resize:none;
        }
        .submit-button {
            padding:10px;
        }
    </style>

</head>
<body>
@isset($success)
    forma išsiųsta
    @endisset
<form method="POST" action="{{route('contactform')}}">
    <div class="input-wrap">
        <span class="label">Email:</span>
        <input type="email" name="email">
    </div>
    <div class="input-wrap">
        <span class="label">Reason:</span>
        <input type="text" name="reason">
    </div>
    <div class="input-wrap">
        <span class="label">Message:</span>
        <textarea name="message"></textarea>
    </div>

    <div class="input-wrap">
        <input type="submit" name="submit" value="Submit" class="submit-button">
    </div>
</form>



</body>
</html>

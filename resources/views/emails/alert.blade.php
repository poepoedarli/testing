<html>
    <head>
    </head>
    <body>
        <div style="color:black; font-family: sans-serif; font-size: 0.9rem; margin-bottom: 1rem">
            Dear {{$name}},
        </div>
        <div style="color:black; font-family: sans-serif; font-size: 0.9rem; margin-bottom: 1rem">
            
            {{ $content }}

        </div>
        <div style="color:black; font-family: sans-serif; font-size: 0.9rem; margin-bottom: .2rem">
            With Regards,
        </div>
        <div style="color:black; font-family: sans-serif; font-size: 0.9rem; margin-bottom: 1rem">
            {{$from_email}}
        </div>
    </body>
<html>
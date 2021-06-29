<html>
    <head></head>
    <body>
        <div style="text-align: center; margin-bottom: 10px;">
            <!-- Cambiar el nombre del header -->
            <img src="{{asset('img/logo.jpeg')}}" style='width: 100%; max-width: 215px;'>
        </div>
        <div style="text-align: justify; padding: 2% 10%;background: whitesmoke; color: #242442;">
            <h1 style="margin-top: 0px;">{{$content['subject']}}</h1>
            <p style="margin-bottom: 0px;">{{$content['content']}}</p>
        </div>
        <div style="text-align:center; background:#242442; font-size:15px; font-weight:900; padding:6px 0px; color: floralwhite">
            <span>Desarrollado por Bridge Studio</span>
        </div>
    </body>
</html>
<h1>SocketStream</h1>
<div id="SocketStream">

</div>
<script src="{{$THEME}}/js/libs/socket.io.js"></script>
<script>
    var socket = io('http://localhost:5000');
    socket.on('connect', function(){
        console.log("connect");
    });
    socket.on('event', function(data){
        console.log(data);
    });
    socket.on('disconnect', function(){
        console.log("disconnect");
    });
</script>

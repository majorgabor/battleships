$(document).ready(function() {
    $("#matchMaking").on("click", function(){
        const webSock = new WebSocket("ws://192.168.0.8:6060");
        var maker;
        
        const username = window.location.pathname.split("/").slice(-2)[1];

        webSock.onopen = function(){
            sendMassage("NAME", username);
            maker = setInterval(() => {
                sendMassage("MATCHMAKE", null);
            }, 5000);
        };
    
        webSock.onmessage = function(event){
            answer =  JSON.parse(event.data);
            switch(answer.type) {
                case "INFO":
                    $("#serverInfo").html(answer.data);
                    break;
                case "ENEMY":
                    console.log(answer.data);
                    setTimeout(() => {
                        window.location = "../game/"+username+"/"+answer.data;
                    }, 1000);
                    break;
            }
        };
    
        webSock.onclose = function(){
            console.log("connection closed.");
            clearInterval(maker);
        };
    
        webSock.onerror = function(){
            webSock.close();
        };

        $("#abortMatchMake").on("click", function(){
            sendMassage("ABORT", username);   
        });
    
        function sendMassage(type, data) {
            const message = {
                type: type,
                data: data,
            };
            webSock.send(JSON.stringify(message));
        }
    });
});
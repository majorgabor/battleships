$(document).ready(function() {
    $("#matchMaking").on("click", function(){
        const webSock = new WebSocket("ws://localhost:6060");
        var maker;
    
        webSock.onopen = function(){
            sendMassage("NAME", "$scope.user.username");
            maker = setInterval(() => {
                sendMassage("MATCHMAKE", null);                
            }, 5000);
        };
    
        webSock.onmessage = function(event){
            answer =  JSON.parse(event.data);
            switch(answer.type) {
                case "INFO":
                    console.log(answer.data);
                    break;
                case "ENEMY":
                    console.log(answer.data);
                    setTimeout(() => {
                        window.location = "./game/"+"$scope.user.username"+"/"+answer.data;
                    }, 1000);
                    break;
            }
        };
    
        webSock.onclose = function(){
            console.log("connection closed.");
            clearInterval(maker);
            $scope.websock = "";
        };
    
        webSock.onerror = function(){
            $scope.websock = "Server error.";
            webSock.close();
        };
    
        $scope.abortMatchMaking = function() {
            sendMassage("ABORT", "$scope.user.username");
        };
    
        function sendMassage(type, data) {
            const message = {
                type: type,
                data: data,
            };
            webSock.send(JSON.stringify(message));
        }
    });
});
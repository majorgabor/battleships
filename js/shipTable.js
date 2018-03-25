
let shipArray = [];

var myShips = document.getElementById("myShips");
var table = document.createElement("table");
for(i = 0; i < 10; i++){
    var tr = document.createElement("tr");
    shipArray[i] = [];
    for(j = 0; j < 10; j++){
        var td = document.createElement("td");
        td.setAttribute("data-x", j);
        td.setAttribute("data-y", i);
        tr.appendChild(td);
        shipArray[i][j] = undefined;
    }
    table.appendChild(tr);
}
myShips.appendChild(table);

const shipSize = [null, 1, 1, 2, 2, 3, 4, 5];

function isPlacebal(x, y, orientation, length){
    if(orientation === "horisontal"){
        if(x > 10-length) return false;
        if(y > 0){
            for(i = 0; i < length; i++){
                if(shipArray[x+i][y-1]) return false;
            }    
        }
        if(x > 0){
            if(shipArray[x-1][y]) return false;            
        } 
        for(i = 0; i < length; i++){
            if(shipArray[x+i][y]) return false;
        }
        if(x+length < 9){
            if(shipArray[x+length][y]) return false;            
        } 
        if(y < 9){
            for(i = 0; i < length; i++){
                if(shipArray[x+i][y+1]) return false;
            }    
        }
    } else if(orientation === "vertical") {
        if(y > 10-length) return false;
        if(x > 0){
            for(i = 0; i < length; i++){
                if(shipArray[x-1][y+i]) return false;
            }    
        }
        if(y > 0){
            if(shipArray[x][y-1]) return false;            
        } 
        for(i = 0; i < length; i++){
            if(shipArray[x][y+i]) return false;
        }
        if(y+length < 9){
            if(shipArray[x][y+length]) return false;            
        } 
        if(x < 9){
            for(i = 0; i < length; i++){
                if(shipArray[x+1][y+i]) return false;
            }    
        }
    } else {
        return false;
    }
    return true;
}

function markShip(x, y, orientation, length, type){
    if(orientation === "horisontal"){
        for(i = 0; i < length; i++){
            shipArray[x+i][y] = type;
            $("#myShips").find("td[data-x="+ (x+i) +"][data-y="+ y +"]").css("background","#343a40");
        }
    } else if(orientation === "vertical"){
        for(i = 0; i < length; i++){
            shipArray[x][y+i] = type;            
            $("#myShips").find("td[data-x="+ x +"][data-y="+ (y+i) +"]").css("background","#343a40");
        }
    }
}

$(document).ready(function(){
    $("#ready").hide();
    
    let placeinfShipId = 7;
    
    $("#myShips").find("td").on("click", function(){
        let x = parseInt(this.dataset.x);
        let y = parseInt(this.dataset.y);
        if(isPlacebal(x, y, "horisontal", shipSize[placeinfShipId])){
            markShip(x, y, "horisontal", shipSize[placeinfShipId], placeinfShipId);
            placeinfShipId--;
        }
        if(placeinfShipId === 0){
            $("#ready").show();    
        }
    }).on("contextmenu", function(){
        let x = parseInt(this.dataset.x);
        let y = parseInt(this.dataset.y);
        if(isPlacebal(x, y, "vertical", shipSize[placeinfShipId])){
            markShip(x, y, "vertical", shipSize[placeinfShipId], placeinfShipId);
            placeinfShipId--;
        }
        if(placeinfShipId === 0){
            $("#ready").show();  
        }
    });
    
    $("#reset").on("click", function(){
        $("#ready").hide();
        placeinfShipId = 7;
        for(i = 0; i < 10; i++){
            for(j = 0; j < 10; j++){
                shipArray[i][j] = undefined;
                $("#myShips").find("td[data-x="+ i +"][data-y="+ j +"]").css("background","inherit");
                
            }
        }
    });

    $("#ready").on("click", function(){
        $("#shipPlaceButtons").hide();
    });

    $("#random").on("click", function(){
        $("#reset").trigger("click");
        let orientation;
        let x, y;
        while(placeinfShipId > 0){
            if(Math.random() >= 0.5){
                orientation = "horisontal";
            } else {
                orientation = "vertical";
            }
            x = Math.floor(Math.random() * 10);
            y = Math.floor(Math.random() * 10);
            if(isPlacebal(x, y, orientation, shipSize[placeinfShipId])){
                markShip(x, y, orientation, shipSize[placeinfShipId], placeinfShipId);
                placeinfShipId--;
            }
        }
        $("#ready").show();        
    });
});
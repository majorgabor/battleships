
var myShips = document.getElementById("myBattlefield");

var table = document.createElement("table");


for(i = 0; i < 10; i++){
    var tr = document.createElement("tr");
    for(j = 0; j < 10; j++){
        tr.appendChild(document.createElement("td"));
    }
    table.appendChild(tr);
}

myShips.appendChild(table);
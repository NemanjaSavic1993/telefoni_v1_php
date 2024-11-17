function deleteRec(id, table, action){
    let data = {
        id : id,
        table : table,
        action : action
    };

    let yes = confirm("Da li ste sigurni da zelite da obrisete podatak?");

    if(yes){
        DB.delete(data).then((res)=>{
            if(res == 'success'){
                location.reload();
            }
        },(err)=>{
            console.log(err)
        })
    }
}

//  start administriranje korisnika
function editUser(id, table, action, role){
    let data = {
        id : id,
        table : table,
        action : action,
        role : role
    };

    let yes = confirm("Da li ste sigurni da zelite promenite korisniku ulogu u sistemu?");

    if(yes){
        DB.updateUser(data).then((res)=>{
            if(res == 'success'){
                location.reload();
            }
        },(err)=>{
            console.log(err)
        })
    }
}
// end administriranje korisnika

// start administriranje proizvodjaca
let btnAddProd = document.querySelector("#btnAddProd");
let btnBackProd = document.querySelector("#btnBackProd");
let btnEditBackProd = document.querySelector("#btnEditBackProd");

if(btnAddProd != null){
    btnAddProd.addEventListener('click',function(){
        document.getElementById("tableProd").style.display = "none";
        document.getElementById("addProd").style.display = "block";
    });
    
    btnBackProd.addEventListener('click',function(){
        document.getElementById("addProd").style.display = "none";
        document.getElementById("tableProd").style.display = "block";
    });
    
    btnEditBackProd.addEventListener('click',function(){
        document.getElementById("editProd").style.display = "none";
        document.getElementById("tableProd").style.display = "block";
    });
}


function editProducer(id, table, action){

    let data = {
        id : id,
        table : table,
        action : action
    };

    DB.getData(data).then((data)=>{
        // console.log(data.name);
        document.querySelector('[name="producer_name_edit"]').value = data.name;
        document.querySelector('[name="pid"]').value = data.id;

        document.getElementById("tableProd").style.display = "none";
        document.getElementById("editProd").style.display = "block";
    },(err)=>{
        console.log(err)
    })

    
}

// end administriranje proizvodjaca

// start administriranje modela
let btnAddModel = document.querySelector("#btnAddModel");    
let btnBackModel = document.querySelector("#btnBackModel");
let btnEditBackModel = document.querySelector("#btnEditBackModel");

if(btnAddModel != null){
    btnAddModel.addEventListener('click', function(){
        document.getElementById("addModel").style.display = "block";
        document.getElementById("tabelModel").style.display = "none";
    });

    btnBackModel.addEventListener('click', function(){
        document.getElementById("addModel").style.display = "none";
        document.getElementById("tabelModel").style.display = "block";
    });
    
    btnEditBackModel.addEventListener('click', function(){
        document.getElementById("editModel").style.display = "none";
        document.getElementById("tabelModel").style.display = "block";
    });
}

function editModel(id, table, action){
    let data = {
        id : id,
        table : table,
        action : action
    };

    DB.getData(data).then((data)=>{
        console.log(data);
        document.querySelector('[name="edit_model_name"]').value = data.name;
        document.querySelector('[name="mid"]').value = data.id;
        document.querySelector('[name="edit_model_description"]').value = data.description;
        document.querySelector('[name="edit_model_price"]').value = data.price;
        document.querySelector('[name="edit_model_quantity"]').value = data.quantity;

        for(var i=0; i < document.querySelector('[name="edit_model_producer"]').options.length; i++){
            if(document.querySelector('[name="edit_model_producer"]').options[i].value == data.id_producer){
                document.querySelector('[name="edit_model_producer"]').options[i].setAttribute('selected', true);
            }
        }
            

        document.getElementById("tabelModel").style.display = "none";
        document.getElementById("editModel").style.display = "block";
    },(err)=>{
        console.log(err)
    })
}

// end administriranje modela
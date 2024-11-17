class DB{
    static delete(data){
        return new Promise((reslove,reject)=>{
            let xml = new XMLHttpRequest();
            
            xml.onreadystatechange = () => {
                if(xml.readyState == 4 && xml.status == 200){
                    reslove(xml.responseText);
                }
            }

            xml.open('POST', 'api.php');
            xml.setRequestHeader("Content-Type", "application/json");
            xml.send(JSON.stringify(data));
        })
    } 

    static updateUser(data){
        return new Promise((reslove,reject)=>{
            let xml = new XMLHttpRequest();
            
            xml.onreadystatechange = () => {
                if(xml.readyState == 4 && xml.status == 200){
                    reslove(xml.responseText);
                }
            }

            xml.open('POST', 'api.php');
            xml.setRequestHeader("Content-Type", "application/json");
            xml.send(JSON.stringify(data));
        })
    }

    static getData(data){
        return new Promise((reslove,reject)=>{
            let xml = new XMLHttpRequest();
            
            xml.onreadystatechange = () => {
                if(xml.readyState == 4 && xml.status == 200){
                    reslove(JSON.parse(xml.responseText));
                }
            }

            xml.open('POST', 'api.php');
            xml.setRequestHeader("Content-Type", "application/json");
            xml.send(JSON.stringify(data));
        })
    }
}
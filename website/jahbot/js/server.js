const SERVER_ADDRESS = 'http://localhost:8008';

async function serverRequest(module, method, data) {
    return new Promise((resolve, reject) => {
        let reqData = {
            method: method
        };
        
        if (data) reqData.body = data;
        
        let res = fetch(SERVER_ADDRESS + '/' + module, reqData)
        .then((res) => {
            res.json()
            .then((data) => {
                resolve(data);
            })
            .catch((err) => {
                reject('Failed to parse JSON: ' + err);
            })
        })
        .catch((err) => {
            reject(err);   
        })
    });
}
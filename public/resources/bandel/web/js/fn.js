function fn_errorJqXHR(jqXHR, statusText){
    const messagesError = {
        0 : {
            message : 'Sin conexion a internet.'
        },
        404:{
            message: 'No se encontro la página solicitada'
        },
        500: {
            message: 'Se presento un error en el servidor'
        },
        'parsererror' : {
            message: 'Error de Json Solicitado'
        },
    };


    let codJqXHR = parseInt(jqXHR.status);
    let codError = messagesError[codJqXHR];
    let messageResult = (codError)? codError.message : messagesError[statusText].message;

    if(codJqXHR && messageResult){
        alert(`${messageResult}`)
    }
}
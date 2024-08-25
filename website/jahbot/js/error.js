function error(msg) {
    window.parent.postMessage({
        type: 'error',
        msg: msg
    }, '*');
}
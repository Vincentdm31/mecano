const qrcode = window.qrcode;

let video = document.createElement("video");
let canvasElement = document.getElementById("qr-canvas");
let canvas = canvasElement.getContext("2d");

let qrResult = document.getElementById("qr-result");
let outputData = document.getElementById("outputData");
let btnScanQR = document.getElementById("btn-scan-qr");
let btnStopQR = document.getElementById("btn-stop-qr");

let qrCodeResult = document.getElementById("qr-code-result");

let scanning = false;

qrcode.callback = (res) => {
    if (res) {
        outputData.innerText = res;
        qrCodeResult.value = res;
        scanning = false;
        btnScanQR.classList.remove("hide");
        btnStopQR.classList.add("hide");
        video.srcObject.getTracks().forEach((track) => {
            track.stop();
        });

        qrResult.hidden = false;
        canvasElement.hidden = true;
        btnScanQR.hidden = false;
    }
};

btnScanQR.onclick = () => {
    console.log('test');
    btnScanQR.classList.add("hide");
    btnStopQR.classList.remove("hide");
    navigator.mediaDevices
        .getUserMedia({ video: { facingMode: "environment" } })
        .then(function (stream) {
            scanning = true;
            qrResult.hidden = true;
            btnScanQR.hidden = true;
            canvasElement.hidden = false;
            video.setAttribute("playsinline", true);
            video.srcObject = stream;
            video.play();
            tick();
            scan();
        });
};

btnStopQR.onclick = () => {
    scanning = false;
    video.srcObject.getTracks().forEach((track) => {
        track.stop();
    });
    qrResult.hidden = true;
    canvasElement.hidden = true;
    btnScanQR.classList.remove("hide");
    btnStopQR.classList.add("hide");
};

function tick() {
    canvasElement.height = video.videoHeight;
    canvasElement.width = video.videoWidth;
    canvas.drawImage(video, 0, 0, canvasElement.width, canvasElement.height);

    scanning && requestAnimationFrame(tick);
}

function scan() {
    try {
        qrcode.decode();
    } catch (e) {
        setTimeout(scan, 200);
    }
}

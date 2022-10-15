function DownloadFile(fileName) {
    var url = "assets/files/" + fileName;
    var a = document.createElement("a");
    a.setAttribute("download", fileName);
    a.setAttribute("href", url);
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
};
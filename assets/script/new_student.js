function DownloadFile(fileName) {
    var url = "assets/files/" + fileName;
    var a = document.createElement("a");
    a.setAttribute("download", fileName);
    a.setAttribute("href", url);
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
};
function goto_excel_upload(){
    window.location.href='template?page=student&sub_page=new_student_excel_upload&course_id='+course_id;
}
function course_selected(value){
    window.location.href = 'template?page=student&course_id2='+value;
}
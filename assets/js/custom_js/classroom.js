$(document).ready(function() {
    var data = (document.getElementById('cb_course').value).split(",");
    course_id = data[0];
    var year_no = data[1];
    cb_year.innerHTML = ``;
    var options = ``;
    for(let i=1;i<=year_no;i++){
        var checked = ``;
        if(selected_year==i){
            checked = `selected`;
        }
        options +=` <option value="`+i+`" `+checked+`>ປີ `+i+`</option>`;
    }
    cb_year.innerHTML = options;
});
function course_selected(value){
    var data = value.split(",");
    course_id = data[0];
    var year_no = data[1];
    cb_year.innerHTML = ``;
    var options = ``;
    for(let i=1;i<=year_no;i++){
        var checked = ``;
        if(selected_year==i){
            checked = `selected`;
        }
        options +=` <option value="`+i+`" `+checked+`>ປີ `+i+`</option>`;
    }
    cb_year.innerHTML = options;
}
function showdata(){
    var selected_year = document.getElementById('year_no').value;
    window.location.href="template?page=classroom&course_id="+course_id+"&selected_year="+selected_year;
}
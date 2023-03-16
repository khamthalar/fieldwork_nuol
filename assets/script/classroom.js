$(document).ready(function() {
    var data = (document.getElementById('cb_course').value).split(",");
    course_id = data[0];
    year_no = data[1];
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
change_status_modal.addEventListener('show.bs.modal', function(event) {
    var class_data = $(event.relatedTarget);
    var classroom_id = class_data.data('classroom_id');
    var classroom_status = class_data.data('classroom_status');
    var classroom_des = class_data.data('classroom_des');
    document.getElementById('classroom_id').value = classroom_id;
    document.getElementById('classroom_status').value = classroom_status;
    if(classroom_status==1){
        document.getElementById('detail').innerHTML = "ທ່ານຕ້ອງການປິດໃຊ້ງານຫ້ອງຮຽນ '"+classroom_des+"' ແມ່ນບໍ່?";
        document.getElementById('btn_save').innerHTML=`ປິດໃຊ້ງານ`;
    }else{
        document.getElementById('detail').innerHTML = "ທ່ານຕ້ອງການເປີດໃຊ້ງານຫ້ອງຮຽນ '"+classroom_des+"' ແມ່ນບໍ່?";
        document.getElementById('btn_save').innerHTML=`ເປີດໃຊ້ງານ`;
    }
});

function course_selected(value){
    var data = value.split(",");
    course_id = data[0];
    year_no = data[1];
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

function decode( text ) {
    return text
        .replaceAll( "#amp;",'&' )
        .replaceAll( "#quot;",'"' )
        .replaceAll( "#plus;",'+' )
        .replaceAll( "#039;","'" )
  }
  function encode( text ) {
    return text
        .replace( /&/g, "#amp;" )
        .replace( /"/g, "#quot;" )
        .replace( /\+/g, "#plus;" )
        .replace( /'/g, "#039;" );
  }
$(document).ready(function() {
    var data = (document.getElementById('cb_course').value).split(",");
    course_id = data[0];
    year_no = data[1];
    set_year();
});
function course_selected(value){
    var data = value.split(",");
    course_id = data[0];
    year_no = data[1];
    selected_year = 1;
    classroom_id = 0;
    set_year();
}
function set_year(){
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
    load_class(course_id, selected_year)
}
function load_class(_course_id, _year_no){
    var param = {
        course_id:_course_id,
        year_no:_year_no
    }
    var http = new XMLHttpRequest();
    http.open( "POST", 'controller/register_controller.php', true );
    http.setRequestHeader( 'Content-type', 'application/x-www-form-urlencoded' );
    http.onreadystatechange = function () {
        if ( this.readyState === XMLHttpRequest.DONE && this.status === 200 ) {
            cb_class.innerHTML = ``;
            var classroom_str = ``;
            if(classroom_id==0){
                classroom_str +=`<option value='0' selected>ບໍ່ລະບຸ</option>`;
            }else{
                classroom_str +=`<option value='0'>ບໍ່ລະບຸ</option>`;
            }
            var class_data = JSON.parse( this.responseText );
            class_data.forEach(classroom => {
                var selected = '';
                if(classroom_id==classroom.classroom_id){
                    selected='selected';
                }
                classroom_str +=`<option value='`+classroom.classroom_id+`' `+selected+`>`+classroom.classroom_des+`</option>`;
            });
            cb_class.innerHTML = classroom_str;
            console.log(class_data);
        }
    }
    var _param = encode( JSON.stringify( param ) );
    http.send( "class_data=" + _param );

}
function year_selected(value){
    selected_year = value;
    classroom_id = 0;
    load_class(course_id, selected_year);
}
function encode( text ) {
    return text
        .replace( /&/g, "#amp;" )
        .replace( /"/g, "#quot;" )
        .replace( /\+/g, "#plus;" )
        .replace( /'/g, "#039;" );
}
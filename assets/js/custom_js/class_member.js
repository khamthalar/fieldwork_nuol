var student_data;
$(document).ready(function() {
    load_student_data();
});
function load_student_data(){
    var param = {
        course_id:course_id,
        school_year:school_year
    }
    var http = new XMLHttpRequest();
    http.open( "POST", 'controller/class_member_controller.php', true );
    http.setRequestHeader( 'Content-type', 'application/x-www-form-urlencoded' );
    http.onreadystatechange = function () {
        if ( this.readyState === XMLHttpRequest.DONE && this.status === 200 ) {
            try {
                let result = JSON.parse( this.responseText );
                console.log(result);
                if(result.success){
                    student_data = result.body;
                    render_datatable();
                }
                
            } catch (error) {
                Swal.fire( { icon: 'error', html: `<span class="notosans">ເກີດຂໍ້ຜິດພາດທີ່ Server, ກະລຸນາຕິດຕໍ່ຫາ admin ເພື່ອກວດສອບ</span>` } );
            }
            
            // Swal.resumeTimer();
            console.log("%c student_data:","color:red; font-size:2rem;",student_data);
        }
    }
    var _param = encode( JSON.stringify( param ) );
    http.send( "student_data=" + _param );
}
function render_datatable(){
    var tb_std = document.getElementById("student-data");
    if(student_data){
        var row_str=``;
        var row_no = 0;
        student_data.forEach(el => {
            row_no++;
            var class_data = JSON.parse(el.class_data);
            // console.log("%c class_data"+row_no+":","color:red; font-size:2rem;",class_data);
            row_str +=`<td class="col-id notosans f12 center">`+row_no+`</td>
            <td class="notosans f12">`+el.student_code+`</td>
            <td class="notosans f12">`+el.gender+` `+el.name_la+` `+el.surname_la+`</td>
            <td class="notosans">`;
            class_data.forEach(classroom=>{
                if(classroom.classroom_id==el.classroom_id){
                    row_str +=`<button type="button" class="btn btn-success btn-icon-text btn-rounded none-select none-outline mr-1">
                    `+classroom.classroom_des+`</button>`;
                }else{
                    row_str +=`<button type="button" class="btn btn-primary btn-icon-text btn-rounded none-select none-outline mr-1">
                    `+classroom.classroom_des+`</button>`;
                }
            });
            row_str +=`</td></tr>`;
        });
        tb_std.innerHTML = row_str;
    }
}
function course_selected(value){
    window.location.href="template?page=class_member&course_id="+value+((show_status==="1")?"":("&status="+show_status));
}
function status_change(value){
    window.location.href="template?page=class_member&course_id="+course_id+((value==="1")?"":("&status="+value));
}
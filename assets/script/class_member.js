let student_data;
$(document).ready(function() {
    load_classroom_data(course_id);
    load_student_data();
    let cb_status = document.getElementById("cb_status");
    if(classroom_id==0){
        cb_status.hidden = false;
    }else{
        cb_status.hidden = true;
    }
});
function load_student_data(){
    let param = {
        course_id:course_id,
        school_year:school_year
    }
    let http = new XMLHttpRequest();
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
    let _param = encode( JSON.stringify( param ) );
    http.send( "student_data=" + _param );
}
function load_classroom_data(course_id){
    let param = {
        course_id:course_id
    }
    let http = new XMLHttpRequest();
    http.open( "POST", 'controller/class_member_controller.php', true );
    http.setRequestHeader( 'Content-type', 'application/x-www-form-urlencoded' );
    http.onreadystatechange = function () {
        if ( this.readyState === XMLHttpRequest.DONE && this.status === 200 ) {
            try {
                let result = JSON.parse( this.responseText );
                
                if(result.success){
                    let classroom = result.body;
                    let cb_classroom = document.getElementById("cb_class");
                    let classroom_str = `<option value='0' `;
                    classroom_str +=(classroom_id==0)?'selected':'';
                    classroom_str +=`>ບໍ່ລະບຸ</option>`;
                    classroom.forEach(item=>{
                        classroom_str +=`<option value='`+item.classroom_id+`' `;
                        classroom_str +=(classroom_id==item.classroom_id)?'selected':'';
                        classroom_str +=`>`+item.classroom_des+`</option>`;
                    });
                    cb_classroom.innerHTML = classroom_str;
                }
                
            } catch (error) {
                Swal.fire( { icon: 'error', html: `<span class="notosans">ເກີດຂໍ້ຜິດພາດທີ່ Server, ກະລຸນາຕິດຕໍ່ຫາ admin ເພື່ອກວດສອບ</span>` } );
            }
        }
    }
    let _param = encode( JSON.stringify( param ) );
    http.send( "classroom_data=" + _param );
}
function render_datatable(){
    let tb_std = document.getElementById("student-data");
    if(student_data){
        let row_str=``;
        let row_no = 0;
        student_data.forEach((el,index )=> {
            let class_data = JSON.parse(el.class_data);
            let param = {
                register_id:el.register_id,
                student_id:el.student_id,
                gender:el.gender,
                name_la:el.name_la,
                surname_la:el.surname_la,
                student_code:el.student_code,
                course_id:el.course_id,
                school_year:el.school_year,
                year_no:el.year_no,
                classroom_id:el.classroom_id,
                create_date:el.create_date,
                last_update:el.last_update,
                user_update:el.user_update,
                register_status:el.register_status,
                class_data:class_data
            }
            if(classroom_id==0){
                if(show_status==1){
                    if(el.classroom_id==null){
                        row_no++;
                        row_str +=`<tr><td class="col-id notosans f12 center">`+row_no+`</td>
                        <td class="notosans f12">`+el.student_code+`</td>
                        <td class="notosans f12">`+el.gender+` `+el.name_la+` `+el.surname_la+`</td>
                        <td class="notosans">`;
                        class_data.forEach(classroom=>{
                            if(classroom.classroom_id==el.classroom_id){
                                row_str +=`<button type="button" class="btn btn-primary btn-icon-text btn-rounded none-select none-outline mr-1">
                                `+classroom.classroom_des+`</button>`;
                            }else{
                                row_str +=`<button onclick="set_classroom('`+encode(JSON.stringify(param))+`',`+classroom.class_no+`,`+classroom.classroom_id+`,`+index+`)" 
                                type="button" class="btn btn-secondary btn-icon-text btn-rounded none-select none-outline mr-1">
                                `+classroom.classroom_des+`</button>`;
                            }
                        });
                        row_str +=`</td></tr>`;
                    }
                }else if(show_status==2){
                    if(el.classroom_id!=null){
                        row_no++;
                        row_str +=`<tr><td class="col-id notosans f12 center">`+row_no+`</td>
                        <td class="notosans f12">`+el.student_code+`</td>
                        <td class="notosans f12">`+el.gender+` `+el.name_la+` `+el.surname_la+`</td>
                        <td class="notosans">`;
                        class_data.forEach(classroom=>{
                            if(classroom.classroom_id==el.classroom_id){
                                row_str +=`<button type="button" class="btn btn-primary btn-icon-text btn-rounded none-select none-outline mr-1">
                                `+classroom.classroom_des+`</button>`;
                            }else{
                                row_str +=`<button onclick="set_classroom('`+encode(JSON.stringify(param))+`',`+classroom.class_no+`,`+classroom.classroom_id+`,`+index+`)" 
                                type="button" class="btn btn-secondary btn-icon-text btn-rounded none-select none-outline mr-1">
                                `+classroom.classroom_des+`</button>`;
                            }
                        });
                        row_str +=`</td></tr>`;
                    }
                }else{
                    row_no++;
                    row_str +=`<tr><td class="col-id notosans f12 center">`+row_no+`</td>
                    <td class="notosans f12">`+el.student_code+`</td>
                    <td class="notosans f12">`+el.gender+` `+el.name_la+` `+el.surname_la+`</td>
                    <td class="notosans">`;
                    class_data.forEach(classroom=>{
                        if(classroom.classroom_id==el.classroom_id){
                            row_str +=`<button type="button" class="btn btn-primary btn-icon-text btn-rounded none-select none-outline mr-1">
                            `+classroom.classroom_des+`</button>`;
                        }else{
                            row_str +=`<button onclick="set_classroom('`+encode(JSON.stringify(param))+`',`+classroom.class_no+`,`+classroom.classroom_id+`,`+index+`)" 
                            type="button" class="btn btn-secondary btn-icon-text btn-rounded none-select none-outline mr-1">
                            `+classroom.classroom_des+`</button>`;
                        }
                    });
                    row_str +=`</td></tr>`;
                }
            }else{
                if(el.classroom_id==classroom_id){
                    row_no++;
                    row_str +=`<tr><td class="col-id notosans f12 center">`+row_no+`</td>
                    <td class="notosans f12">`+el.student_code+`</td>
                    <td class="notosans f12">`+el.gender+` `+el.name_la+` `+el.surname_la+`</td>
                    <td class="notosans">`;
                    class_data.forEach(classroom=>{
                        if(classroom.classroom_id==el.classroom_id){
                            row_str +=`<button type="button" class="btn btn-primary btn-icon-text btn-rounded none-select none-outline mr-1">
                            `+classroom.classroom_des+`</button>`;
                        }else{
                            row_str +=`<button onclick="set_classroom('`+encode(JSON.stringify(param))+`',`+classroom.class_no+`,`+classroom.classroom_id+`,`+index+`)" 
                            type="button" class="btn btn-secondary btn-icon-text btn-rounded none-select none-outline mr-1">
                            `+classroom.classroom_des+`</button>`;
                        }
                    });
                    row_str +=`</td></tr>`;
                }
            }
            
        });
        tb_std.innerHTML = row_str;
    }
}
function decode( text ) {
    return text
        .replaceAll( "#amp;",'&' )
        .replaceAll( "#quot;",'"' )
        .replaceAll( "#plus;",'+' )
        .replaceAll( "#039;","'" )
}
function course_selected(value){
    window.location.href="template?page=class_member&course_id="+value+((show_status==="1")?"":("&status="+show_status));
}
function status_change(value){
    window.location.href="template?page=class_member&course_id="+course_id+((value==="1")?"":("&status="+value));
}
function classroom_selected(value){
    window.location.href="template?page=class_member&course_id="+course_id+((value!=0)?("&classroom_id="+value):((show_status==="1")?"":("&status="+show_status)));
}
function set_classroom(selectedData,class_no,classroom_id,index){
    Swal.fire( {
        html: '<h2 class="notosans">ກະລຸນາລໍຖ້າ !</h2><h4 class="notosans">ກໍາລັງອັບໂຫຼດຂໍ້ມູນ</h4>',
        timer: 300,
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading()
        }
    })
    let data = JSON.parse(decode(selectedData));
    let param = {
        student_data:data,
        class_no:class_no
    }
    let http = new XMLHttpRequest();
    http.open( "POST", 'controller/class_member_controller.php', true );
    http.setRequestHeader( 'Content-type', 'application/x-www-form-urlencoded' );
    http.onreadystatechange = function () {
        if ( this.readyState === XMLHttpRequest.DONE && this.status === 200 ) {
            try {
                let result = JSON.parse( this.responseText );
                if(result.success){
                    let std_data = data;
                    std_data.class_data = JSON.stringify(std_data.class_data);
                    std_data.classroom_id = classroom_id;
                    student_data[index] = std_data;
                    render_datatable();
                }else{
                    Swal.fire( { icon: 'error', html: `<span class="notosans">`+result.message+`</span>` } );
                }
                
            } catch (error) {
                Swal.fire( { icon: 'error', html: `<span class="notosans">`+error.message+`</span>` } );
            }
            Swal.resumeTimer();
            console.log("%c Respon Data:","color:red; font-size:2rem;",this.responseText);
        }
        Swal.resumeTimer();
    }
    let _param = encode( JSON.stringify( param ) );
    http.send( "setClassroomData=" + _param );
}
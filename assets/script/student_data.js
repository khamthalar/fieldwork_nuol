$(document).ready(function(){
    console.log("course_data:",course_data);
    show(loading);
    let param = {};
    if(!filter_data){
        if(course_data.length>0){
            filter_label.innerHTML = "*ນັກສຶກສາ"+course_data[0].scheme_des +"-"+course_data[0].course_des+", ປີ 1";
        }
        param={
            course_id:course_data[0].course_id,
            course_des:course_data[0].course_des,
            selected_year:1,
            classroom_id:0,
            classroom_des:"ບໍ່ລະບຸ",
            school_year:school_year
        }
    }else {
        let lb_str = (Number(filter_data.classroom_id)==0)?(", ປີ "+filter_data.selected_year):(", ຫ້ອງ "+filter_data.classroom_des);
        filter_label.innerHTML = "*ນັກສຶກສາ"+filter_data.course_des +lb_str;
        param={
            course_id:filter_data.course_id,
            course_des:filter_data.course_des,
            selected_year:filter_data.selected_year,
            classroom_id:filter_data.classroom_id,
            classroom_des:filter_data.classroom_des,
            school_year:school_year
        }
    }
    let data = loadStudentData(param);
    data.then(data_str=>{
        all_students = JSON.parse(data_str);
        render_std(all_students);
        console.log("response:",all_students);
        hide(loading);
    });
});

async function setCourseOption(course_data){
    let course_id,duration_year;
    let selected_year = 1;
    let selected_class = 0;
    if(filter_data){
        course_id = filter_data.course_id;
        courseId = course_id;
        selected_year = filter_data.selected_year;
        selected_class = filter_data.classroom_id;
    }else{
        if(course_data.length>0)course_id = course_data[0].course_id;
    }
    if(course_data.length>0) {
        let cbCourse = document.getElementById("st_course");
        cbCourse.innerHTML = ``;
        let option = ``;
        await course_data.forEach((item, index) => {
            let selected = "";
            if(item.course_id===course_id){
                selected = "selected";
                duration_year = item.duration_year;
            }
            option += `<option value="` + item.course_id + `,` + item.duration_year + `" `+selected+`>` + item.scheme_des + `-` + item.course_des + `</option>`;
        });
        cbCourse.innerHTML = option;
        await setYearOption(duration_year,selected_year);
        await setClassroomOption(course_id,selected_year,selected_class);
    }
}

async function setYearOption(duration_year,selected_year){
    console.log("here",selected_year);
    let cbYear = document.getElementById("cb_st_year");
    cbYear.innerHTML = ``;
    let option = ``;
    for(let year=1;year<=duration_year;year++){
        let selected = (year===Number(selected_year))?"selected":"";
        option +=`<option value="`+year+`" `+selected+`>ປີ `+year+`</option>`;
    }
    cbYear.innerHTML = option;
}
async function setClassroomOption(course_id,year_no,selected_class){
    let cbClassroom = document.getElementById("cb_st_classroom");
    let classroom_data = [];
    classroom_data = all_classrooms.filter((classroom)=>{if(classroom.year_no==year_no && classroom.course_id == course_id) return classroom;});
    console.log(all_classrooms);
    console.log(classroom_data);
    cbClassroom.innerHTML = ``;
    let selected = (Number(selected_class)==0)?"selected":"";
    let option = `<option value=0 `+selected+`>ບໍ່ລະບຸ</option>`;
    if(classroom_data) {
        classroom_data.forEach((item, index) => {
            let selected = (Number(selected_class) == item.classroom_id) ? "selected" : "";
            option += `<option value=` + item.classroom_id + ` ` + selected + `>` + item.classroom_des + `</option>`;
        });
    }
    cbClassroom.innerHTML = option;
}
async function courseChanged(course){
    let course_data = course.split(',');
    courseId = course_data[0];
    await setYearOption(course_data[1],1);
    await setClassroomOption(courseId,1,0);
}
async function yearChanged(year){
    console.log("year:",year);
    await setClassroomOption(courseId,year,0);
}
async function loadStudentData(param){
    let promise = new Promise(function(resolve) {
        try {
            let http = new XMLHttpRequest();
            http.open( "POST", 'controller/student_controller.php', true );
            http.setRequestHeader( 'Content-type', 'application/x-www-form-urlencoded' );
            http.onreadystatechange = function () {
                if ( this.readyState === XMLHttpRequest.DONE && this.status === 200 ) {
                    resolve(this.responseText);
                }
            }
            var _param = encode( JSON.stringify( param ) );
            http.send( "stdFilterData=" + _param );
        }catch (e) {
            console.log("error:",e);
            resolve("[]");
        }
    });
    return promise;
}
async function applyFilter(){
    show(loading);
    $('#stdfilter').modal('hide');
    let cb_course = document.getElementById('st_course').value;
    let cb_year = document.getElementById('cb_st_year').value;
    let cb_classroom = document.getElementById('cb_st_classroom').value;
    let courseid = cb_course.split(',')[0];
    let course_des = $("#st_course option:selected").text();
    let classroom_des = $("#cb_st_classroom option:selected").text();
    let param = {
        course_id:courseid,
        course_des:course_des,
        selected_year:cb_year,
        classroom_id:cb_classroom,
        classroom_des:classroom_des,
        school_year:school_year
    }
    sessionStorage.setItem("std_filter",JSON.stringify(param));
    filter_data = param;
    let lb_str = (Number(filter_data.classroom_id)==0)?(", ປີ "+filter_data.selected_year):(", ຫ້ອງ "+filter_data.classroom_des);
    filter_label.innerHTML = "*ນັກສຶກສາ"+filter_data.course_des +lb_str;
    let data_str = await loadStudentData(param);
    all_students = JSON.parse(data_str);
    await render_std(all_students);
    console.log("response:",all_students);
    hide(loading);
}
function goto_excel_update(){
    window.location.href='template?page=student&sub_page=student_data_excel_update';
}

async function render_std(data){
    std_data.innerHTML = ``;
    let data_str = ``;
    await data.forEach(async (std,index)=>{
        data_str +=`<tr> <td class="col-id notosans f12 center">`+(index+1)+`</td><td class="notosans f12">`;
        data_str += std.student_code+`</td><td class="notosans f12">`;
        data_str += std.gender+` `+std.name_la+` `+std.surname_la+`</td>`;
        data_str +=`<td> `+std.classroom_des+` </td>`;
        data_str += `<td> <button type="button" class="btn btn-warning btn-icon-text btn-rounded none-select none-outline">
                            <i class="fas fa-pencil-alt"></i>
                          </button>
                          <button type="button" class="btn btn-primary btn-icon-text btn-rounded none-select none-outline">
                            <i class="fas fa-eye"></i>
                          </button>
                          <button type="button" class="btn btn-danger btn-icon-text btn-rounded none-select none-outline" >
                          <i class="fas fa-trash-alt"></i> 
                          </button>
                        </td></tr>`;
    });
    std_data.innerHTML = data_str;
}
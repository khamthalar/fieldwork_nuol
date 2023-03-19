$(document).ready(function(){
    console.log("course_data:",course_data);
    show(loading);
    let param = {};
    if(!filter_data){
        if(course_data.length>0){
            filter_label.innerHTML = "*ນັກສຶກສາ"+course_data[0].scheme_des +"-"+course_data[0].course_des+", ປີ 1";
            filter_str = "ຂໍ້ມູນນັກສຶກສາ"+course_data[0].scheme_des +"-"+course_data[0].course_des+", ປີ 1";
        }
        courseId = course_data[0].course_id;
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
        filter_str = "ຂໍ້ມູນນັກສຶກສາ"+filter_data.course_des +lb_str;
        courseId = filter_data.course_id;
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
        student_data = all_students;
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
    courseId = courseid;
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
    filter_str = "ຂໍ້ມູນນັກສຶກສາ"+filter_data.course_des +lb_str;
    let data_str = await loadStudentData(param);
    all_students = JSON.parse(data_str);
    await render_std(all_students);
    student_data = all_students;
    console.log("response:",all_students);
    hide(loading);
}
function goto_excel_update(){
    window.location.href='template?page=student&sub_page=student_data_excel_update&course_id='+courseId;
}

async function render_std(data){
    std_data.innerHTML = ``;
    let data_str = ``;
    await data.forEach(async (std,index)=>{
        data_str +=`<tr> <td class="col-id notosans f12 center">`+(index+1)+`</td><td class="notosans f12">`;
        data_str += std.student_code+`</td><td class="notosans f12">`;
        data_str += std.gender+` `+std.name_la+` `+std.surname_la+`</td>`;
        data_str +=`<td> `+std.classroom_des+` </td>`;
        data_str += `<td> <button type="button" class="btn btn-warning btn-icon-text btn-rounded none-select none-outline"
                            onclick="openUpdateForm(
                                '`+encode(std.student_id)+`',
                                '`+encode(std.student_code)+`',
                                '`+encode(std.gender)+`',
                                '`+encode(std.name_la)+`',
                                '`+encode(std.surname_la)+`',
                                '`+encode(std.name_en)+`',
                                '`+encode(std.surname_en)+`',
                                '`+encode(std.date_of_birthday)+`',
                                '`+encode(std.birth_address_la)+`',
                                '`+encode(std.birth_address_en)+`',
                                '`+encode(std.remark)+`')">
                            <i class="fas fa-pencil-alt"></i>
                          </button>
                          <button type="button" class="btn btn-primary btn-icon-text btn-rounded none-select none-outline"
                          data-student_code="`+std.student_code+`" 
                          data-fullname_la="`+std.gender+` `+std.name_la+` `+std.surname_la+`" 
                          data-fullname_en="`+std.name_en+` `+std.surname_en+`" 
                          data-birthdate="`+std.date_of_birthday+`" 
                          data-classroom_des="`+std.classroom_des+`" 
                          data-address_la="`+std.birth_address_la+`" 
                          data-address_en="`+std.birth_address_en+`"
                          data-bs-toggle="modal" data-bs-target="#stdinfo" data-bs-backdrop="static">
                            <i class="fas fa-eye"></i>
                          </button>
                          <button type="button" class="btn btn-danger btn-icon-text btn-rounded none-select none-outline">
                          <i class="ti-timer"></i>
                          </button>
                          <button type="button" class="btn btn-primary btn-icon-text btn-rounded none-select none-outline"
                          data-student_code = "`+std.student_code+`"
                          data-bs-toggle="modal" data-bs-target="#student_log">
                          <i class="ti-menu"></i>
                        </button>
                        </td>`;
        data_str +=`<td class="status notosans center">`+std.student_status+`</td></tr>`;
    });
    std_data.innerHTML = data_str;
}
function openUpdateForm(student_id,student_code, gender, name_la, surname_la, name_en, surname_en, 
    date_of_birthday, birth_address_la, birth_address_en, remark ){
        let param = {
            student_id,
            student_code,
            gender,
            name_la,
            surname_la,
            name_en,
            surname_en,
            date_of_birthday,
            birth_address_la,
            birth_address_en,
            remark
        }
    sessionStorage.setItem('std_param',JSON.stringify(param));
    location.href = 'template?page=student&sub_page=edit_student_form';
}
async function handlersearch(searchtext){

}
async function print_data(){

}
async function download_data(){
    /* set up XMLHttpRequest */
    var url = "assets/files/student_form_data_update.xlsx";
    var oReq = new XMLHttpRequest();

    oReq.open("GET", url, true);
    oReq.responseType = "arraybuffer";

    oReq.onload = async function(e) {
        var arraybuffer = oReq.response;

        /* convert data to binary string */
        var data = new Uint8Array(arraybuffer);
        var arr = new Array();
        for(var i = 0; i != data.length; ++i) arr[i] = String.fromCharCode(data[i]);
        var bstr = arr.join("");

        /* Call XLSX */
        let workbook = XLSX.read(bstr, {type:"binary"});
        let worksheet = workbook.Sheets[workbook.SheetNames[0]];
        let border ={
            top:{style:'thin',color:{rgb:'000000'}},
            bottom:{style:'thin',color:{rgb:'000000'}},
            left:{style:'thin',color:{rgb:'000000'}},
            right:{style:'thin',color:{rgb:'000000'}},
        }
        let center = {
            vertical:"center",
            wrapText:true,
            horizontal:"center"
        }
        
        let style = {font: { name: 'Phetsarath OT'},border:border};   
        let title_style = {
            font: { 
                name: 'Phetsarath OT',
                sz:'16', 
                bold:true,
                color: { r: 139, g: 0, b: 0 } 
            },
            alignment:{
                horizontal:"center"
            }
        }
        let h_style = {
            font: { 
                name: 'Phetsarath OT',
                sz:'12', 
                bold:true,
                color: { r: 139, g: 0, b: 0 } 
            },
            alignment:center,
            border:border
        }
        // console.log(student_data.length)
        console.log(filter_str);
        worksheet['A2'].s=title_style;
        worksheet['A2'].v=filter_str;
        worksheet['A3'].s=h_style;
        worksheet['B3'].s=h_style;
        worksheet['C3'].s=h_style;
        worksheet['D3'].s=h_style;
        worksheet['E3'].s=h_style;
        worksheet['F3'].s=h_style;
        worksheet['G3'].s=h_style;
        worksheet['H3'].s=h_style;
        worksheet['I3'].s=h_style;
        worksheet['J3'].s=h_style;
        worksheet['K3'].s=h_style;
        if(student_data.length>0){
            student_data.forEach((item,index)=>{
                let date_cell;
                if(item.date_of_birthday){
                    let birthdate = new Date(item.date_of_birthday);
                    let date_val = birthdate.getTime() / (24 * 60 * 60 * 1000) + 25569;
                    date_cell = {v: date_val, s: style, t: 'n', z: 'd/m/yyyy'};
                }else{
                    date_cell = {v: '', s: style}
                }

                
                worksheet['A'+(index+4)] = {v: String(index+1), s: {font: { name: 'Phetsarath OT'},alignment:center,border:border}};
                worksheet['B'+(index+4)] = {v: String(item.student_code), s: style};
                worksheet['C'+(index+4)] = {v: String(item.gender), s: style};
                worksheet['D'+(index+4)] = {v: String(item.name_la), s: style};
                worksheet['E'+(index+4)] = {v: String(item.surname_la), s: style};
                worksheet['F'+(index+4)] = {v: String(item.name_en), s: style};
                worksheet['G'+(index+4)] = {v: String(item.surname_en), s: style};
                worksheet['H'+(index+4)] = date_cell;
                worksheet['I'+(index+4)] = {v: String(item.birth_address_la), s: style};
                worksheet['J'+(index+4)] = {v: String(item.birth_address_en), s: style};
                worksheet['K'+(index+4)] = {v: String(item.remark), s: style};
            })
        }
        console.log(workbook);
        var wopts = { bookType:'xlsx', bookSST:true, type:'binary' };
        var wbout = XLSX.write(workbook,wopts);
        let today = new Date();
        let filename = "studentdata"+today.getFullYear()+today.getMonth()+today.getDate()+today.getHours()+today.getMinutes()+".xlsx";
        saveAs(new Blob([s2ab(wbout)],{type:""}), filename);
        
    }
    oReq.send();
}

function s2ab(s) {
    var buf = new ArrayBuffer(s.length);
    var view = new Uint8Array(buf);
    for (var i=0; i!=s.length; ++i) view[i] = s.charCodeAt(i) & 0xFF;
    return buf;
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
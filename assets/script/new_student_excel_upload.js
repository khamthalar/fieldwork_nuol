function open_file() {
    document.getElementById( 'upload' ).addEventListener( 'change', handleFileSelect, false );
    $( '#upload' ).click();
}
function handleFileSelect( evt ) {
    var files = evt.target.files;
    var xl2json = new ExcelToJSON();
    xl2json.parseExcel( files[ 0 ] );
}
var ExcelToJSON = function () {
    this.parseExcel = function ( file ) {
        document.getElementById( 'path' ).innerHTML = file.name;
        var reader = new FileReader();
        reader.onload = function ( e ) {
            var data = e.target.result;
            var workbook = XLSX.read( data, { type: 'binary' } );
            var worksheet = workbook.Sheets[ workbook.SheetNames[ 0 ] ];
            const student_data = XLSX.utils.sheet_to_json( worksheet, {
                header: 1,
                defval: ""
            } );
            var tb_body = document.getElementById( 'tb_body' );
            tb_body.innerHTML = ``;
            try {
                console.log(student_data);
                if ( student_data[ 2 ][ 0 ].toLowerCase().replace("\r","") == ("ລ/ດ\nNo").toLowerCase()
                    && student_data[ 2 ][ 1 ].toLowerCase().replace("\r","") == ("ລະຫັດນັກສຶກສາ\nStudent ID").toLowerCase()
                    && student_data[ 2 ][ 2 ] == ""
                    && student_data[ 2 ][ 3 ] == "ເພດ"
                    && student_data[ 2 ][ 4 ] == "ຊື່ ແລະ ນາມສະກຸນ"
                    && student_data[ 2 ][ 5 ] == ""
                    && student_data[ 2 ][ 6 ].toLowerCase() == ("REMARK").toLowerCase()
                ) {
                    var row_str = ``;
                    st_data = [];
                    for ( let i = 3; i < student_data.length; i++ ) {
                        if ( student_data[ i ][ 1 ] != "" || student_data[ i ][ 2 ] != "" ) {
                            row_str += `
                            <tr>
                                <td class='notosans f12 center'>`+ student_data[ i ][ 0 ] + `</td>
                                <td class='notosans f12'>`+ student_data[ i ][ 1 ] + `</td>
                                <td class='notosans f12'>`+ student_data[ i ][ 2 ] + `</td>
                                <td class='notosans f12 center'>`+ student_data[ i ][ 3 ] + `</td>
                                <td class='notosans f12'>`+ student_data[ i ][ 4 ] + `</td>
                                <td class='notosans f12'>`+ student_data[ i ][ 5 ] + `</td>
                                <td class='notosans f12' colspan='2'>`+ student_data[ i ][ 6 ] + `</td>
                            </tr>`;
                            var item = {
                                student_code: student_data[ i ][ 1 ] + student_data[ i ][ 2 ],
                                gender: student_data[ i ][ 3 ],
                                name_la: student_data[ i ][ 4 ],
                                surname_la: student_data[ i ][ 5 ],
                                remark: student_data[ i ][ 6 ]
                            };
                            st_data.push( item );
                        }
                    }
                    tb_body.innerHTML = row_str;
                    if ( st_data.length != 0 ) {
                        btn_upload.hidden = false;
                    } else {
                        btn_upload.hidden = true;
                    }
                } else {
                    Swal.fire( { icon: 'warning', html: `<span class="notosans">ຂໍ້ມູນບໍ່ຖືກຕ້ອງ</span>` } );
                    st_data = [];
                    btn_upload.hidden = true;
                }
            } catch ( error ) {
                // Swal.fire({icon:'success',html:'<span class=notosans>ບັນທຶກຂໍ້ມູນສໍາເລັດ!</span>',allowOutsideClick: false}).then((result) => {if (result.isConfirmed) {window.location.href='template?page=classroom&sub_page=class_member".$class_id_param.$class_des_param."'}});
                Swal.fire( { icon: 'error', html: `<span class="notosans">` + error.message + `</span>` } );
                st_data = [];
                btn_upload.hidden = true;
            }
        };

        reader.onerror = function ( ex ) {
            Swal.fire( { icon: 'error', html: `<span class="notosans">ເກີດຂໍ້ຜິດພາດລະຫວ່າງການເປີດຟາຍ</span>` } );
            st_data = [];
            btn_upload.hidden = true;
        };
        reader.readAsBinaryString( file );
    };
}
function upload_student() {
    var param = {
        username: _username,
        course_id: _course_id,
        duration_year: _duration_year,
        data: st_data
    }
    // console.log(param);
    Swal.fire( {
        html: '<h2 class="notosans">ກະລຸນາລໍຖ້າ !</h2><h4 class="notosans">ກໍາລັງອັບໂຫຼດຂໍ້ມູນ</h4>',
        timer: 300,
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading()
        }
    } ).then( () => {
        var row_str = ``;
        var index = 0;
        st_data.forEach( student => {
            index++;
            var remark = '';
            if(student.remark)remark=student.remark;
            var style=``;
            if(student.status=="ລະຫັດນັກສຶກສາຊໍ້າກັນ"){
                style = `style="background-color:yellow;"`;
            }else if(student.status=="success"){
                style = `style="color:green;"`;
            }else{
                style = `style="color:red;"`;
            }
            row_str += `
                            <tr `+style+` >
                                <td class='notosans f12 center'>`+ index + `</td>
                                <td class='notosans f12'>`+ student.student_code.substring(0,4) + `</td>
                                <td class='notosans f12'>`+ student.student_code.substring(4,student.student_code.length) + `</td>
                                <td class='notosans f12 center'>`+ student.gender + `</td>
                                <td class='notosans f12'>`+ student.name_la + `</td>
                                <td class='notosans f12'>`+ student.surname_la + `</td>
                                <td class='notosans f12' colspan='2'>`+ remark + `</td>
                                <td class='notosans f12' colspan='2'>`+ student.status + `</td>
                            </tr>`;
        } );
        tb_body.innerHTML = row_str;
        btn_upload.hidden = true;
        st_data = [];
        Swal.fire( { icon: 'success', html: `<span class="notosans">ອັບໂຫຼດຂໍ້ມູນແລ້ວ</span>` } );
    } );
    Swal.stopTimer();
    var http = new XMLHttpRequest();
    http.open( "POST", 'controller/new_student_controller.php', true );
    http.setRequestHeader( 'Content-type', 'application/x-www-form-urlencoded' );
    http.onreadystatechange = function () {
        if ( this.readyState === XMLHttpRequest.DONE && this.status === 200 ) {
            st_data = JSON.parse( this.responseText );
            console.log(st_data);
            Swal.resumeTimer();
        }
    }
    var _param = encode( JSON.stringify( param ) );
    http.send( "upload_student=" + _param );
}
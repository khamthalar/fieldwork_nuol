// student data excel update
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
                // console.log(student_data);
                if((student_data[2][0]).toLowerCase().replace("\r","")==("ລ/ດ\nNo").toLowerCase()
                && (student_data[2][1]).toLowerCase().replace("\r","")==("ລະຫັດນັກສຶກສາ\nStudent ID").toLowerCase()
                && (student_data[2][2]).toLowerCase()==("ເພດ").toLowerCase()
                && (student_data[2][3]).toLowerCase()==("ຊື່ ແລະ ນາມສະກຸນ").toLowerCase()
                && (student_data[2][4]).toLowerCase()==("").toLowerCase()
                && (student_data[2][5]).toLowerCase()==("Name and Surname").toLowerCase()
                && (student_data[2][6]).toLowerCase()==("").toLowerCase()
                && (student_data[2][7]).toLowerCase()==("ວັນເດືອນປີເກີດ").toLowerCase()
                && (student_data[2][8]).toLowerCase()==("ສະຖານທີ່ເກີດ (ແຂວງ)").toLowerCase()
                && (student_data[2][9]).toLowerCase()==("address of birth (province)").toLowerCase()
                && (student_data[2][10]).toLowerCase()==("REMARK").toLowerCase()){
                    var row_str = ``;
                    st_data = [];
                    for ( let i = 3; i < student_data.length; i++ ) {
                        let birthdate_obj = XLSX.SSF.parse_date_code(student_data[ i ][ 7 ], { date1904: false });;
                        let birthdate = '';
                        if(birthdate_obj?.y!=1900){
                            try{
                                birthdate = birthdate_obj.y+"-"+birthdate_obj.m+"-"+birthdate_obj.d;
                            }catch(e){
                                console.log(e);
                                birthdate = '';
                            }
                        }
                        if ( student_data[ i ][ 1 ] != "" && student_data[ i ][ 2 ] != "" ) {
                            row_str += `
                            <tr>
                                <td class='notosans f12 center'>`+ student_data[ i ][ 0 ] + `</td>
                                <td class='notosans f12'>`+ student_data[ i ][ 1 ] + `</td>
                                <td class='notosans f12 center'>`+ student_data[ i ][ 2 ] + `</td>
                                <td class='notosans f12'>`+ student_data[ i ][ 3 ] + `</td>
                                <td class='notosans f12'>`+ student_data[ i ][ 4 ] + `</td>
                                <td class='notosans f12'>`+ student_data[ i ][ 5 ] + `</td>
                                <td class='notosans f12'>`+ student_data[ i ][ 6 ] + `</td>
                                <td class='notosans f12'>`+ birthdate + `</td>
                                <td class='notosans f12'>`+ student_data[ i ][ 8 ] + `</td>
                                <td class='notosans f12'>`+ student_data[ i ][ 9 ] + `</td>
                                <td class='notosans f12' colspan='2'>`+ student_data[ i ][ 10 ] + `</td>
                            </tr>`;
                            var item = {
                                course_id : _course_id,
                                student_code : student_data[i][1],
                                name_la : student_data[i][3],
                                surname_la : student_data[i][4],
                                name_en : student_data[i][5],
                                surname_en : student_data[i][6],
                                gender : student_data[i][2],
                                address_la : student_data[i][8],
                                address_en : student_data[i][9],
                                birthdate : birthdate,
                                remark : student_data[i][10],
                                
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

function update_student_data(){
    var param={
        username:_username,
        data:st_data
    }
    Swal.fire( {
        html: '<h2 class="notosans">ກະລຸນາລໍຖ້າ !</h2><h4 class="notosans">ກໍາລັງອັບໂຫຼດຂໍ້ມູນ</h4>',
        timer: 300,
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading()
        }
    } ).then( () => {
        console.log(st_data);
        var row_str = ``;
        st_data.forEach( (student,index) => {
            var style=``;
            if(student.status=="ລະຫັດນັກສຶກສາບໍ່ຖຶກຕ້ອງ"){
                style = `style="background-color:yellow;"`;
            }else if(student.status=="success"){
                style = `style="color:green;"`;
            }else{
                style = `style="color:red;"`;
            }
            row_str += `
                <tr `+style+` >
                    <td class='notosans f12 center'>`+ index+1 + `</td>
                    <td class='notosans f12'>`+ student.student_code + `</td>
                    <td class='notosans f12 center'>`+ student.gender + `</td>
                    <td class='notosans f12'>`+ student.name_la + `</td>
                    <td class='notosans f12'>`+ student.surname_la + `</td>
                    <td class='notosans f12'>`+ student.name_en + `</td>
                    <td class='notosans f12'>`+ student.surname_en + `</td>
                    <td class='notosans f12'>`+ student.birthdate + `</td>
                    <td class='notosans f12'>`+ student.address_la + `</td>
                    <td class='notosans f12'>`+ student.address_en + `</td>
                    <td class='notosans f12' colspan='2'>`+ student.remark + `</td>
                    <td class='notosans f12' colspan='2'>`+ student.status + `</td>
                </tr>`;
        })
        tb_body.innerHTML = row_str;
        btn_upload.hidden = true;
        st_data = [];
        Swal.fire( { icon: 'success', html: `<span class="notosans">ອັບໂຫຼດຂໍ້ມູນແລ້ວ</span>` } );
    })
    Swal.stopTimer();
    var http = new XMLHttpRequest();
    http.open( "POST", 'controller/student_controller.php', true );
    http.setRequestHeader( 'Content-type', 'application/x-www-form-urlencoded' );
    http.onreadystatechange = function () {
        if ( this.readyState === XMLHttpRequest.DONE && this.status === 200 ) {
            st_data = JSON.parse( this.responseText );
            console.log(st_data);
            Swal.resumeTimer();
        }
    }
    console.log(param);
    var _param = encode( JSON.stringify( param ) );
    http.send( "upload_student_update=" + _param );
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